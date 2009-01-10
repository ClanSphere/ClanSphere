<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('rules');

$data = array();

$categories_id = $_GET['id'];
settype($categories_id,'integer');

$where = "categories_mod='rules' AND categories_id = '" . $categories_id . "AND cat.categories_access <= '" . $account['access_rules'] . "'";
$data['cat_data'] = cs_sql_select(__FILE__,'categories','*',$where,'categories_name');

$data['cat_data']['name'] = cs_secure($data['cat_data']['categories_name']);
$data['cat_data']['text'] = cs_secure($data['cat_data']['categories_text'],1);

$data['rules'] = cs_sql_select(__FILE__,'rules','*',"categories_id = '" . $categories_id . "'",'rules_order ASC',0,0);
$rules_loop1 = count($data['rules']);

for($run=0; $run<$rules_loop1; $run++) {

  $data['rules'][$run]['order'] = cs_secure($data['rules'][$run]['rules_order']);
  $data['rules'][$run]['title'] = cs_secure($data['rules'][$run]['rules_title']);
  $data['rules'][$run]['rule'] = cs_secure($data['rules'][$run]['rules_rule'],1);

}

echo cs_subtemplate(__FILE__,$data,'rules','listcat');

?>