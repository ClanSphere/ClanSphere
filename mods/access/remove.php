<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$
$cs_lang = cs_translate('access');

$access_form = 1;
$cs_get = cs_get('id');
$cs_post = cs_post('id');
$access_id = empty($cs_get['id']) ? $cs_post['id'] : $cs_get['id'];

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

if(!empty($access_form)) {
  $db_access = cs_sql_select(__FILE__,'access','access_name','access_id = ' . $access_id,0,0,1);
  if(!empty($db_access)) {
    $data['lang']['body'] = sprintf($cs_lang['remove_entry'],$cs_lang['mod_name'],$db_access['access_name']);
    $data['action']['form'] = cs_url('access','remove');
    $data['access']['id'] = $access_id;
    echo cs_subtemplate(__FILE__,$data,'access','remove');
  }
  else {
    cs_redirect('','access');
  }
}