<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');
$cs_post = cs_post('where,access,start,sort');
$cs_get = cs_get('where,access,start,sort');
$data = array();

$folders_id = empty($cs_get['where']) ? 0 : $cs_get['where'];
if (!empty($cs_post['where']))  $folders_id = $cs_post['where'];
$access_id = empty($cs_get['access']) ? 0 : $cs_get['access'];
if (!empty($cs_post['access']))  $access_id = $cs_post['access'];
$start = empty($cs_get['start']) ? 0 : $cs_get['start'];
if (!empty($cs_post['start']))  $start = $cs_post['start'];
$sort = empty($cs_get['sort']) ? 2 : $cs_get['sort'];
if (!empty($cs_post['sort']))  $sort = $cs_post['sort'];

require_once('mods/gallery/functions.php');
$options = cs_sql_option(__FILE__,'gallery');

$where = 0;
if(!empty($folders_id) AND empty($access_id)) {
  $where = "folders_id = '" . cs_sql_escape($folders_id) . "'";
}
elseif(!empty($access_id) AND empty($folders_id)) {
  $where = "gallery_access = '" . cs_sql_escape($access_id) . "'";
}
elseif(!empty($access_id) AND !empty($folders_id)) {
  $where  = "gallery_access = '" . cs_sql_escape($access_id) . "'";
  $where .= "AND folders_id = '" . cs_sql_escape($folders_id) . "'";
}

$where_x = !empty($access_id) ? $folders_id . '&amp;access=' . $access_id : $folders_id;


$cs_sort[1] = 'gallery_id ASC';
$cs_sort[2] = 'gallery_id DESC';
$cs_sort[3] = 'gallery_titel ASC';
$cs_sort[4] = 'gallery_titel DESC';
$cs_sort[5] = 'gallery_time ASC';
$cs_sort[6] = 'gallery_time DESC';
$cs_sort[7] = 'folders_id ASC';
$cs_sort[8] = 'folders_id DESC';
$cs_sort[9] = 'gallery_status ASC';
$cs_sort[10] = 'gallery_status DESC';
$order = $cs_sort[$sort];
$gallery_count = cs_sql_count(__FILE__,'gallery',$where);

$data['manage']['head'] = cs_subtemplate(__FILE__,$data,'gallery','manage_head');

$data['head']['count'] = $gallery_count;
$data['head']['pages'] = cs_pages('gallery','manage',$gallery_count,$start,$where_x,$sort);
$data['head']['getmsg'] = cs_getmsg();


$where = '';
$status_id = '';
if (!empty($folders_id) AND empty($access_id)) {
  $where = "gal.folders_id= '" . $folders_id . "' ";
  $folder_arr = get_subfolders($folders_id);
  if (!empty($folder_arr)) {
    foreach ($folder_arr AS $cond) {
      $where .= "OR gal.folders_id = '" . $cond['folders_id'] ."' ";
    }
  }
}
if (!empty($access_id) AND empty($folders_id)) {
  $where = "gal.gallery_access = '" . $access_id . "' ";
}
if(!empty($access_id) AND !empty($folders_id)) {
  $where = "gal.folders_id = '" . $folders_id . "' AND gallery_access = '" . $access_id . "'";
}
$where = trim($where);

$access_data = array (
  0 => array('access_id' => '1', 'access_name' => $cs_lang['lev_1']),
  1 => array('access_id' => '2', 'access_name' => $cs_lang['lev_2']),
  2 => array('access_id' => '3', 'access_name' => $cs_lang['lev_3']),
  3 => array('access_id' => '4', 'access_name' => $cs_lang['lev_4']),
  4 => array('access_id' => '5', 'access_name' => $cs_lang['lev_5'])
);
  
$data['dropdown']['folders'] = make_folders_select('where',$folders_id,0,'gallery',0);
$data['dropdown']['access'] = cs_dropdown('access','access_name',$access_data,$access_id,'access_id');


$data['sort']['id'] = cs_sort('gallery','manage',$start,$where_x,1,$sort);
$data['sort']['name'] = cs_sort('gallery','manage',$start,$where_x,3,$sort);
$data['sort']['time'] = cs_sort('gallery','manage',$start,$where_x,5,$sort);
$data['sort']['folders'] = cs_sort('gallery','manage',$start,$where_x,7,$sort);
$data['sort']['status'] = cs_sort('gallery','manage',$start,$where_x,9,$sort);

$from = 'gallery gal INNER JOIN {pre}_users usr ON gal.users_id = usr.users_id ';
$from .= 'LEFT JOIN {pre}_folders fol ON gal.folders_id = fol.folders_id';
$select = 'gal.gallery_id AS gallery_id, gal.gallery_status AS gallery_status, ';
$select .= 'gal.gallery_name AS gallery_name, gal.gallery_titel AS gallery_titel, ';
$select .= 'gal.users_id AS users_id, gal.gallery_time AS gallery_time, ';
$select .= 'gal.folders_id AS folders_id, fol.folders_name AS folders_name, usr.users_active AS users_active';
$data['pictures'] = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);
$pictures_loop = count($data['pictures']);


for($run=0; $run < $pictures_loop; $run++) {

  $id = $data['pictures'][$run]['gallery_id'];

  $data['pictures'][$run]['class'] = '';
  if($data['pictures'][$run]['gallery_status'] == 0) {
    $data['pictures'][$run]['class'] = 'notpublic';
  }

  $link = 'folders_id=' . $data['pictures'][$run]['folders_id'] . '&amp;where=' . $id;
  $data['pictures'][$run]['link'] = cs_url('gallery','com_view',$link);
  
  $data['pictures'][$run]['gallery_name'] = cs_secure($data['pictures'][$run]['gallery_name']);    
    
  $data['pictures'][$run]['name'] = cs_link(cs_secure($data['pictures'][$run]['gallery_titel']),'gallery','com_view',$link);
  $to_folder = '&amp;folders_id=' . $data['pictures'][$run]['folders_id'];
  $data['pictures'][$run]['folder'] = cs_link(cs_secure($data['pictures'][$run]['folders_name']),'gallery','list',$to_folder);
  $data['pictures'][$run]['time'] = cs_date('unix',$data['pictures'][$run]['gallery_time'],1);

  $data['pictures'][$run]['id'] = $id;
}

echo cs_subtemplate(__FILE__,$data,'gallery','manage');