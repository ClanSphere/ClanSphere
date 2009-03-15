<?php
// ClanSphere 2008 - www.clansphere.net
// $Id: folders_manage.php 1775 2009-02-17 20:59:11Z fay-pain $

$cs_lang = cs_translate('gallery');
$cs_post = cs_post('start,sort');
$cs_get = cs_get('start,sort');
$data = array();

$start = empty($cs_get['start']) ? 0 : $cs_get['start'];
if (!empty($cs_post['start']))  $start = $cs_post['start'];
$sort = empty($cs_get['sort']) ? 1 : $cs_get['sort'];
if (!empty($cs_post['sort']))  $sort = $cs_post['sort'];

require_once('mods/gallery/functions.php');

$cs_sort[1] = 'folders_name ASC';
$cs_sort[2] = 'folders_name DESC';
$order = $cs_sort[$sort];
$where = "folders_mod='gallery'";
$count_folders = cs_sql_count(__FILE__,'folders',$where);

$data['manage']['head'] = cs_subtemplate(__FILE__,$data,'gallery','manage_head');

$data['head']['count'] = $count_folders;
$data['head']['pages'] = cs_pages('gallery','folders_manage',$count_folders,$start,0,$sort);
$data['head']['getmsg'] = cs_getmsg();

$data['sort']['name'] = cs_sort('gallery','folders_manage',$start,0,1,$sort);

$select = 'folders_id, sub_id, folders_name, folders_order, folders_position';
$folders = cs_sql_select(__FILE__,'folders',$select,$where,'folders_id ASC',$start,0);
$loop_folders = count($folders);

$folders = make_folders_array($folders);
$data['show']['folders_box'] = make_folders_list($folders);


echo cs_subtemplate(__FILE__,$data,'gallery','folders_manage');

?>