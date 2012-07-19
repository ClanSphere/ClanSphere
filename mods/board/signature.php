<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

$count_abo = cs_sql_count(__FILE__,'abonements','users_id=' .$account['users_id']);
$count_att = cs_sql_count(__FILE__,'boardfiles','users_id=' .$account['users_id']);

$data = array();
$data['head']['getmsg'] = cs_getmsg();
$data['count']['abos'] = $count_abo;
$data['count']['attachments'] = $count_att;
$data['link']['abos'] = cs_url('board','center');
$data['link']['attachments'] = cs_url('board','attachments');
$data['link']['avatar'] = cs_url('board','avatar');
$data['action']['form'] = cs_url('board','signature');
$data['signature']['smileys'] = cs_abcode_smileys('signature');
$data['signature']['abcode'] = cs_abcode_features('signature');

$signature_sql = cs_sql_select($file,'users','users_signature',"users_id = '" . $account['users_id'] . "'");

$signature = $signature_sql['users_signature'];
$signature = isset($_POST['signature']) ? $_POST['signature'] : $signature;
$signature = preg_replace_callback("=\[img\](.*?)\[/img\]=si","cs_abcode_resize",$signature);
$signature = preg_replace_callback("=\[img width\=(.*?) height\=(.*?)\](.*?)\[/img\]=si","cs_abcode_resize",$signature);
$data['signature']['text'] = $signature;
$data['signature']['preview'] = cs_secure($signature,1,1);
$data['if']['preview'] = (isset($_POST['preview']) AND !empty($signature)) ? 1 : 0;

if(isset($_POST['submit'])) {

  $signature_cells = array('users_signature');
  $signature_save = array($signature);
  cs_sql_update(__FILE__,'users',$signature_cells,$signature_save,$account['users_id']);
    
  cs_redirect($cs_lang['create_done'], 'board','signature');
}

$data['signature']['text'] = cs_secure($data['signature']['text']);

echo cs_subtemplate(__FILE__,$data,'board','signature');