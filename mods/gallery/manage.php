<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');
require_once('mods/gallery/functions.php');

$data['link']['picture'] = cs_link($cs_lang['manage_pic'],'gallery','manage');
$data['link']['movies'] = cs_link($cs_lang['manage_mov'],'gallery','manage','page=movies');
$data['link']['watermark'] = cs_link($cs_lang['watermark'],'gallery','manage','page=watermark');
$data['link']['folder'] = cs_link($cs_lang['folders'],'gallery','manage','page=folders');
$data['link']['advanced'] = cs_link($cs_lang['manage_options'],'gallery','advanced');
$data['link']['info'] = cs_link($cs_lang['manage_info'],'gallery','manage','page=info');
$data['tpl']['manage_body'] = '';
$data['tpl']['manage_filder'] = '';

$data['head']['message'] = cs_getmsg();

$page = empty($_REQUEST['page']) ? '' : $_REQUEST['page'];

if($page == 'info') {
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
  echo cs_subtemplate(__FILE__,$data,'gallery','manage');
}

if($page == '') {
  empty($_REQUEST['start']) ? $start = 0 : $start = $_REQUEST['start'];
  if(!empty($_POST['folders_id']) AND empty($_POST['access_id'])) {
    $folders_id = $_POST['folders_id'];
    $where = "folders_id = '" . cs_sql_escape($folders_id) . "'";
  }

  if(!empty($_POST['access_id']) AND empty($_POST['folders_id'])) {
    $access_id = $_POST['access_id'];
    $where = "gallery_access = '" . cs_sql_escape($access_id) . "'";
  }

  if(!empty($_POST['access_id']) AND !empty($_POST['folders_id'])) {
    $access_id = $_POST['access_id'];
    $folders_id = $_POST['folders_id'];
    $where  = "gallery_access = '" . cs_sql_escape($access_id) . "'";
    $where .= "AND folders_id = '" . cs_sql_escape($folders_id) . "'";
  }

  if(empty($where)) {
    $where = 0;
  }

/*      $cs_sort[1] = 'gallery_id DESC';
  $cs_sort[2] = 'gallery_id ASC';
  $cs_sort[3] = 'gallery_titel DESC';
  $cs_sort[4] = 'gallery_titel ASC';
  $cs_sort[5] = 'gallery_time DESC';
  $cs_sort[6] = 'gallery_time ASC';
  $cs_sort[7] = 'users_id DESC';
  $cs_sort[8] = 'users_id ASC';
  $cs_sort[9] = 'gallery_status DESC';
  $cs_sort[10] = 'gallery_status ASC';
*/$cs_sort[1] = array(SORT_ASC,'gallery_id');
  $cs_sort[2] = array(SORT_DESC,'gallery_id');
  $cs_sort[3] = array(SORT_ASC,'gallery_titel');
  $cs_sort[4] = array(SORT_DESC,'gallery_titel');
  $cs_sort[5] = array(SORT_ASC,'gallery_time');
  $cs_sort[6] = array(SORT_DESC,'gallery_time');
  $cs_sort[7] = array(SORT_ASC,'folders_id');
  $cs_sort[8] = array(SORT_DESC,'folders_id');
  $cs_sort[9] = array(SORT_ASC,'gallery_status');
  $cs_sort[10] = array(SORT_DESC,'gallery_status');
  $sort = empty($_REQUEST['sort']) ? 1 : (int)$_REQUEST['sort'];
  $order = $cs_sort[$sort];

  $gallery_count = cs_sql_count(__FILE__,'gallery',$where);

  $options = cs_sql_option(__FILE__,'gallery');
//      $width = $options['thumbs'];

  $data['link']['new'] = cs_link($cs_lang['new_pic'],'gallery','picture_create');
  $data['lang']['all'] = $cs_lang['total'] . ': ';
  $data['data']['count'] = $gallery_count;
  $data['data']['pages'] = cs_pages('gallery','manage',$gallery_count,$start,0,$sort);

  $folders_id = '';
  $where = '';
  $status_id = '';
  $access_id = '';
  if (!empty($_POST['folders_id'])) {
    $folders_id = (int) $_POST['folders_id'];
    $where .= "gal.folders_id= '" . $folders_id . "' ";
    $folder_arr = get_subfolders($folders_id);
    if (!empty($folder_arr)) {
      foreach ($folder_arr AS $cond) {
        $where .= 'OR gal.folders_id = \''.$cond['folders_id'].'\' ';
      }
    }
  }
  if (!empty($_POST['access_id'])) {
    $access_id = (int) $_POST['access_id'];
    $where .= 'gal.gallery_access = \'' . $access_id . '\' ';
  }
  $where = trim($where);
  $access_data = array (
    0 => array('access_id' => '1', 'access_name' => $cs_lang['lev_1']),
    1 => array('access_id' => '2', 'access_name' => $cs_lang['lev_2']),
    2 => array('access_id' => '3', 'access_name' => $cs_lang['lev_3']),
    3 => array('access_id' => '4', 'access_name' => $cs_lang['lev_4']),
    4 => array('access_id' => '5', 'access_name' => $cs_lang['lev_5'])
  );
  
  $data['dropdown']['folders'] = make_folders_select('folders_id',$folders_id,0,'gallery',0);
  $data['dropdown']['access'] = cs_dropdown('access_id','access_name',$access_data,$access_id);

  $data['tpl']['manage_filder'] = cs_subtemplate(__FILE__,$data,'gallery','manage_filter');

/*      $from = 'gallery gal INNER JOIN {pre}_users usr ON gal.users_id = usr.users_id';
  $select = 'gal.gallery_status AS gallery_status, gal.users_id AS users_id, usr.users_nick';
  $select .= ' AS users_nick, gal.gallery_titel AS gallery_titel, gal.gallery_name AS gallery_name,';
  $select .= ' gal.gallery_id AS gallery_id, gal.gallery_time AS gallery_time';
  $cs_gallery = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);
  $gallery_loop = count($cs_gallery);
*/
  $from = 'gallery gal INNER JOIN {pre}_users usr ON gal.users_id = usr.users_id ';
  $from .= 'LEFT JOIN {pre}_folders fol ON gal.folders_id = fol.folders_id';
  $select = 'gal.gallery_id AS gallery_id, gal.gallery_status AS gallery_status, ';
  $select .= 'gal.gallery_name AS gallery_name, gal.gallery_titel AS gallery_titel, ';
  $select .= 'gal.users_id AS users_id, gal.gallery_time AS gallery_time, ';
  $select .= 'gal.folders_id AS folders_id, fol.folders_name AS folders_name, usr.users_active AS users_active';
  $cs_gallery = cs_sql_select(__FILE__,$from,$select,$where,'gal.gallery_id DESC',$start,$account['users_limit']);
  $gallery_loop = count($cs_gallery);
  $cs_gallery = cs_gallery_move($cs_gallery,$options['list_sort']);
  $cs_gallery = cs_array_sort($cs_gallery,$order[0],$order[1]);
  $data['sort']['status'] = cs_sort('gallery','manage',$start,0,9,$sort);
  $data['sort']['id'] = cs_sort('gallery','manage',$start,0,1,$sort);
  $data['sort']['titel'] = cs_sort('gallery','manage',$start,0,3,$sort);
  $data['sort']['name'] = cs_sort('gallery','manage',$start,0,7,$sort);
  $data['sort']['time'] = cs_sort('gallery','manage',$start,0,5,$sort);
  $data['lang']['time'] = $cs_lang['date'];

  for($run=0; $run < $gallery_loop; $run++) {
    $box_data = cs_box($cs_gallery,$run);
    $box[$run]['box'] = cs_subtemplate(__FILE__,$box_data,'usersgallery','pictures_box');
  }
  $data['tpl']['manage_body'] = cs_subtemplate(__FILE__,$data,'gallery','manage_body');
  $data['data']['show'] = cs_subtemplate(__FILE__,$data,'gallery','manage_pictures');
  $data['box'] = !empty($box) ? $box : '';
  echo cs_subtemplate(__FILE__,$data,'gallery','manage');
}

if($page == 'watermark') {
  empty($_REQUEST['start']) ? $start = 0 : $start = $_REQUEST['start'];
  $cs_sort[1] = 'categories_id DESC';
  $sort = empty($_REQUEST['sort']) ? 1 : (int)$_REQUEST['sort'];
  $order = $cs_sort[$sort];
  $cs_gallery = cs_sql_select(__FILE__,'categories','*',"categories_mod = 'gallery-watermark'",$order,$start,$account['users_limit']);
  $gallery_count = count($cs_gallery);

  $data['link']['new'] = cs_link($cs_lang['new_watermark'],'gallery','wat_create');
  $data['lang']['all'] = $cs_lang['total'] . ': ';
  $data['data']['count'] = $gallery_count;
  $data['data']['pages'] = cs_pages('gallery','manage',$gallery_count,$start,0,$sort. '&amp;watermark');

  for($run=0; $run<$gallery_count; $run++)
  {
    $pic = cs_secure($cs_gallery[$run]['categories_picture']);
    $img_size = getimagesize('uploads/categories/' . $pic);
    $img_width = $img_size[0];
    $img_height = $img_size[1];
    $img_w_h = $img_width / $img_height;
    $img_new_height = 40;
    $img_new_width = $img_new_height * $img_w_h;

    $box_data['data']['img'] = cs_html_img('uploads/categories/' . $pic,$img_new_height,$img_new_width);
    $box_data['data']['name'] = cs_secure($cs_gallery[$run]['categories_name']);

    $img_edit = cs_icon('edit','16',$cs_lang['edit']);
    $box_data['link']['edit'] = cs_link($img_edit,'gallery','wat_edit','id=' . $cs_gallery[$run]['categories_id'],0,$cs_lang['edit']);
    $img_del = cs_icon('editdelete','16',$cs_lang['remove']);
    $box_data['link']['remove'] = cs_link($img_del,'gallery','wat_remove','id=' . $cs_gallery[$run]['categories_id'],0,$cs_lang['remove']);
    $box[$run]['box'] = cs_subtemplate(__FILE__,$box_data,'gallery','manage_watermark_box');
  }
  echo cs_html_table(0);
  $data['tpl']['manage_body'] = cs_subtemplate(__FILE__,$data,'gallery','manage_body');
  $data['data']['show'] = cs_subtemplate(__FILE__,$data,'gallery','manage_watermark');
  $data['box'] = !empty($box) ? $box : '';
  echo cs_subtemplate(__FILE__,$data,'gallery','manage');
}

if($page == 'movies') {
  empty($_REQUEST['start']) ? $start = 0 : $start = $_REQUEST['start'];
  $cs_sort[1] = 'movies_id DESC';
  $sort = empty($_REQUEST['sort']) ? 1 : (int)$_REQUEST['sort'];
  $order = $cs_sort[$sort];
  $data['link']['new'] = '';//cs_link($cs_lang['new_movie'],'gallery','movie_create');
  $data['lang']['all'] = $cs_lang['total'] . ': ';
  $data['data']['count'] = '0';
  $data['data']['pages'] = cs_pages('gallery','manage',0,$start,0,$sort. '&amp;movies');
  $data['tpl']['manage_body'] = cs_subtemplate(__FILE__,$data,'gallery','manage_body');
  //$data['data']['show'] = cs_subtemplate(__FILE__,$data,'gallery','manage_watermark');
  //$data['box'] = !empty($box) ? $box : '';
  echo cs_subtemplate(__FILE__,$data,'gallery','manage');
  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'centerc');
  echo 'coming soon';
  echo cs_html_roco(0);
  echo cs_html_table(0);
}

if($page == 'folders') {

  $start = empty($_REQUEST['start']) ? 0 : (int) $_REQUEST['start'];
  $sort = empty($_REQUEST['sort']) ? 1 : (int) $_REQUEST['sort'];
  
  $cs_sort[1] = array(SORT_ASC,'folders_name');
  $cs_sort[2] = array(SORT_DESC,'folders_name');
  $order = $cs_sort[$sort];
  
  $from = 'folders';
  $select = 'folders_id, sub_id, ';
  $select .= 'folders_name, folders_order, folders_position';
  $where = "folders_mod='gallery'";
  $order = 'folders_id ASC';
  $array = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,0);
  $loop = count($array);
  $data['link']['new'] = cs_link($cs_lang['new_folder'],'gallery','folders_create');
  $data['lang']['all'] = $cs_lang['total'] . ': ';
  $data['data']['count'] = $loop;
  $data['data']['pages'] = cs_pages('gallery','manage',$loop,$start,0,$sort . '&amp;page=folders');
  $data['sort']['name'] = cs_sort('gallery','manage',$start,'&amp;page=folders',1,$sort);
  $folders = make_folders_array($array);
  $data2['show']['folders_box'] = make_folders_list($folders);
  $data['tpl']['manage_body'] = cs_subtemplate(__FILE__,$data,'gallery','manage_body');
  #echo $data2['folders_box'];
  $data['data']['show'] = cs_subtemplate(__FILE__,$data2,'gallery','folders');
  
  echo cs_subtemplate(__FILE__,$data,'gallery','manage');
  
}
?>
