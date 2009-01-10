<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

include('mods/board/functions.php');

$check_sq = 0;

$cid = empty($_REQUEST['cid']) ? 0 : $_REQUEST['cid'];
$tid = empty($_REQUEST['tid']) ? 0 : $_REQUEST['tid'];
settype($cid,'integer');
settype($tid,'integer');

if(empty($tid) AND !empty($cid)) {
  $cs_comments = cs_sql_select(__FILE__,'comments','comments_fid',"comments_id = '" . $cid . "'");
  $tid = $cs_comments['comments_fid'];
}

$from = 'threads thr INNER JOIN {pre}_board frm ON thr.board_id = frm.board_id ';
$from .= 'INNER JOIN {pre}_categories cat ON frm.categories_id = cat.categories_id';
$select = 'frm.board_access AS board_access, frm.squads_id AS squads_id';
$where = "thr.threads_id = '" . $tid . "'";
$cs_thread = cs_sql_select(__FILE__,$from,$select,$where,0,0,1);

if(!empty($cs_thread['squads_id']) AND $account['access_board'] < $cs_thread['board_access']) {
  $sq_where = "users_id = '" . $account['users_id'] . "' AND squads_id = '" . $cs_thread['squads_id'] . "'";
  $check_sq = cs_sql_count(__FILE__,'members',$sq_where);
}

if(empty($tid) || (count($cs_thread) == 0)) {
	return errorPage('report');
}

if($account['access_board'] < $cs_thread['board_access'] AND empty($check_sq)) {
	return errorPage('report');
}

$report = isset($_POST['report']) ? $_POST['report'] : '';

if(isset($_POST['submit'])) {

	$error = 0;
	$errormsg = '';

  if(empty($report)) {
    $error++;
    $errormsg .= $cs_lang['no_text'] . cs_html_br(1);
  }
	$exists = cs_sql_count(__FILE__,'boardreport',"threads_id = '" . $tid . "' AND comments_id = '" . $cid . "'");
	if(!empty($exists)) {
		$error++;
    $errormsg .= $cs_lang['report_exists'] . cs_html_br(1);
	}  
}

if(!empty($error)) {
  $data['lang']['body'] = $errormsg;
}
elseif(!isset($_POST['submit'])) {
  $data['lang']['body'] = $cs_lang['fill_out_all_fields'];
}
else {
  $data['lang']['body'] = $cs_lang['report_success'];
}

if(!empty($error) OR !isset($_POST['submit'])) {
  $data['action']['form'] = cs_url('board','report');
  $data['report']['tid'] = $tid;
  $data['report']['cid'] = $cid;

}
else {
  $report_cells = array('threads_id', 'comments_id', 'users_id', 'boardreport_time', 'boardreport_text');
  $report_save = array($tid, $cid, $account['users_id'], cs_time(), $report);
  cs_sql_insert(__FILE__,'boardreport',$report_cells,$report_save);

  header('location:' . $_SERVER['PHP_SELF'] . '?mod=board&action=thread&where=' . $tid);
}

echo cs_subtemplate(__FILE__,$data,'board','report');
?>