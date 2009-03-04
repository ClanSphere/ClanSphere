<?php

$cs_lang = cs_translate('medals');
$medals_id = (int) $_GET['id'];

if (isset($_GET['confirm'])) {

  cs_sql_delete(__FILE__,'medalsuser',$medals_id,'medals_id'); 
  cs_sql_delete(__FILE__,'medals',$medals_id);
  
  cs_redirect($cs_lang['del_true'], 'medals', 'manage');
  
}

$data = array();

$medal = cs_sql_select(__FILE__,'medals','medals_name',"medals_id = '" . $medals_id . "'");
$medals_name = cs_secure($medal['medals_name']);

$data['medals']['message'] = sprintf($cs_lang['rly_remove'],$medals_name);
$data['medals']['url_confirm'] = cs_url('medals','remove','id=' . $medals_id . '&amp;confirm');

echo cs_subtemplate(__FILE__,$data,'medals','remove');

?>