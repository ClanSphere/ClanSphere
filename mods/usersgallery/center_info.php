<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery', 1);
$data = array();

$data['center']['head'] = cs_subtemplate(__FILE__,$data,'usersgallery','center_head');


$id = (int) $account['users_id'];

$count_pics = cs_sql_count(__FILE__,'usersgallery',"users_id='" . $id . "'");
$data['data']['count_pics'] = $count_pics;

$count_aktiv = cs_sql_count(__FILE__,'usersgallery',"users_id='" . $id . "' AND usersgallery_status=1");
$data['data']['count_active'] = $count_aktiv;

$count_inaktiv = $count_pics - $count_aktiv;
$data['data']['count_inactive'] = $count_inaktiv;

$cats = cs_sql_count(__FILE__,'folders',"folders_mod='usersgallery' AND users_id='" . $id . "'");
$data['data']['count_cats'] = $cats;

$views = cs_sql_select(__FILE__,'usersgallery','usersgallery_count','users_id=' . $id,'usersgallery_id DESC',0,0);
$loop_views = count($views);
$view = 0;
for($run=0; $run<$loop_views; $run++) {
  $a = cs_secure($views[$run]['usersgallery_count']);
  $view += $a;
}
$data['data']['count_views'] = $view;

$from = 'usersgallery ugy INNER JOIN {pre}_voted vod ON ugy.usersgallery_id = vod.voted_fid';
$where = "ugy.users_id='" . $id . "' AND vod.voted_mod='usersgallery'";
$count_votes = cs_sql_count(__FILE__,$from,$where);
$data['data']['count_votes'] = $count_votes;

$gallery = cs_sql_select(__FILE__,'usersgallery','*','users_id=' . $id,'usersgallery_id DESC',0,0);
$loop = count($gallery);
$ges_size = 0;
$ges_traffic = 0;
for($run=0; $run<$loop; $run++) {
  $file = 'uploads/usersgallery/pics/' . $gallery[$run]['usersgallery_name'];
  $count = $gallery[$run]['usersgallery_count'];
  $size = filesize($file);
  $traffic = $size*$count;
  $ges_traffic += $traffic;
  $ges_size += $size;
}
$data['data']['count_size'] = cs_filesize($ges_size,2);

$data['data']['count_trafik'] = cs_filesize($ges_traffic,2);

$options = cs_sql_option(__FILE__, 'usersgallery');

$space = 0;
if(!empty($count_pics) AND !empty($options['max_files'])) {
  $space = $count_pics / $options['max_files'] * 100;
  $space = round($space,1);
}
$data['data']['count_space'] = $space;
if($space <= 50) {
  $data['img']['01'] = 'symbols/messages/messages01.png';
}
elseif($space > 50 AND $space < 95) {
  $data['img']['01'] = 'symbols/messages/messages01_orange.png';
}
else {
  $data['img']['01'] = 'symbols/messages/messages01_red.png';
}
if(!empty($space)) {
  if($space <= 50) {
    $data['img']['02'] = 'symbols/messages/messages02.png';
  }
  elseif($space > 50 AND $space < 95) {
    $data['img']['02'] = 'symbols/messages/messages02_orange.png';
  }
  else {
    $data['img']['02'] = 'symbols/messages/messages02_red.png';
  }
}

echo cs_subtemplate(__FILE__,$data,'usersgallery','center_info');