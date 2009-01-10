<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('rules');

$data = array();

empty($_REQUEST['start']) ? $start = 0 : $start = $_REQUEST['start']; 
$cs_sort[1] = 'rules_order DESC';
$cs_sort[2] = 'rules_order ASC';
$cs_sort[3] = 'rules_title DESC';
$cs_sort[4] = 'rules_title ASC';
$cs_sort[5] = 'categories_id DESC';
$cs_sort[6] = 'categories_id ASC';
empty($_REQUEST['sort']) ? $sort = 2 : $sort = $_REQUEST['sort'];
$order = $cs_sort[$sort];
$rules_count = cs_sql_count(__FILE__,'rules');

$data['count']['rules'] = $rules_count;
$data['url']['create']  = cs_url('rules','create');

$data['head']['message'] = cs_getmsg();
$data['head']['pages']   = cs_pages('rules','manage',$rules_count,$start,$sort);

$data['sort']['order'] = cs_sort('rules','manage',$start,0,1,$sort);
$data['sort']['title'] = cs_sort('rules','manage',$start,0,3,$sort);
$data['sort']['cat']   = cs_sort('rules','manage',$start,0,5,$sort);

$data['rules'] = cs_sql_select(__FILE__,'rules','*',0,$order,$start,$account['users_limit']);
$rules_loop = count($data['rules']);

for($run=0; $run<$rules_loop; $run++) {

  $data['rules'][$run]['order'] = cs_secure($data['rules'][$run]['rules_order']);
  $data['rules'][$run]['title'] = cs_secure($data['rules'][$run]['rules_title']);
  
  $cs_rules_categories = cs_sql_select(__FILE__,'categories','*',"categories_id = '" . $data['rules'][$run]['categories_id'] . "'");
  $data['rules'][$run]['cat'] = cs_secure($cs_rules_categories['categories_name']);

  $data['rules'][$run]['url_edit']   = cs_url('rules','edit','id='.$data['rules'][$run]['rules_id']);
  $data['rules'][$run]['url_remove'] = cs_url('rules','remove','id='.$data['rules'][$run]['rules_id']);
}

echo cs_subtemplate(__FILE__,$data,'rules','manage');

?>
