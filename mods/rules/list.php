<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('rules');

$data = array();
$data['rules'] = array();

$rules_count = cs_sql_count(__FILE__,'rules');
$where = "categories_mod = 'rules' AND categories_access <= '" . $account['access_rules'] . "'";
$categories_data = cs_sql_select(__FILE__,'categories','*',$where,'categories_name',0,0);
$categories_loop = count($categories_data);

$data['count']['rules'] = sprintf($cs_lang['all'], $rules_count);

for($run=0; $run<$categories_loop; $run++) {

  $data['rules'][$run]['cat'] = cs_link(cs_secure($categories_data[$run]['categories_name']),'rules','listcat','id=' .   $categories_data[$run]['categories_id']);

  $content = cs_sql_count(__FILE__,'rules','categories_id = ' .$categories_data[$run]['categories_id']);
  $data['rules'][$run]['count_cat'] = $content;
  $data['rules'][$run]['cat_text'] = cs_secure($categories_data[$run]['categories_text'],1,1);
}

echo cs_subtemplate(__FILE__,$data,'rules','list');
