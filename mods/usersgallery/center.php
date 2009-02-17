<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$
$cs_lang = cs_translate('gallery');
require_once('mods/usersgallery/functions.php');

$where = empty($_GET['where']) ? 0 : 'cat';
$page = empty($_REQUEST['page']) ? $where : $_REQUEST['page'];
$start = empty($_REQUEST['start']) ? 0 : (int) $_REQUEST['start'];
$sort = empty($_REQUEST['sort']) ? 1 : (int) $_REQUEST['sort'];

$cs_sort[1] = array(SORT_ASC,'users_id');
$cs_sort[2] = array(SORT_DESC,'users_id');
#$cs_sort[3] = array(SORT_ASC,'usersgallery_titel');
#$cs_sort[4] = array(SORT_DESC,'usersgallery_titel');
#$cs_sort[5] = array(SORT_ASC,'usersgallery_time');
#$cs_sort[6] = array(SORT_DESC,'usersgallery_time');
$cs_sort[7] = array(SORT_ASC,'folders_name');
$cs_sort[8] = array(SORT_DESC,'folders_name');

$order = $cs_sort[$sort];

$id = $account['users_id'];
$options = cs_sql_option(__FILE__,'gallery');

$data = array();
$data['lang']['getmsg'] = cs_getmsg();
$link = $cs_lang['manage_pic'];
$data['link']['picture'] = cs_link($link,'usersgallery','center','page=pic');
$link =  $cs_lang['folders'];
$data['link']['folder'] =  cs_link($link,'usersgallery','center','page=cat');
$link =  $cs_lang['info'];
$data['link']['info'] = cs_link($link,'usersgallery','center','page=info');

if($page == 'pic' OR $page == '0') {
  $count = cs_sql_count(__FILE__,'usersgallery',"users_id = '" . $id . "'");
  $data['link']['new'] = cs_link($cs_lang['new_pic'],'usersgallery','users_create');
  $data['lang']['all'] = $cs_lang['total'] . ': ';
  $data['data']['count'] = $count;
  $data['data']['pages'] = cs_pages('usersgallery','center',$count,$start,0,$sort);

  $from = 'usersgallery ugy INNER JOIN {pre}_users usr ON ugy.users_id = usr.users_id ';
  $from .= 'INNER JOIN {pre}_folders fol ON ugy.folders_id = fol.folders_id';
  $where = "ugy.users_id = '" . $id . "'";
  $select = 'ugy.usersgallery_id AS usersgallery_id, ugy.usersgallery_status AS usersgallery_status, ';
  $select .= 'ugy.usersgallery_name AS usersgallery_name, ugy.usersgallery_titel AS usersgallery_titel, ';
  $select .= 'ugy.users_id AS users_id, ugy.usersgallery_time AS usersgallery_time, ';
  $select .= 'ugy.folders_id AS folders_id, fol.folders_name AS folders_name, usr.users_active AS users_active';
  $cs_usersgallery = cs_sql_select(__FILE__,$from,$select,$where,'ugy.usersgallery_id DESC',$start,$account['users_limit']);
  $loop = count($cs_usersgallery);
  $cs_usersgallery = cs_gallery_move($cs_usersgallery,$options['list_sort']);
  $cs_usersgallery = cs_array_sort($cs_usersgallery,$order[0],$order[1]);

  $data['sort']['time'] = cs_sort('usersgallery','center',$start,0,5,$sort);
  $data['sort']['titel'] = cs_sort('usersgallery','center',$start,0,3,$sort);
  $data['sort']['name'] = cs_sort('usersgallery','center',$start,0,7,$sort);
  $data['lang']['time'] = $cs_lang['date'];
  for($run=0; $run<$loop; $run++) {
    $box_data = cs_box($cs_usersgallery,$run);
    $box[$run]['box'] = cs_subtemplate(__FILE__,$box_data,'usersgallery','pictures_box');
  }
  
  $data['data']['show'] = cs_subtemplate(__FILE__,$data,'usersgallery','pictures');
  $data['folders'] = !empty($box) ? $box : array();
  #print_r($data['folders']);
  echo cs_subtemplate(__FILE__,$data,'usersgallery','center');
  
} elseif($page == 'info') {
  $data['head']['action'] = $cs_lang['info'];
  $data['head']['mod'] = $cs_lang['mod'];

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

  $space = 0;
  if(!empty($count_pics)) {
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
  echo cs_subtemplate(__FILE__,$data,'usersgallery','info');
}
elseif($page == 'cat') {

  $from = 'folders';
  $select = 'folders_id, sub_id, ';
  $select .= 'folders_name, folders_order, folders_position';
  $where = "users_id='" . $id . "' AND folders_mod='usersgallery'";
  #$order = 'folders_id ASC';
  $array = cs_sql_select(__FILE__,$from,$select,$where,$order[1],$start,0);
  $loop = count($array);
  $data['link']['new'] = cs_link($cs_lang['new_folder'],'usersgallery','folders_create');
  $data['lang']['all'] = $cs_lang['total'] . ': ';
  $data['data']['count'] = $loop;
  $data['data']['pages'] = cs_pages('usersgallery','center',$loop,$start,0,$sort . '&amp;page=cat');
  $data['sort']['time'] = cs_sort('usersgallery','center',$start,1,7,$sort);
  #$data['folders'] = make_folders_array($array);
  $data['sort']['folder'] = cs_sort('usersgallery','center',$start,1,7,$sort);
  
  $array = make_folders_array($array);
  $data2['folders_box'] = make_folders_list($array);
  $data['data']['show'] = cs_subtemplate(__FILE__,$data2,'usersgallery','folders');
  echo cs_subtemplate(__FILE__,$data,'usersgallery','center_cat');
}

?>