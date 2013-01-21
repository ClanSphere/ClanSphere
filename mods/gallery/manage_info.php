<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = $cs_lang = cs_translate('gallery');
$data = array();

$data['manage']['head'] = cs_subtemplate(__FILE__,$data,'gallery','manage_head');

$data['data']['info_pics'] = cs_sql_count(__FILE__,'gallery');
$data['data']['info_pics_activ'] = cs_sql_count(__FILE__,'gallery','gallery_status=1');
$data['data']['info_pics_inactiv'] = $data['data']['info_pics'] - $data['data']['info_pics_activ'];
$data['data']['info_folders'] = cs_sql_count(__FILE__,'folders',"folders_mod='gallery'");

$gallery_views = cs_sql_select(__FILE__,'gallery','gallery_count,gallery_count_cards',0,'gallery_id DESC',0,0);
$loop_views = count($gallery_views);
$views = 0;
for($run=0; $run<$loop_views; $run++) {
  $a = cs_secure($gallery_views[$run]['gallery_count']);
  $views += $a;
}

$cards = 0;
for($run=0; $run<$loop_views; $run++) {
  $a = cs_secure($gallery_views[$run]['gallery_count_cards']);
  $cards += $a;
}
$data['data']['info_views'] = $views;
$data['data']['info_ecards'] = $cards;
$data['data']['info_votes'] = cs_sql_count(__FILE__,'voted',"voted_mod='gallery'");

$count_downloads = cs_sql_select(__FILE__,'gallery','gallery_count_downloads',0,'gallery_id DESC',0,0);
$loop_downloads = count($count_downloads);
$downloads = 0;
for($run=0; $run<$loop_downloads; $run++) {
  $a = cs_secure($count_downloads[$run]['gallery_count_downloads']);
  $downloads += $a;
}
$data['data']['info_downloads'] = $downloads;

$cs_gallery_pic = cs_sql_select(__FILE__,'gallery','*',0,'gallery_id DESC',0,0);
$gallery_loop_pic = count($cs_gallery_pic);
$ges_size = 0;
for($run=0; $run<$gallery_loop_pic; $run++) {
  $file = 'uploads/gallery/pics/' . $cs_gallery_pic[$run]['gallery_name'];
  $size = filesize($file);
  $size = $size;
  $ges_size += $size;
}
$data['data']['info_picsize'] = cs_filesize($ges_size);

$ges_size = 0;
for($run=0; $run<$gallery_loop_pic; $run++) {
  $file = 'uploads/gallery/pics/' . $cs_gallery_pic[$run]['gallery_name'];
  $count = $cs_gallery_pic[$run]['gallery_count'];
  $size = filesize($file);
  $size = $size;
  $size = $size*$count;
  $ges_size += $size;
}
$data['data']['info_trafik'] = cs_filesize($ges_size);

$data['data']['info_user_pics'] = cs_sql_count(__FILE__,'usersgallery');
$data['data']['info_user_pics_activ'] = cs_sql_count(__FILE__,'usersgallery','usersgallery_status=1');
$data['data']['info_user_pics_inactiv'] = $data['data']['info_pics'] - $data['data']['info_pics_activ'];
$data['data']['info_user_folders'] = cs_sql_count(__FILE__,'folders',"folders_mod='usersgallery'");

$gallery_views = cs_sql_select(__FILE__,'usersgallery','usersgallery_count, usersgallery_count_cards',0,'usersgallery_id DESC',0,0);
$loop_views = count($gallery_views);
$views = 0;
for($run=0; $run<$loop_views; $run++) {
  $a = cs_secure($gallery_views[$run]['usersgallery_count']);
  $views += $a;
}
$cards = 0;
for($run=0; $run<$loop_views; $run++) {
  $a = cs_secure($gallery_views[$run]['usersgallery_count_cards']);
  $cards += $a;
}
$data['data']['info_user_views'] = $views;
$data['data']['info_user_ecards'] = $cards;
$data['data']['info_user_votes'] = cs_sql_count(__FILE__,'voted',"voted_mod='usersgallery'");

$count_downloads = cs_sql_select(__FILE__,'usersgallery','usersgallery_count_downloads',0,'usersgallery_id DESC',0,0);
$loop_downloads = count($count_downloads);
$downloads = 0;
for($run=0; $run<$loop_downloads; $run++) {
  $a = cs_secure($count_downloads[$run]['usersgallery_count_downloads']);
  $downloads += $a;
}
$data['data']['info_user_downloads'] = $downloads;

$cs_gallery_pic = cs_sql_select(__FILE__,'usersgallery','*',0,'usersgallery_id DESC',0,0);
$gallery_loop_pic = count($cs_gallery_pic);
$ges_size = 0;
for($run=0; $run<$gallery_loop_pic; $run++) {
  $file = 'uploads/usersgallery/pics/' . $cs_gallery_pic[$run]['usersgallery_name'];
  $size = filesize($file);
  $size = $size;
  $ges_size += $size;
}
$data['data']['info_user_picsize'] = cs_filesize($ges_size);

$ges_size = 0;
for($run=0; $run<$gallery_loop_pic; $run++) {
  $file = 'uploads/usersgallery/pics/' . $cs_gallery_pic[$run]['usersgallery_name'];
  $count = $cs_gallery_pic[$run]['usersgallery_count'];
  $size = filesize($file);
  $size = $size;
  $size = $size*$count;
  $ges_size += $size;
}
$data['data']['info_user_trafik'] = cs_filesize($ges_size);
$data['data']['show'] = cs_subtemplate(__FILE__,$data,'gallery','manage_info');
  

echo cs_subtemplate(__FILE__,$data,'gallery','manage_info');