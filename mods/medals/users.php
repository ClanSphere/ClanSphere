<?php

$cs_lang = cs_translate('medals');
$data = array();

$users_id = (int) $_GET['id'];

$data['users']['addons'] = cs_addons('users','view',$users_id,'medals');

$cells = 'medals_name, medals_text, medals_extension, medals_date, medals_id';
$data['medals'] = cs_sql_select(__FILE__,'medals', $cells, "users_id = '" . $users_id . "'",0,0,0);
$data['count']['medals'] = count($data['medals']);

for ($i = 0; $i < $data['count']['medals']; $i++) {
  $data['medals'][$i]['img_src'] = $cs_main['php_self']['dirname'] . 'uploads/medals/medal-' . $data['medals'][$i]['medals_id'] . '.' . $data['medals'][$i]['medals_extension'];
  $data['medals'][$i]['medals_text'] = cs_secure($data['medals'][$i]['medals_text'],1);
  $data['medals'][$i]['date'] = cs_date('unix',$data['medals'][$i]['medals_date']);
}

echo cs_subtemplate(__FILE__,$data,'medals','users');

?>