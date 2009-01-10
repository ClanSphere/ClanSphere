<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

require_once('mods/board/functions.php');

$thread_form = 1;
$thread_id = $_REQUEST['id'];
settype($thread_id,'integer');

$from = 'threads thr INNER JOIN {pre}_board frm ON thr.board_id = frm.board_id ';
$select = 'frm.board_access AS board_access, frm.board_id AS board_id, thr.users_id AS users_id, frm.squads_id AS squads_id';
$where = "thr.threads_id = '" . $thread_id . "'";
$cs_thread = cs_sql_select(__FILE__,$from,$select,$where);

$cs_boardfiles = cs_sql_select(__FILE__,'boardfiles','boardfiles_name,boardfiles_id',"threads_id='$thread_id'",0,0,0);
$cs_boardfiles_loop = count($cs_boardfiles); 

//Sicherheitsabfrage Beginn 
$thread_mods = cs_sql_select(__FILE__,'boardmods','boardmods_del',"users_id = '" . $account['users_id'] . "'",0,0,1);
if(!empty($cs_thread['squads_id'])) {
  $where = "squads_id = '" . $cs_thread['squads_id'] . "' AND users_id = '" .$account['users_id'] . "'";
  $check_sq = cs_sql_count(__FILE__,'members',$where);
}

$allowed = 0;
if(empty($thread_id) || (count($cs_thread) == 0))
	return errorPage('thread_remove');

if($account['access_board'] >= $cs_thread['board_access']) {
	$where_com = "comments_mod = 'board' AND comments_fid = '" . $thread_id . "'";
	$sum= cs_sql_count(__FILE__,'comments',$where_com);  
	if($account['access_comments'] >= 5 OR !empty($thread_mods['boardmods_del'])) {
		$allowed = 1;
	} elseif($cs_thread['users_id'] == $account['users_id'] AND empty($sum)) {
		$allowed = 1;	
	} else {
	 	return errorPage('thread_remove');
	}
} elseif(!empty($check_sq)) {
  $allowed = 1;	
} elseif(empty($allowed)) {
	return errorPage('thread_remove');
}
//Sicherheitsabfrage Ende

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['remove'];
echo cs_html_roco(0);

if(isset($_POST['agree'])) {
	$thread_form = 0;
	
	for($run=0; $run < $cs_boardfiles_loop; $run++)
	{       
		$file = $cs_boardfiles[$run]['boardfiles_name'];
		$extension = strlen(strrchr($file,"."));
		$name = strlen($file);
		$ext = substr($file,$name - $extension + 1,$name); 
		//$file = cs_secure($cs_boardfiles[$run]['boardfiles_name']);
		echo 'uploads/board/files/' . $cs_boardfiles[$run]['boardfiles_id'] . '.' . $ext . cs_html_br(1);
		cs_unlink('board', $cs_boardfiles[$run]['boardfiles_id'] . '.' . $ext, 'files');
	}
	
	cs_sql_delete(__FILE__,'threads',$thread_id);
	$query = "DELETE FROM {pre}_comments WHERE comments_mod='board' AND ";
	$query .= "comments_fid='" . $thread_id . "'";
	cs_sql_query(__FILE__,$query); 
	$query = "DELETE FROM {pre}_abonements WHERE threads_id='" . $thread_id . "'";
	cs_sql_query(__FILE__,$query);
	$query = "DELETE FROM {pre}_boardfiles WHERE threads_id='" . $thread_id . "'";
	cs_sql_query(__FILE__,$query);
	$query = "DELETE FROM {pre}_boardvotes WHERE threads_id='" . $thread_id . "'";
	cs_sql_query(__FILE__,$query);
	$query = "DELETE FROM {pre}_voted WHERE voted_mod='board' AND ";
	$query .= "voted_fid='" . $thread_id . "'";
	cs_sql_query(__FILE__,$query);
	// Delte GhostLinks
	$query = "DELETE FROM {pre}_threads WHERE threads_ghost_thread = '" . $thread_id ."'";
	cs_sql_query(__FILE__,$query);
	

	# Update board entry to get correct threads and comments count
	include_once('mods/board/repair.php');
	cs_board_threads($cs_thread['board_id']);
	cs_board_comments($cs_thread['board_id']);
	
	cs_redirect($cs_lang['del_true'],'board','list');
}

if(isset($_POST['cancel'])) {
	$thread_form = 0;

  cs_redirect($cs_lang['del_false'],'board','thread','action=thread&where=' .$thread_id);
}

if(!empty($thread_form)) {

	echo cs_html_roco(1,'leftb');
	echo sprintf($cs_lang['del_rly'],$thread_id);
	echo cs_html_roco(0);

	echo cs_html_roco(1,'centerc');
	echo cs_html_form(1,'thread_remove','board','thread_remove');
	echo cs_html_vote('id',$thread_id,'hidden');
	echo cs_html_vote('agree',$cs_lang['confirm'],'submit');
	echo cs_html_vote('cancel',$cs_lang['cancel'],'submit');
	echo cs_html_form (0);
	echo cs_html_roco(0);
	echo cs_html_table(0);
}

?>