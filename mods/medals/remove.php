<?php

$cs_lang = cs_translate('medals');
$users_id = (int) $_GET['id'];

if (isset($_GET['confirm'])) {

  cs_sql_delete(__FILE__,'medals',$users_id);
  
  cs_redirect($cs_lang['del_true'], 'medals');
  
}

$data = array();

$tables = 'medals md LEFT JOIN {pre}_users usr ON md.users_id = usr.users_id';
$cells = 'md.medals_name AS medals_name, usr.users_nick AS users_nick';
$medal = cs_sql_select(__FILE__,$tables,$cells,"md.medals_id = '" . $users_id . "'");
$medals_name = cs_secure($medal['medals_name']);
$users_nick = cs_secure($medal['users_nick']);

$data['medals']['message'] = sprintf($cs_lang['rly_remove'],$medals_name,$users_nick);
$data['medals']['url_confirm'] = cs_url('medals','remove','id=' . $users_id . '&amp;confirm');

echo cs_subtemplate(__FILE__,$data,'medals','remove');

?>