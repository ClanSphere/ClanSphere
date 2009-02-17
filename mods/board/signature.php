<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

$count_abo = cs_sql_count(__FILE__,'abonements','users_id=' .$account['users_id']);
$count_att = cs_sql_count(__FILE__,'boardfiles','users_id=' .$account['users_id']);


$data['lang']['getmsg'] = cs_getmsg();
$data['count']['abos'] = $count_abo;
$data['count']['attachments'] = $count_att;
$data['link']['abos'] = cs_url('board','center');
$data['link']['attachments'] = cs_url('board','attachments');
$data['link']['avatar'] = cs_url('board','avatar');

$signature_sql = cs_sql_select($file,'users','users_signature',"users_id = '" . $account['users_id'] . "'");
$signature = $signature_sql['users_signature'];
$signature_form = 1;

if(isset($_POST['submit']) OR isset($_POST['preview'])) {
  $signature = $_POST['signature'];
} 

if(isset($_POST['submit'])) {
  $signature_form = 0;
    
  $signature = preg_replace_callback("=\[img\](.*?)\[/img\]=si","cs_abcode_resize",$signature);
  $signature = preg_replace_callback("=\[img width\=(.*?) height\=(.*?)\](.*?)\[/img\]=si","cs_abcode_resize",$signature);
    
  $signature_cells = array('users_signature');
  $signature_save = array($signature);
  cs_sql_update(__FILE__,'users',$signature_cells,$signature_save,$account['users_id']);
    
  cs_redirect($cs_lang['create_done'], 'board','signature');
}

if(isset($_POST['preview'])) {               
  
  if(!empty($signature)) {
  $signature = $_POST['signature'];
  $_SESSION['signature'] = $signature;
  cs_redirect(cs_secure($signature,1,1), 'board','signature');
  }
  else {  
  cs_redirect($cs_lang['nosig'], 'board','signature');
  }
}

if(!empty($signature_form)) {
  $data['action']['form'] = cs_url('board','signature');
  $data['signature']['smileys'] = cs_abcode_smileys('signature');
  $data['signature']['abcode'] = cs_abcode_features('signature');
  $data['signature']['text'] = !empty($_SESSION['signature']) ? $_SESSION['signature'] : $signature;
}

echo cs_subtemplate(__FILE__,$data,'board','signature');
?>