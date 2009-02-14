<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('files');

require 'mods/files/functions.php';

$file_id = $_REQUEST['where'];
settype($file_id,'integer');
$maxlength = '80';
$modul = 'files';
$files_size = '';
$access_id = $account['access_files'];

$from = 'files fls INNER JOIN {pre}_users usr ON fls.users_id = usr.users_id';
$from .= ' INNER JOIN {pre}_categories cat ON fls.categories_id = cat.categories_id';
$select = 'fls.files_name AS files_name, fls.users_id AS users_id, usr.users_nick'; 
$select .= ' AS users_nick, fls.files_time AS files_time, fls.files_id AS files_id';
$select .= ', fls.files_mirror AS files_mirror ,cat.categories_name AS categories_name';
$select .= ', cat.categories_id AS categories_id, fls.files_count AS files_count';  
$select .= ', fls.files_description AS files_description, fls.files_close AS files_close';
$select .= ', fls.files_vote AS files_vote, fls.files_size AS files_size, fls.files_version AS files_version, fls.files_previews AS files_previews';
$where = "files_id = '" . $file_id . "'";
$cs_file = cs_sql_select(__FILE__,$from,$select,$where);

$from = 'voted';
$select = 'users_id, voted_answer';
$where = "voted_fid = '" . $file_id . "' AND voted_mod = '" . $modul . "'"; 
$order = '';
$start = '';
$cs_voted = cs_sql_select(__FILE__,$from,$select,$where,0,0,0);
$voted_loop = count($cs_voted);

if(!empty($_POST['voted_answer'])) 
{
	$voted_answer = $_POST['voted_answer'];
}

if(!empty($account['users_id'])) 
{
	$users_id = $account['users_id'];
}
else
{
	$users_id = '0';
}	

$check_user_voted = 0;
for ($run = 0; $run < $voted_loop; $run++)
{
	$voted_users_id = $cs_voted[$run]['users_id'];
	if($voted_users_id == $users_id)
	{
		$check_user_voted++;
	}
}

if(empty($check_user_voted))
{	
	if(isset($_POST['submit'])) 
	{        
		$time = cs_time();
		$voted_ip =$_SERVER['REMOTE_ADDR'];
		$votes_cells = array('voted_fid','users_id','voted_time','voted_answer','voted_ip','voted_mod');
		$votes_save = array($file_id,$users_id,$time,$voted_answer,$voted_ip,$modul);
		cs_sql_insert(__FILE__,'voted',$votes_cells,$votes_save);
		header('location:' . $_SERVER['PHP_SELF'] . '?mod=files&action=view&where=' .$file_id);
	}
}


echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,2); 
$body = cs_link($cs_lang['mod'],'files','list');
$cat = cs_link($cs_file['categories_name'],'files','listcat','where=' . $cs_file['categories_id']);
$file = cs_secure($cs_file['files_name']);
echo $body . ' - ' . $cat . ' - ' . $file;
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('kedit');
echo $cs_lang['name'];
echo cs_html_roco(2,'leftb',0,0,'60%'); 
echo cs_secure($cs_file['files_name']);   
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('package_editors') .$cs_lang['version'];
echo cs_html_roco(2,'leftb',0,0,'60%');
echo cs_secure($cs_file['files_version']);
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('fileshare');
echo $cs_lang['big'];
echo cs_html_roco(2,'leftb',0,0,'60%');
echo cs_filesize($cs_file['files_size']);
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('personal');
echo $cs_lang['autor'];
echo cs_html_roco(2,'leftb',0,0,'60%');
echo cs_secure($cs_file['users_nick']);
echo cs_html_roco(0); 

echo cs_html_roco(1,'leftc'); 
echo cs_icon('1day');
echo $cs_lang['date'];
echo cs_html_roco(2,'leftb',0,0,'60%');
echo cs_date('unix',$cs_file['files_time'],1);
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('download');
echo $cs_lang['downloaded'];
echo cs_html_roco(2,'leftb',0,0,'60%');
echo cs_html_big(1);
echo cs_secure($cs_file['files_count']) .' '; 
echo cs_html_big(0);
echo $cs_lang['mal'];
echo cs_html_roco(0);

$check_vote = $cs_file['files_vote'];

if(!empty($check_vote))
{
	echo cs_html_roco(1,'leftc');
	echo cs_icon('Volume Manager');
	echo $cs_lang['evaluation'];
	if(empty($check_user_voted))
	{	
		echo cs_html_roco(2,'leftb');
		echo cs_html_form(1,'files','files','view&amp;where=' . $file_id);	
		echo cs_html_select(1,'voted_answer');
		$levels = 1;
		while($levels < 7) 
		{
			/*$voted_answer == $levels ? $sel = 1 : */$sel = 0;
			echo cs_html_option($levels . ' - ' . $cs_lang['vote_' . $levels],$levels,$sel);
			$levels++;
		}	 
		echo cs_html_select(0);	
		echo cs_html_vote('file_id',$file_id,'hidden');
		echo cs_html_vote('submit',$cs_lang['ok'],'submit');
		echo cs_html_form (0);
	}
	else
	{
		$files_votes = 0;
		for($run=0; $run<$voted_loop; $run++) 
		{
			$a = cs_secure($cs_voted[$run]['voted_answer']);
			$files_votes += $a;
		}	
		echo cs_html_roco(2,'leftc');
		$files_votes = $files_votes / $voted_loop;
		$files_votes = round($files_votes,2);
		$files_votes = round($files_votes,0);
		for($run=6; $run>$files_votes; $run--) 
		{
			echo cs_icon('favorites');
		}
		for($run=1; $run<$files_votes; $run++) 
		{
			echo cs_icon('favorites1');
		}
	}
	echo cs_html_roco(0);
}

echo cs_html_roco(1,'headb',0,2);
echo $cs_lang['info'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb',0,2);
echo cs_secure($cs_file['files_description'],1,1);
echo cs_html_roco(0);

if(!empty($cs_file['files_previews'])) {

	$files_pics = explode("\n",$cs_file['files_previews']);  
	echo cs_html_roco(1,'headb',0,2);
	echo $cs_lang['preview'];
    echo cs_html_roco(0);
    echo cs_html_roco(1,'leftb',0,2);
	$count = 1;
	foreach($files_pics AS $pic) {
       	$link = cs_html_img('uploads/files/thumb-' . $pic);
		echo cs_html_link('uploads/files/picture-' . $pic,$link) . ' ';
		$count++;
	}
	echo cs_html_roco(0); 
}
echo cs_html_table(0);
echo cs_html_br(1);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,2);
echo $cs_lang['mirror'];
echo cs_html_roco(2,'headb',0,0,'120px');
echo $cs_lang['typ'];
echo cs_html_roco(0);
$files_mirror = $cs_file['files_mirror'];
$temp = explode("-----", $files_mirror);
$temp_loop = count($temp);

if (isset($_REQUEST['target']))
{       
	$files_cells = array('files_count');
    	$files_save = array(++$cs_file['files_count']);
	cs_sql_update(__FILE__,'files',$files_cells,$files_save,$file_id);
	$temp_a = explode("\n", $temp[$_REQUEST['target']]);
	$select_mirrow = $temp_a['1'];
	header("location:".$select_mirrow."");
} 
for ($run = 1; $run < $temp_loop; $run++)
{
	$temp_a = explode("\n", $temp[$run]);
	if($account['access_files'] >= $temp_a['4'])
	{
		echo cs_html_roco(1,'leftc');
		echo cs_icon('html');
		echo cs_html_roco(2,'leftb');
		if(empty($temp_a['2']))
		{
			//echo cs_link(cs_secure($temp_a['1'],1),'files','view','where=' .$file_id. '&target=' .$run);
			echo cs_html_link('?mod=files&amp;action=download&amp;where=' .$file_id. '&amp;target=' .$run, $temp_a['1'],1);
		}
		else
		{
			//echo cs_link(cs_secure($temp_a['2'],1),'files','view','where=' .$file_id. '&target=' .$run);  
			echo cs_html_link('?mod=files&amp;action=download&amp;where=' .$file_id. '&amp;target=' .$run, $temp_a['2'],1);
		}
		echo cs_html_roco(3,'leftc');
		echo cs_html_img('symbols/files/filetypes/' . $temp_a['3'] . '.gif',0,0,0,$temp_a['3']);
		echo '( '; 
		echo cs_html_big(1);
		echo $temp_a['3'];
		echo cs_html_big(0);
		echo ' )';
		echo cs_html_roco(0);
	}
}

echo cs_html_table(0);

include_once('mods/comments/functions.php');

$where_com = "comments_mod = 'files' AND comments_fid = '" . $file_id . "'";
$count_com = cs_sql_count(__FILE__,'comments',$where_com);

if(!empty($count_com)) {
	echo cs_html_br(1);
	echo cs_comments_view($file_id,'files','view',$count_com);
}
echo cs_comments_add($file_id,'files',$cs_file['files_close']);

?>