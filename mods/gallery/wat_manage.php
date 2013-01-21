<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');
$cs_post = cs_post('start,sort');
$cs_get = cs_get('start,sort');
$data = array();

$start = empty($cs_get['start']) ? 0 : $cs_get['start'];
if (!empty($cs_post['start']))  $start = $cs_post['start'];
$sort = empty($cs_get['sort']) ? 1 : $cs_get['sort'];
if (!empty($cs_post['sort']))  $sort = $cs_post['sort'];

$cs_sort[1] = 'categories_id DESC';
$cs_sort[2] = 'categories_id ASC';
$cs_sort[3] = 'categories_name DESC';
$cs_sort[4] = 'categories_name ASC';
$order = $cs_sort[$sort];
$where = "categories_mod = 'gallery-watermark'";
$watermarks_count = cs_sql_count(__FILE__,'categories',$where);

$data['manage']['head'] = cs_subtemplate(__FILE__,$data,'gallery','manage_head');

$data['head']['count'] = $watermarks_count;
$data['head']['pages'] = cs_pages('gallery','wat_manage',$watermarks_count,$start,0,$sort);
$data['head']['getmsg'] = cs_getmsg();

$data['sort']['id'] = cs_sort('gallery','wat_manage',$start,0,1,$sort);
$data['sort']['name'] = cs_sort('gallery','wat_manage',$start,0,3,$sort);

$select = 'categories_id, categories_name, categories_picture';
$data['watermarks'] = cs_sql_select(__FILE__,'categories',$select,$where,$order,$start,$account['users_limit']);
$watermarks_loop = count($data['watermarks']);


for($run=0; $run<$watermarks_loop; $run++) {
  $pic = cs_secure($data['watermarks'][$run]['categories_picture']);
  $img_size = getimagesize('uploads/categories/' . $pic);
  $img_width = $img_size[0];
  $img_height = $img_size[1];
  $img_w_h = $img_width / $img_height;
  $img_new_height = 40;
  $img_new_width = $img_new_height * $img_w_h;

  $data['watermarks'][$run]['img'] = cs_html_img('uploads/categories/' . $pic,$img_new_height,$img_new_width);
  $data['watermarks'][$run]['name'] = cs_secure($data['watermarks'][$run]['categories_name']);
  $data['watermarks'][$run]['id'] = $data['watermarks'][$run]['categories_id'];
}

echo cs_subtemplate(__FILE__,$data,'gallery','wat_manage');