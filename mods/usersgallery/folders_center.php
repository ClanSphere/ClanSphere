<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery', 1);
$cs_post = cs_post('start,sort');
$cs_get = cs_get('start,sort');
$data = array();

require_once('mods/gallery/functions.php');

$start = empty($cs_get['start']) ? 0 : $cs_get['start'];
if (!empty($cs_post['start']))$start = $cs_post['start'];
$sort = empty($cs_get['sort']) ? 1 : $cs_get['sort'];
if (!empty($cs_post['sort']))$sort = $cs_post['sort'];

$cs_sort[1] = 'folders_name ASC';
$cs_sort[2] = 'folders_name DESC';
$order = $cs_sort[$sort];
$where = "users_id='" . $account['users_id'] . "' AND folders_mod='usersgallery'";
$count_folders = cs_sql_count(__FILE__,'folders',$where);

$data['center']['head'] = cs_subtemplate(__FILE__,$data,'usersgallery','center_head');

$data['head']['count'] = $count_folders;
$data['head']['pages'] = cs_pages('usersgallery','folders_center',$count_folders,$start,0,$sort);
$data['head']['getmsg'] = cs_getmsg();

$data['sort']['name'] = cs_sort('usersgallery','folders_center',$start,0,1,$sort);

$select = 'folders_id, sub_id, folders_name, folders_order, folders_position';
$data['folders'] = cs_sql_select(__FILE__,'folders',$select,$where,$order,$start,$account['users_limit']);
$data['folders'] = cs_foldersort($data['folders']);
$folders_loop = !empty($data['folders']) ? count($data['folders']) : '';


for($run=0; $run<$folders_loop; $run++) {
  
  $blank = '';
  if (!empty($data['folders'][$run]['layer'])) {
    for ($i = 0; $i < $data['folders'][$run]['layer']; $i++)
      $blank .= '&nbsp;&nbsp;&nbsp;&nbsp;';
      $blank .= cs_icon('add_sub_task');
  }
  $data['folders'][$run]['layer'] = $blank;
  $data['folders'][$run]['name'] = cs_secure($data['folders'][$run]['folders_name']);
  
  $where_folder = "folders_id = '". $data['folders'][$run]['folders_id'] . "'";
  $count_pics = cs_sql_count(__FILE__,'usersgallery',$where_folder);
  $data['folders'][$run]['count'] = $count_pics;

  $data['folders'][$run]['id'] = $data['folders'][$run]['folders_id'];
}

echo cs_subtemplate(__FILE__,$data,'usersgallery','folders_center');