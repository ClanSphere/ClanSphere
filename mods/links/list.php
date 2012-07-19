<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('links');
$data = array();

$links_count = cs_sql_count(__FILE__,'links'); 
$data['head']['body'] = sprintf($cs_lang['body_list'], $links_count);

$select = 'categories_name, categories_id, categories_text';
$data['categories'] = cs_sql_select(__FILE__,'categories',$select,"categories_mod = 'links'",'categories_name',0,0);
$categories_loop = count($data['categories']);

for($run=0; $run<$categories_loop; $run++) {

  $data['categories'][$run]['name'] = cs_secure($data['categories'][$run]['categories_name']);
  $data['categories'][$run]['url'] = cs_url('links','listcat','where=' . $data['categories'][$run]['categories_id']);
  $count_links = cs_sql_count(__FILE__,'links','categories_id = ' .$data['categories'][$run]['categories_id']);
  $data['categories'][$run]['count_links'] = $count_links;
  $data['categories'][$run]['text'] = cs_secure($data['categories'][$run]['categories_text'],1,1);
} 

echo cs_subtemplate(__FILE__,$data,'links','list');
