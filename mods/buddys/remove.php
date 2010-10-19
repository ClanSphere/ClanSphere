<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$
$cs_lang = cs_translate('buddys');

$data = array();

$buddys_form = 1;
$cs_get = cs_get('id');
$cs_post = cs_post('id');
$buddys_id = empty($cs_get['id']) ? $cs_post['id'] : $cs_get['id'];

if(isset($_POST['agree'])) {
  $buddys_form = 0;
  $buddy = cs_sql_select(__FILE__,'buddys','users_id',"buddys_id = '" . $buddys_id . "'");
  if($buddy['users_id'] == $account['users_id'] OR $account['access_buddys'] >= 5) {
    cs_sql_delete(__FILE__,'buddys',$buddys_id);
    cs_redirect($cs_lang['del_true'], 'buddys','center');
  }
  else {
    cs_redirect($cs_lang['del_false'], 'buddys','center');
  }
  $data['head']['msg'] = $msg;
}

if(isset($_POST['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'buddys','center');
}

if(!empty($buddys_form)) {
  $tables = 'buddys bud INNER JOIN {pre}_users usr on usr.users_id = bud.buddys_user';
  $where = 'bud.buddys_id = ' . $buddys_id . ' AND bud.users_id = ' . $account['users_id'];
  $buddy = cs_sql_select(__FILE__,$tables,'usr.users_nick',$where,0,0,1);
  if(!empty($buddy)) {
    $data['head']['buddy']  = sprintf($cs_lang['remove_buddy'],$buddy['users_nick']);
    $data['head']['id']     = $buddys_id;
  }
  else {
    cs_redirect('', 'buddys','center');
  }
  echo cs_subtemplate(__FILE__,$data,'buddys','remove');
}