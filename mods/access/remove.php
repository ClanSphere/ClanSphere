<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('access');

$access_form = 1;
$access_id = $_REQUEST['id'];

if(isset($_POST['agree'])) {
  $access_form = 0;
  cs_sql_delete(__FILE__,'access',$access_id);
  cs_redirect($cs_lang['del_true'], 'access');
}

if(isset($_POST['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'access');
}
  
if($access_id < 6) {
  cs_redirect($cs_lang['del_error'], 'access');
}
elseif(!empty($access_form)) {
  $data['lang']['body'] = sprintf($cs_lang['del_rly'],$access_id);
  $data['action']['form'] = cs_url('access','remove');
  $data['access']['id'] = $access_id;

  echo cs_subtemplate(__FILE__,$data,'access','remove');
}
?>