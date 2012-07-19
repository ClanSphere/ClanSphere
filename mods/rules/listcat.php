<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('rules');
$cs_get = cs_get('id');
$data = array();

$categories_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

$where = "categories_id = '" . $categories_id . "' AND categories_access <= '" . $account['access_rules'] . "'";
$data['cat_data'] = cs_sql_select(__FILE__,'categories','categories_name, categories_text',$where,0,0);

if(isset($data['cat_data']['name'])) {
  $data['cat_data']['name'] = cs_secure($data['cat_data']['categories_name']);
  $data['cat_data']['text'] = cs_secure($data['cat_data']['categories_text'],1);
}
else {
  $data['cat_data']['name'] = '';
  $data['cat_data']['text'] = '';
}

$select = 'rules_order, rules_title, rules_rule';
$data['rules'] = cs_sql_select(__FILE__,'rules',$select,"categories_id = '" . $categories_id . "'",'rules_order ASC',0,0);
$rules_loop1 = count($data['rules']);

for($run=0; $run<$rules_loop1; $run++) {

  $data['rules'][$run]['order'] = cs_secure($data['rules'][$run]['rules_order']);
  $data['rules'][$run]['title'] = cs_secure($data['rules'][$run]['rules_title']);
  $data['rules'][$run]['rule'] = cs_secure($data['rules'][$run]['rules_rule'],1);

}

echo cs_subtemplate(__FILE__,$data,'rules','listcat');