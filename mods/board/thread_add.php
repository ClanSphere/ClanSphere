<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

$check_pw = 1;
$class = 'leftc';
$board_id = empty($_REQUEST['id']) ? $_REQUEST['where'] : $_REQUEST['id'];
settype($board_id,'integer');
include('mods/board/functions.php');

$from = 'board frm INNER JOIN {pre}_categories cat ON frm.categories_id = cat.categories_id';
#$from .= " INNER JOIN {pre}_members mem ON frm.squads_id = mem.squads_id AND mem.users_id = '" . $account['users_id'] . "'";
$select = 'frm.board_pwd AS board_pwd, frm.board_name AS board_name, cat.categories_name AS categories_name, ';
$select .= 'frm.board_id AS board_id, cat.categories_id AS categories_id, frm.board_access AS board_access, frm.squads_id AS squads_id';
$where = "frm.board_id = '" . $board_id . "'";
$cs_thread = cs_sql_select(__FILE__,$from,$select,$where,0,0,1);
if(!empty ($cs_thread['board_pwd'])) {
	$where = "users_id = '" . $account['users_id'] . "' AND board_id = '" . $cs_thread['board_id'] . "'";
	$check_pw = cs_sql_count(__FILE__,'boardpws',$where);
}
if(!empty($cs_thread['squads_id'])) {
  $where = "squads_id = '" . $cs_thread['squads_id'] . "' AND users_id = '" .$account['users_id'] . "'";
  $check_sq = cs_sql_count(__FILE__,'members',$where);
}

//Sicherheitsabfrage Beginn
$errorpage = 0;
if(empty($board_id) || (count($cs_thread) == 0)) { $errorpage++; }
if($account['access_board'] < $cs_thread['board_access'] OR empty($check_pw)) { 
  $errorpage = empty($check_sq) ? 1 : 0;
}
if(!empty($errorpage)) {
  return errorPage('thread_add');
}
//Sicherheitsabfrage Ende

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] .' - '. $cs_lang['head'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
$head  = cs_link($cs_lang['board'],'board','list','normalb') .' -> ';
$head .= cs_link($cs_thread['categories_name'],'board','list','where=' .$cs_thread['categories_id'],'normalb') .' -> ';
$head .= cs_link($cs_thread['board_name'],'board','listcat','where=' .$cs_thread['board_id'],'normalb');
echo $head;
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

$class = 'leftc';

$thread_error = 3;
$thread_form = 1;
$thread_time = cs_time();
$thread_headline = '';
$thread_text = '';
$votes_question = '';
$cs_board_opt = cs_sql_option(__FILE__,'board');
$max_text = $cs_board_opt['max_text'];
$max_size = $cs_board_opt['file_size'];
$filetypes = explode(',',$cs_board_opt['file_types']);
$message = '';


if(!empty($account['users_id'])) {
	$thread_userid = $account['users_id'];
	$thread_error--;
}
if(!empty($_POST['thread_headline'])) {
	$thread_headline = $_POST['thread_headline'];
	$thread_error--;
}
if(!empty($_POST['thread_text']))
{
	$thread_text = $_POST['thread_text'];
	$thread_text_count = strlen($thread_text);
	if($thread_text_count <= $max_text)
	{
		$thread_text = $_POST['thread_text'];
		$thread_error--;
	}
	else
	{
		$thread_text = $_POST['thread_text'];
		$count = $thread_text_count - $max_text;
		$message .= $cs_lang['text_to_long'] . $thread_text_count . $cs_lang['text_to_long_2'] . $count . $cs_lang['text_to_long_3'] . cs_html_br(1);
	}
  $thread_text = preg_replace_callback("=\[img\](.*?)\[/img\]=si","cs_abcode_resize",$thread_text);
  $thread_text = preg_replace_callback("=\[img width\=(.*?) height\=(.*?)\](.*?)\[/img\]=si","cs_abcode_resize",$thread_text);
}


$votes_access = isset($_POST['votes_access']) ? $_POST['votes_access'] : '0';
$votes_question = isset($_POST['votes_question']) ? $_POST['votes_question'] : '';
if(cs_datepost('votes_end','unix'))
{
	$votes_end = cs_datepost('votes_end','unix');
}
else
{
	$votes_end = time() + 604800;
}
$votes = isset($_POST['votes']) ? $_POST['votes'] : 0;
if(isset($_POST['new_votes']))
{
	$votes = '1';
}
$run_loop = isset($_POST['run_loop']) ? $_POST['run_loop'] : 0;
$cs_votes['votes_election'] = '';
$votes_loop = '';
if(isset($_POST['votes_question']))
{
	if(!empty($votes_question))
	{
		for($run=0; $run < $run_loop; $run++)
		{
		  	$num = $run+1;
			if(!empty($_POST["votes_election_$num"]))
			{
				$cs_votes["votes_election"] = $cs_votes["votes_election"] . "\n" . $_POST["votes_election_$num"];
				$votes_loop++;
			}
		}
		if(!empty($votes_question))
		{
			if(!empty($cs_votes['votes_election']) AND $votes_loop >= '2')
			{
				$votes_election = $cs_votes['votes_election'];
			}
			else
			{
				$message .= $cs_lang['error_election'] . cs_html_br(1);
				$thread_error++;
			}
		}
	}
	else
	{
		$votes = 0;
	}
}
$files = isset($_POST['files']) ? $_POST['files'] : 0;
if(isset($_POST['new_file'])) {
	$files = '1';
}
$run_loop_files = isset($_POST['run_loop_files']) ? $_POST['run_loop_files'] : 0;
$a = '0';
$b = '1';
for($run=0; $run < $run_loop_files; $run++) {
	$num = $run+1;
	if(!empty($_FILES["file_$num"]['name'])) {
		$board_files_name = $cs_files[$run]['boardfiles_name'] = $_FILES["file_$num"]['name'];
		$ext = substr($board_files_name,strlen($board_files_name)+1-strlen(strrchr($board_files_name,'.')));
		if($_FILES["file_$num"]['size'] > $max_size) {
			$message .= $cs_lang['error_filesize'] . cs_html_br(1);
			$thread_error++;
			$file_error[$num] = '1';
		}
		$check_type = '';
    $count_filetypes = count($filetypes);
		for($run_a=0; $run_a < $count_filetypes; $run_a++) {
			if('0' == strcasecmp($filetypes[$run_a], $ext)) {
				$check_type = 1;
			}
		}
		if($check_type != 1) {
			$message .= $cs_lang['error_filetype'] . cs_html_br(1);
			$thread_error++;
			$file_error[$num] = '1';
		}
		if(!empty($file_error[$num])) {
			echo cs_html_table(1,'forum',1);
			echo cs_html_roco(1,'leftc');
			echo cs_icon('important');
			echo $cs_lang['error_subheader'];
			echo cs_html_roco(0);
			echo cs_html_roco(1,'leftb');
			echo $message;
			echo cs_html_roco(0);
			echo cs_html_table(0);
			echo cs_html_br(1);
		}
	}
	if(!empty($_FILES["file_$num"]['name']) AND empty($file_error[$num])) {
		$file_name[$num] = $_FILES["file_$num"]['name'];

		$hash = '';
		$pattern = "abcdefghijklmnopqrstuvwxyz";
		for($i=0;$i<8;$i++)
		{
			$hash .= $pattern{rand(0,25)};
		}
		$file_upload_name[$num] = $hash . '.' . $ext;
		if (cs_upload('board/files', $file_upload_name[$num], $_FILES["file_$num"]['tmp_name'])) {
			$a++;
		}	else {
			$message .= $cs_lang['error_fileupload'] . cs_html_br(1);
			$thread_error++;
		}
	}
	if(!empty($_POST["file_name_$num"]) AND empty($file_error[$num])) {
		$file_name[$num] = $_POST["file_name_$num"];
		$file_upload_name[$num] = $_POST["file_upload_name_$num"];
		if(isset($_POST["remove_file_$num"])) {
			cs_unlink('board', $file_upload_name[$num], 'files');
			$file_name[$num] = '';
		}	else {
			$file_name[$b] = $file_name[$num];
			$a++;
			$b++;
		}
	}
}
$run_loop_files = $a;
if(isset($_POST['files+'])) {
	$run_loop_files++;
}
if(isset($_POST['submit']))
{
	if(empty($thread_error))
	{
		$thread_form = 0;
	    $thread_cells = array('users_id','board_id','threads_time','threads_headline','threads_text','threads_important','threads_close','threads_last_time','threads_last_user');
	    $thread_save = array($thread_userid,$board_id,$thread_time,$thread_headline,$thread_text,'0','0',$thread_time,$thread_userid);
	    cs_sql_insert(__FILE__,'threads',$thread_cells,$thread_save);
	    $thread_now = cs_sql_select(__FILE__,'threads','threads_id','threads_time = \'' .$thread_time . '\'');
	    if($votes == 1)
	    {
			$thread_cells = array('users_id','threads_id','boardvotes_time','boardvotes_access','boardvotes_end','boardvotes_question','boardvotes_election');
	    	$thread_save = array($thread_userid,$thread_now['threads_id'],$thread_time,$votes_access,$votes_end,$votes_question,$votes_election);
	    	cs_sql_insert(__FILE__,'boardvotes',$thread_cells,$thread_save);
		}
		for($run=0; $run < $run_loop_files; $run++)
		{
			$num = $run+1;
			$files_cells = array('users_id','threads_id','boardfiles_time','boardfiles_name');
			$files_save = array($thread_userid,$thread_now['threads_id'],$thread_time,$file_name[$num]);
			cs_sql_insert(__FILE__,'boardfiles',$files_cells,$files_save);
			$files_select_new_id = cs_sql_insertid(__FILE__);
			$ext = substr($file_name[$num],strlen($file_name[$num])+1-strlen(strrchr($file_name[$num],'.')));
			$path = $cs_main['def_path'] . '/uploads/board/files/';
  		$target = $path . $file_upload_name[$num];
  		$target2 = $path . $files_select_new_id . '.' . $ext;
			$fileHand = fopen($target, 'r');
    	fclose($fileHand);
    	rename( $target, $target2 );
		}

		# Update board entry to get correct threads and comments count
		include_once('mods/board/repair.php');
		cs_board_threads($board_id);
    cs_redirect($cs_lang['create_done'],'board','thread','where=' .$thread_now['threads_id']);

#		header('location:' . $_SERVER['PHP_SELF'] . '?mod=board&action=thread&where=' .$thread_now['threads_id']);
	}
	elseif(empty($file_error))
	{
		echo cs_html_table(1,'forum',1);
		echo cs_html_roco(1,'leftc');
		echo cs_icon('important');
		echo $cs_lang['error_occurred'];
		echo ' - ';
		echo cs_secure ($thread_error).' '.$cs_lang['error_count'];
		echo cs_html_br(1);
		echo $message;
		echo cs_html_roco(0);
		echo cs_html_table(0);
		echo cs_html_br(1);
	}
}
if(isset($_POST['preview']))
{
	if(empty($thread_error))
	{
 		echo cs_html_table(1,'forum',1);
		echo cs_html_roco(1,'headb');
		echo $cs_lang['preview'];
		if($votes == 1)
		{
			echo cs_html_roco(1,'leftb');
			echo cs_icon('Volume Manager') . $votes_question;
			echo cs_html_roco(0);
			echo cs_html_roco(1,'leftb');
			$run_loop = isset($_POST['run_loop']) ? $_POST['run_loop'] : 0;
			for($run=0; $run < $run_loop; $run++)
			{
			  $num = $run+1;
				$cs_files["votes_election_$num"] = isset($_POST["votes_election_$num"]) ? $_POST["votes_election_$num"] : '';
				echo cs_html_vote('voted_answer',$run,'radio',0);
				echo cs_secure($cs_files["votes_election_$num"],0,1);
				echo cs_html_br(1);
			}
			echo cs_html_roco(0);
		}
		echo cs_html_roco(1,'leftc');
		echo cs_secure($thread_text,1,1);
		echo cs_html_roco(0);
		echo cs_html_table(0);
		echo cs_html_br(1);
	}
	elseif(empty($file_error))
	{
		echo cs_html_table(1,'forum',1);
		echo cs_html_roco(1,'leftc');
		echo cs_icon('important');
		echo $cs_lang['error_occurred'];
		echo ' - ';
		echo cs_secure ($thread_error).' '.$cs_lang['error_count'];
		echo cs_html_br(1);
		echo $message;
		echo cs_html_roco(0);
		echo cs_html_table(0);
		echo cs_html_br(1);
	}
}
if(isset($_POST['election']))
{
  	$_POST['run_loop']++;
}
if(!empty($thread_form))
{
	echo cs_html_form (1,'thread_create','board','thread_add',1);
	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'leftc');
	echo cs_icon('kedit') . $cs_lang['headline']. ' *';
	echo cs_html_roco(2,'leftb');
	echo cs_html_input('thread_headline',$thread_headline,'text',200,50);
	echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo cs_icon('kate') . $cs_lang['text']. ' *';
	echo cs_html_br(2);
	echo cs_abcode_smileys('thread_text');
	echo cs_html_br(2);
	echo 'max. ' . $max_text . $cs_lang['indi'];
	echo cs_html_roco(2,'leftb');
	echo cs_abcode_features('thread_text');
	echo cs_html_textarea('thread_text',$thread_text,'50','20');
	echo cs_html_roco(0);

	if($votes == 1)
	{
		echo cs_html_roco(1,'headb',0,2);
		echo cs_icon('Volume Manager') . $cs_lang['votes'];
		echo cs_html_roco(0);
		echo cs_html_roco(1,'leftc');
		echo cs_icon('today') . $cs_lang['votes_end'] . ' *';
		echo cs_html_roco(2,'leftb');
		echo cs_dateselect('votes_end','unix',$votes_end,2005);
		echo cs_html_roco(0);

		echo cs_html_roco(1,'leftc');
		echo cs_icon('enumList') . $cs_lang['votes_access'] . ' *';
		echo cs_html_roco(2,'leftb');
		echo cs_html_select(1,'votes_access');
			$levels = 0;
			while($levels < 6)
			{
				$votes_access == $levels ? $sel = 1 : $sel = 0;
				echo cs_html_option($levels . ' - ' . $cs_lang['lev_' . $levels],$levels,$sel);
				$levels++;
			}
	    echo cs_html_select(0);
		echo cs_html_roco(0);

		echo cs_html_roco(1,'leftc');
		echo cs_icon('kedit') . $cs_lang['votes_question'] . ' *';
		echo cs_html_roco(2,'leftb');
		echo cs_html_input('votes_question',$votes_question,'text',50,50);
		echo cs_html_roco(0);

		$run_loop = isset($_POST['run_loop']) ? $_POST['run_loop'] : 1;
		for($run=0; $run < $run_loop; $run++)
		{
		  	$num = $run+1;
			$cs_files["votes_election_$num"] = isset($_POST["votes_election_$num"]) ? $_POST["votes_election_$num"] : '';
			echo cs_html_roco(1,'leftc');
			echo cs_icon('kate') . $cs_lang['votes_election'] . ' ' . $num . ' *';
			echo cs_html_roco(2,'leftb');
			echo cs_html_input("votes_election_$num",$cs_files["votes_election_$num"],'text',50,50);
			echo cs_html_roco(0);
		}
	}

	$a = $run_loop_files;
	$run_loop_files = !empty($run_loop_files) ? $run_loop_files : 1;
	if($files == 1)
	{
		echo cs_html_roco(1,'headb',0,2);
		echo cs_icon('download') . $cs_lang['uploads'];
		echo cs_html_roco(0);
		for($run=0; $run < $run_loop_files; $run++)
		{
		  	$num = $run + 1;
		  	$cs_files["text_$num"] = isset($_POST["text_$num"]) ? $_POST["text_$num"] : '';
			echo cs_html_roco(1,'leftc');
			echo cs_icon('download') . $cs_lang['file'] . ' ' . $num;
			echo cs_html_roco(2,'leftb');
			if(empty($file_name[$num]))
			{
				echo cs_html_input("file_$num",'','file');
				$matches[1] = $cs_lang['infos'];
				$return_types = '';
				foreach($filetypes AS $add)
				{
					$return_types .= empty($return_types) ? $add : ', ' . $add;
				}
				$matches[2] = $cs_lang['max_size'] . cs_filesize($max_size) . cs_html_br(1);
				$matches[2] .= $cs_lang['filetypes'] . $return_types;
				echo ' ' . cs_abcode_clip($matches);
			}	else {
				echo cs_html_vote("file_name_$num",$file_name[$num],'hidden');
				echo cs_html_vote("file_upload_name_$num",$file_upload_name[$num],'hidden');
				$file = $file_name[$num];
				$extension = strlen(strrchr($file,"."));
				$name = strlen($file);
				$ext = substr($file,$name - $extension + 1,$name);
				if(strcasecmp($ext,'jpg') == '0' OR strcasecmp($ext,'jpeg') == '0' OR strcasecmp($ext,'gif') == '0' OR strcasecmp($ext,'png') == '0')
				{
					$cs_lap = cs_html_img('mods/gallery/image.php?boardpic=' . $file_name[$num] . '&boardthumb');
					echo cs_html_div(1,'float:left;padding:3px;border:1px solid black;background:gainsboro;');
					echo cs_html_link('mods/gallery/image.php?boardpic=' . $file_name[$num],$cs_lap);
					echo cs_html_div(0);
					echo cs_html_div(1,'float:left;padding:3px;margin-left:10px;');
					echo cs_html_img('symbols/files/filetypes/' . $ext . '.gif',0,0,0,$ext);
					echo ' ' . $file_name[$num];
					echo cs_html_br(1);
					echo cs_html_vote('remove_file_' . $num,$cs_lang['remove'],'submit');
					echo cs_html_div(0);

				}
				else
				{
					echo cs_html_img('symbols/files/filetypes/' . $ext . '.gif',0,0,0,$ext);
					echo ' ' . $file_name[$num];
					echo cs_html_vote('remove_file_' . $num,$cs_lang['remove'],'submit');
				}
			}
			echo cs_html_roco(0);
			//echo cs_html_roco(2,'leftb');
			//echo cs_html_textarea("file_text_$num",$cs_files["text_$num"],'50','3');
			//echo cs_html_roco(0);
		}
	}
	echo cs_html_roco(1,'leftc');
	echo cs_icon('ksysguard') . $cs_lang['options+'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_vote('where',$board_id,'hidden');
	if($votes == 0 AND $account['access_board'] >= '2')
	{
		echo cs_html_vote('new_votes',$cs_lang['vote_create'],'submit');
	}
	if($votes == 1 AND $account['access_board'] >= '2')
	{
		echo cs_html_vote('votes','1','hidden');
		echo cs_html_vote('run_loop',$run_loop,'hidden');
		echo cs_html_vote('election',$cs_lang['election+'],'submit');
	}
	if($files == '1' AND $account['access_board'] >= '2')
	{
	  	echo cs_html_vote('run_loop_files',$run_loop_files,'hidden');
		echo cs_html_vote('files','1','hidden');
		echo cs_html_vote('files+',$cs_lang['add_file'],'submit');
	}
	if($files == '0' AND $account['access_board'] >= '2')
	{
		echo cs_html_vote('new_file',$cs_lang['add_file'],'submit');
	}
	echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo cs_icon('ksysguard') . $cs_lang['options'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_vote('submit',$cs_lang['create'],'submit');
	echo cs_html_vote('preview',$cs_lang['preview'],'submit');
	echo cs_html_vote('reset',$cs_lang['reset'],'reset');
	echo cs_html_roco(0);
	echo cs_html_table(0);
	echo cs_html_form (0);
}
//Geh&ouml;rt zur Sicherheitsabfrage
?>
