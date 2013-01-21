<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('computers');
$cs_get = cs_get('id');
$cs_post = cs_post('id');
$computers_id = empty($cs_get['id']) ? $cs_post['id'] : $cs_get['id'];

$referrer = $account['access_computers'] < 3 ? 'center' : 'manage';

if(isset($cs_post['agree'])) {
  $select = 'users_id, computers_pictures';
  $computer = cs_sql_select(__FILE__,'computers',$select,'computers_id = ' . $computers_id);
  if($computer['users_id'] == $account['users_id'] OR $account['access_computers'] >= 5) {
    $computer_string = $computer['computers_pictures'];
    $computer_pics = empty($computer_string) ? array() : explode("\n",$computer_string);
    if(!empty($computer_string)) {
      foreach($computer_pics AS $pic) {
        cs_unlink('computers', 'picture-' . $pic);
        cs_unlink('computers', 'thumb-' . $pic);
      }
    }
    cs_sql_delete(__FILE__,'computers',$computers_id);
    cs_redirect($cs_lang['del_true'], 'computers',$referrer);
  } else {
    cs_redirect($cs_lang['del_false'], 'computers',$referrer);
  }
}

if(isset($cs_post['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'computers',$referrer);
}


$search_user = cs_sql_select(__FILE__,'computers','users_id, computers_name','computers_id = ' . $computers_id);
if(!empty($search_user)) {
  $data = array();
  if($search_user['users_id'] != $account['users_id'] AND $account['access_computers'] < 5) {
    $data['head']['body'] = $cs_lang['not_own'];
    $data['if']['own'] = FALSE;
  } else {
    $data['head']['body'] = sprintf($cs_lang['remove_entry'],$cs_lang['mod_name'],$search_user['computers_name']);
    $data['if']['own'] = TRUE;
    $data['com']['id'] = $computers_id;
    $data['com']['referer'] = empty($_SERVER['HTTP_REFERER']) ? 'center' : $_SERVER['HTTP_REFERER'];
  }
  echo cs_subtemplate(__FILE__,$data,'computers','remove');
}
else {
  cs_redirect('',$referrer);
}