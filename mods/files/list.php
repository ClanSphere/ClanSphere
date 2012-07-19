<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('files');

require 'mods/categories/functions.php';

$where = "categories_mod = 'files' AND categories_access <= '" . $account['access_files'] . "' AND categories_subid = '0'";
$cells = 'categories_id, categories_name, categories_picture, categories_text, categories_subid';
$categories_data = cs_sql_select(__FILE__,'categories',$cells,$where,'categories_subid ASC, categories_name',0,0);
$categories_data = cs_catsort($categories_data);
$categories_loop = count($categories_data);

$data = array();
$data['categories'] = array();

for($run=0; $run < $categories_loop; $run++) {

  $data['categories'][$run]['id'] = $categories_data[$run]['categories_id'];
  $data['categories'][$run]['name'] = cs_secure($categories_data[$run]['categories_name']);
  $data['categories'][$run]['count'] = cs_sql_count(__FILE__,'files',"categories_id = '" . $categories_data[$run]['categories_id'] . "'");
  $data['categories'][$run]['text'] = '';
  $data['categories'][$run]['if']['text'] = false;
  if(!empty($categories_data[$run]['categories_text'])) {
    $data['categories'][$run]['text'] = cs_secure($categories_data[$run]['categories_text'],1);
    $data['categories'][$run]['if']['text'] = true;
  }

  $data['categories'][$run]['picture'] = '';
  $data['categories'][$run]['if']['picture'] = false;
  if(!empty($categories_data[$run]['categories_picture'])) {
    $data['categories'][$run]['picture'] = cs_html_img('uploads/categories/' . $categories_data[$run]['categories_picture']);
    $data['categories'][$run]['if']['picture'] = true;
  }  

  $sub_where = "categories_mod = 'files' AND categories_access <= '" . $account['access_files'] . "'";
  $sub_where .= " AND categories_subid = '" . $categories_data[$run]['categories_id'] . "'";
  $sub_data = cs_sql_select(__FILE__,'categories','*',$sub_where,'categories_name',0,0);
  $sub_loop = count($sub_data);
  $data['categories'][$run]['if']['subcats'] = false;
  if(!empty($sub_loop)) {
    $data['categories'][$run]['if']['subcats'] = true;
    for($runb=0; $runb < $sub_loop; $runb++) {
      $data['categories'][$run]['subs'][$runb]['name'] = cs_secure($sub_data[$runb]['categories_name']);
      $data['categories'][$run]['subs'][$runb]['id'] = $sub_data[$runb]['categories_id'];

      $sub_content = cs_sql_count(__FILE__,'files',"categories_id = '" . $sub_data[$runb]['categories_id'] . "'");
      $data['categories'][$run]['subs'][$runb]['count'] = $sub_content;
      $data['categories'][$run]['count'] += $sub_content;
    }
  }
}

echo cs_subtemplate(__FILE__,$data,'files','list');