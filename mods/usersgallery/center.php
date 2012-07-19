<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery',1);
$cs_post = cs_post('start,sort');
$cs_get = cs_get('start,sort');
$data = array();

require_once('mods/gallery/functions.php');
$options = cs_sql_option(__FILE__,'gallery'); #??

$start = empty($cs_get['start']) ? 0 : $cs_get['start'];
if (!empty($cs_post['start']))$start = $cs_post['start'];
$sort = empty($cs_get['sort']) ? 1 : $cs_get['sort'];
if (!empty($cs_post['sort'])) $sort = $cs_post['sort'];

$id = $account['users_id'];

$cs_sort[1] = 'gallery_id ASC';
$cs_sort[2] = 'gallery_id DESC';
$cs_sort[3] = 'gallery_titel ASC';
$cs_sort[4] = 'gallery_titel DESC';
$cs_sort[5] = 'gallery_time ASC';
$cs_sort[6] = 'gallery_time DESC';
$cs_sort[7] = 'folders_id ASC';
$cs_sort[8] = 'folders_id DESC';
$order = $cs_sort[$sort];
$count = cs_sql_count(__FILE__,'usersgallery',"users_id = '" . $id . "'");

$data['center']['head'] = cs_subtemplate(__FILE__,$data,'usersgallery','center_head');

$data['head']['count'] = $count;
$data['head']['pages'] = cs_pages('usersgallery','center',$count,$start,0,$sort);
$data['head']['getmsg'] = cs_getmsg();

$data['sort']['id'] = cs_sort('usersgallery','center',$start,0,1,$sort);
$data['sort']['name'] = cs_sort('usersgallery','center',$start,0,3,$sort);
$data['sort']['date'] = cs_sort('usersgallery','center',$start,0,5,$sort);
$data['sort']['folder'] = cs_sort('usersgallery','center',$start,0,7,$sort);

$from = 'usersgallery ugy INNER JOIN {pre}_users usr ON ugy.users_id = usr.users_id ';
$from .= 'INNER JOIN {pre}_folders fol ON ugy.folders_id = fol.folders_id';
$where = "ugy.users_id = '" . $id . "'";
$select = 'ugy.usersgallery_id AS usersgallery_id, ugy.usersgallery_status AS usersgallery_status, ';
$select .= 'ugy.usersgallery_name AS usersgallery_name, ugy.usersgallery_titel AS usersgallery_titel, ';
$select .= 'ugy.users_id AS users_id, ugy.usersgallery_time AS usersgallery_time, ugy.folders_id AS folders_id, ';
$select .= 'fol.folders_name AS folders_name, usr.users_active AS users_active, usr.users_delete AS users_delete';
$data['pictures'] = cs_sql_select(__FILE__,$from,$select,$where,'ugy.usersgallery_id DESC',$start,$account['users_limit']);
$pictures_loop = count($data['pictures']);


for($run=0; $run < $pictures_loop; $run++) {

  $pid = $data['pictures'][$run]['usersgallery_id'];

  $data['pictures'][$run]['class'] = '';
  if($data['pictures'][$run]['usersgallery_status'] == 0) {
    $data['pictures'][$run]['class'] = 'notpublic';
  }

  $link = 'id=' . $id . '&amp;cat_id=' . $data['pictures'][$run]['folders_id'] . '&amp;more=1';
  $data['pictures'][$run]['link'] = cs_url('usersgallery','com_view',$link);
      
  $data['pictures'][$run]['name'] = cs_link(cs_secure($data['pictures'][$run]['usersgallery_titel']),'usersgallery','com_view',$link);
  $to_folder = 'id=' . $id . '&amp;cat_id=' . $data['pictures'][$run]['folders_id'];
  $data['pictures'][$run]['folder'] = cs_link(cs_secure($data['pictures'][$run]['folders_name']),'usersgallery','users',$to_folder);
  $data['pictures'][$run]['time'] = cs_date('unix',$data['pictures'][$run]['usersgallery_time'],1);

  $data['pictures'][$run]['id'] = $pid;
}

echo cs_subtemplate(__FILE__,$data,'usersgallery','center');