<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

$comments_id = $_REQUEST['id'];
settype($comments_id,'integer');
$comments_form = 1;

require_once('mods/board/functions.php');

$cells = 'comments_fid';
$cs_comments = cs_sql_select(__FILE__,'comments',$cells,"comments_id = '" . $comments_id . "'");
$com_fid = $cs_comments['comments_fid'];


$from = 'threads thr INNER JOIN {pre}_board frm ON thr.board_id = frm.board_id ';
$select = 'frm.board_access AS board_access, frm.board_id AS board_id';
$where = "thr.threads_id = '" . $com_fid . "'";
$cs_thread = cs_sql_select(__FILE__,$from,$select,$where);


// Board files auslesen
$where = "comments_id = '" . $comments_id ."'";
$cs_com_files = cs_sql_select(__FILE__,'boardfiles','boardfiles_name,boardfiles_id',$where,0,0,0);
$cs_com_files_loop = count($cs_com_files); 



//Sicherheitsabfrage Beginn 
$thread_mods = cs_sql_select(__FILE__,'boardmods','boardmods_del',"users_id = '" . $account['users_id'] . "'",0,0,1);
$allowed = 0;      

if(empty($comments_id) || (count($cs_comments) == 0))
	return errorPage('com_remove');
	
if($account['access_board'] >= $cs_thread['board_access'])
{
	$allowed = 0;
	if($account['access_comments'] >= 5 OR !empty($thread_mods['boardmods_del'])) 
		$allowed = 1;
	else	
	 	return errorPage('com_remove');
}	
else if(empty($allowed))
	return errorPage('com_remove');
//Sicherheitsabfrage Ende

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_com_remove'];
echo cs_html_roco(0);

if(isset($_POST['agree'])) {
	$comments_form = 0;
		
	for($run=0; $run < $cs_com_files_loop; $run++)
	{       
		$file = $cs_com_files[$run]['boardfiles_name'];
		$extension = strlen(strrchr($file,"."));
		$name = strlen($file);
		$ext = substr($file,$name - $extension + 1,$name); 
		//$file = cs_secure($cs_boardfiles[$run]['boardfiles_name']);
		echo 'uploads/board/files/' . $cs_com_files[$run]['boardfiles_id'] . '.' . $ext . cs_html_br(1);
		cs_unlink('board', $cs_com_files[$run]['boardfiles_id'] . '.' . $ext, 'files');
		$query = "DELETE FROM {pre}_boardfiles WHERE boardfiles_id = '" . $cs_com_files[$run]['boardfiles_id'] . "'";
		cs_sql_query(__FILE__,$query);
	}
	
	
         
	$where = "comments_id > '" . $comments_id . "' AND comments_fid = '" . $com_fid . "'";
	$where .= " AND comments_mod = 'board'";
	$before = cs_sql_count(__FILE__,'comments',$where);
	$start = floor($before / $account['users_limit']) * $account['users_limit'];
	
	cs_sql_delete(__FILE__,'comments',$comments_id);
        
	$update_last = cs_sql_select(__FILE__,'comments','*',"comments_fid = '" . $com_fid . "'",'comments_time DESC',0,1);
  $cells = array('threads_last_time','threads_last_user');
  $saves = array($update_last['comments_time'],$update_last['users_id']);
 
	cs_sql_update(__FILE__,'threads',$cells,$saves,$com_fid); 


	# Update board entry to get correct threads and comments count
	include_once('mods/board/repair.php');
	cs_board_comments($cs_thread['board_id']);
	cs_threads_comments($com_fid);

	$more = 'where=' . $com_fid . '&amp;start=' . $start;

  cs_redirect($cs_lang['del_true'],'board','thread',$more);
}

if(isset($_POST['cancel'])) {
  cs_redirect($cs_lang['del_false'],'board','thread','where='.$com_fid);
}

if(!empty($comments_form)) {

	echo cs_html_roco(1,'leftb');
	echo sprintf($cs_lang['del_rly'],$comments_id);
	echo cs_html_roco(0);

	echo cs_html_roco(1,'centerc');
	echo cs_html_form(1,'board_com_remove','board','com_remove');
	echo cs_html_vote('id',$comments_id,'hidden');
	echo cs_html_vote('agree',$cs_lang['confirm'],'submit');
	echo cs_html_vote('cancel',$cs_lang['cancel'],'submit');
	echo cs_html_form (0);
	echo cs_html_roco(0);
	echo cs_html_table(0);
}

?>
