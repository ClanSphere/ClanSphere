<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');
require_once('mods/gallery/functions.php');

$options = cs_sql_option(__FILE__, 'gallery');

$data = array();
$data['options'] = $options;

$rows = $options['rows'];
$cols_rows = $options['cols'] * $rows;

$start = empty($_REQUEST['start']) ? 0 : (int)$_REQUEST['start'];
$folders_id = empty($_REQUEST['folders_id']) ? 0 : (int)$_REQUEST['folders_id'];

$access_id = $account['access_gallery'];

if (empty($folders_id)) {
  $data['lang']['getmsg'] = cs_getmsg();
  
  $from = 'gallery';
  $select = 'gallery_time, gallery_name, gallery_titel, ';
  $select .= 'gallery_description, gallery_id, gallery_vote, gallery_count, folders_id';
  $where = "gallery_status = '1' AND gallery_access <= '" . $access_id . "'";
  $order = 'gallery_id DESC';
  $cs_gallery = cs_sql_select(__FILE__, $from, $select, $where, $order, $start, 0);
  $gallery_loop = count($cs_gallery);
  
  $from = 'folders';
  $select = 'folders_id, sub_id, folders_name, folders_picture, folders_text, folders_position';
  $where = "folders_mod = 'gallery' AND folders_access <= '" . $access_id . "'";
  $order = 'folders_position ASC';
  $folders = cs_sql_select(__FILE__, $from, $select, $where, $order, '', 0);
  $folders_loop = count($folders);
  
  if (empty($folders_loop)) {
    $no_cat['lang']['no_cat'] = $cs_lang['list_no_cat'];
  }
  
  //  $data['tmp']['no_cat'] = empty($no_cat) ? '' : cs_subtemplate(__FILE__,$no_cat,'gallery','users_error_1');
  
  if (!empty($folders_loop)) {
    $run = 0;
    foreach ($folders as $a) {
      if ($a['sub_id'] == '0') {
        if (empty($a['folders_picture'])) {
          $cs_lap = cs_html_img('symbols/gallery/image.gif');
        } else {
          $cs_lap = cs_html_img("uploads/folders/" . $a['folders_picture']);
        }
        
        $cat[$run]['img'] = cs_link($cs_lap, 'gallery', 'list', 'folders_id=' . $a['folders_id']);
        $more = 'folders_id=' . $a['folders_id'];
        $cat[$run]['folders_name'] = cs_link($a['folders_name'], 'gallery', 'list', $more);
        $cat[$run]['folders_text'] = !empty($a['folders_text']) ? cs_secure($a['folders_text'], 1, 1) : cs_html_br(1);
        $cat_id_a = $a['folders_id'];
        $pic_loop = '0';
        $last_update = '0';
        
        for ($run_2 = 0; $run_2 < $gallery_loop; $run_2++) {
          $gal_cat_id = $cs_gallery[$run_2]['folders_id'];
          
          if ($cat_id_a == $gal_cat_id) {
            $pic_loop++;
            
            if ($last_update <= $cs_gallery[$run_2]['gallery_time']) {
              $last_update = $cs_gallery[$run_2]['gallery_time'];
            }
          }
        }
        
        $select = 'sub.sub_id AS sub_id, sub.folders_id AS folders_id, gal.folders_id AS folders_id, gal.gallery_time AS gallery_time';
        $from = 'folders sub INNER JOIN {pre}_gallery gal ON sub.folders_id = gal.folders_id ';
        $where = "sub.sub_id='" . $a['folders_id'] . "'";
        $order = "gallery_id DESC";
        $count = cs_sql_select(__FILE__, $from, $select, $where, 0, 0, 0);
        $count2 = cs_sql_select(__FILE__, $from, $select, $where, $order, 0, 1);
        $plus = count($count);
        
        if ($last_update <= $count2['gallery_time']) {
          $last_update = $count2['gallery_time'];
        }
        
        if ($pic_loop == 1 or $plus == 1) {
          $cat[$run]['pic_count'] = sprintf($cs_lang['pic_1'], $pic_loop);
          
          if (!empty($last_update)) {
            $cat[$run]['last_update'] = $cs_lang['pic_akt'] . cs_date('unix', $last_update, 1);
          }
        } else {
          $cat[$run]['pic_count'] = sprintf($cs_lang['pic_2'], $pic_loop + $plus);
          
          if (!empty($last_update)) {
            $cat[$run]['last_update'] = $cs_lang['pic_akt'] . cs_date('unix', $last_update, 1);
          } else {
            $cat[$run]['last_update'] = '';
          }
        }
        $run++;
      }
    }
    
    if (!empty($cs_gallery) and $options['top_5_views'] == '1') {
      $cs_gallery = cs_array_sort($cs_gallery, SORT_DESC, 'gallery_count');
      
      if ($gallery_loop > $rows) {
        $run_to = $rows;
      } else {
        $run_to = $gallery_loop;
      }
      
      if ($run_to == 1) {
        $data['lang']['top'] = $cs_lang['top1'];
      } else {
        $data['lang']['top'] = sprintf($cs_lang['top'], $run_to);
      }
      
      for ($run = 0; $run < $run_to; $run++) {
        $top_views[$run]['img'] = $cs_gallery[$run]['gallery_id'];
        $cs_lap = cs_html_img('symbols/gallery/nowatermark.gif', '100', $options['thumbs']);
        $more = 'where=' . $cs_gallery[$run]['gallery_id'];
        $top_views[$run]['link'] = cs_link($cs_lap, 'gallery', 'com_view', $more);
      }
      $data['top_views'] = !empty($top_views) ? $top_views : '';
    }
    
    $top_views_1['0']['top_views_1'] = empty($data['top_views']) ? '' : '1';
    $data['top_views_1'] = !empty($top_views_1['0']['top_views_1']) ? $top_views_1 : '';
    
    
    // Latest  5 Pictures!
    if (!empty($cs_gallery) and $options['newest_5'] == '1') {
      $cs_gallery = cs_array_sort($cs_gallery, SORT_DESC, 'gallery_time');
      if ($gallery_loop > $rows) {
        $run_to = $rows;
      } else {
        $run_to = $gallery_loop;
      }
      
      if ($run_to == 1) {
        $data['lang']['last_update'] = $cs_lang['newest1'];
      } else {
        $data['lang']['last_update'] = sprintf($cs_lang['newest'], $run_to);
      }
      
      $last_update = '';
      
      for ($run = 0; $run < $run_to; $run++) {
        $last_update[$run]['img'] = $cs_gallery[$run]['gallery_id'];
        $cs_lap = cs_html_img('symbols/gallery/nowatermark.gif', '100', $options['thumbs']);
        $more = 'where=' . $cs_gallery[$run]['gallery_id'];
        $last_update[$run]['link'] = cs_link($cs_lap, 'gallery', 'com_view', $more);
      }
      $data['last_update'] = !empty($last_update) ? $last_update : '';
    }
    
    $last_update_1['0']['last_update'] = empty($data['last_update']) ? '' : '1';
    $data['last_update_1'] = !empty($last_update_1['0']['last_update']) ? $last_update_1 : '';
    
    // Top 5 voted pictures!
    if ($options['top_5_votes'] == '1') {
      $from = 'voted vod INNER JOIN {pre}_gallery gal ON vod.voted_fid = gal.gallery_id';
      $select = 'gal.gallery_id AS gallery_id, vod.voted_answer AS voted_answer';
      $where = "gal.gallery_status = '1' AND vod.voted_mod = 'gallery'";
      $order = 'gal.gallery_id ASC';
      $cs_gallery_voted = cs_sql_select(__FILE__, $from, $select, $where, $order, 0, 0);
      $voted_loop = count($cs_gallery_voted);
      
      for ($run = 0; $run < $voted_loop; $run++) {
        if ($run !== 0) {
          $run2 = $run - 1;
          
          if ($cs_gallery_voted[$run]['gallery_id'] == $cs_gallery_voted[$run2]['gallery_id']) {
            $x[$cs_gallery_voted[$run]['gallery_id']] += $cs_gallery_voted[$run]['voted_answer'];
            $y[$cs_gallery_voted[$run]['gallery_id']] += 1;
          }
          
          if ($cs_gallery_voted[$run]['gallery_id'] !== $cs_gallery_voted[$run2]['gallery_id']) {
            $x[$cs_gallery_voted[$run]['gallery_id']] = $cs_gallery_voted[$run]['voted_answer'];
            $y[$cs_gallery_voted[$run]['gallery_id']] = 1;
          }
        } else {
          $x[$cs_gallery_voted[$run]['gallery_id']] = $cs_gallery_voted[$run]['voted_answer'];
          $y[$cs_gallery_voted[$run]['gallery_id']] = 1;
        }
      }
      $x_loop = empty($x) ? 0 : count($x);
      
      if (!empty($x_loop)) {
        if ($voted_loop == 1) {
          $data['lang']['vote'] = $cs_lang['vote1'];
        } else {
          if ($voted_loop > $rows) {
            $count_voted_pics = $rows;
          } else {
            $count_voted_pics = $voted_loop;
          }
          $data['lang']['vote'] = sprintf($cs_lang['vote'], $count_voted_pics);
        }
        
        for ($run = 0; $run < $voted_loop; $run++) {
          if ($run !== 0) {
            $run3 = $run - 1;
            
            if ($cs_gallery_voted[$run]['gallery_id'] !== $cs_gallery_voted[$run3]['gallery_id']) {
              $w = $x[$cs_gallery_voted[$run]['gallery_id']] / $y[$cs_gallery_voted[$run]['gallery_id']];
              $z[$run4] = array("gallery_id" => $cs_gallery_voted[$run]['gallery_id'], "voted_answer" => $w);
              $run4++;
            }
          } else {
            $run4 = 0;
            $w = $x[$cs_gallery_voted[$run]['gallery_id']] / $y[$cs_gallery_voted[$run]['gallery_id']];
            $z[$run4] = array("gallery_id" => $cs_gallery_voted[$run]['gallery_id'], "voted_answer" => $w);
            $run4++;
          }
        }
        $z_loop = empty($z) ? 0 : count($z);
        
        if ($z_loop > $rows) {
          $run_to = $rows;
        } else {
          $run_to = $z_loop;
        }
        
        if (!empty($z)) {
          $z = cs_array_sort($z, SORT_ASC, 'voted_answer');
        }
        
        for ($run = 0; $run < $run_to; $run++) {
          $vote[$run]['img'] = $z[$run]['gallery_id'];
          $cs_lap = cs_html_img('symbols/gallery/nowatermark.gif', '100', $options['thumbs']);
          $vote[$run]['link'] = cs_link($cs_lap, 'gallery', 'com_view', 'where=' . $vote[$run]['img']);
        }
        $data['vote'] = !empty($vote) ? $vote : '';
      }
    }
  }
  
  $vote_1['0']['vote'] = empty($data['vote']) ? '' : '1';
  $data['vote_1'] = !empty($vote_1['0']['vote']) ? $vote_1 : '';
  $data['tmp']['no_cat'] = empty($no_cat) ? '' : cs_subtemplate(__FILE__, $no_cat, 'usersgallery', 'users_error_1');
  $data['cat'] = !empty($cat) ? $cat : array();
  
  if (empty($cat)) {
    $data['top_views_1'] = array();
    $data['last_update_1'] = array();
  }
  
  echo cs_subtemplate(__FILE__, $data, 'gallery', 'list');
}

if ($folders_id >= 1) {
  $from = 'gallery';
  $select = 'gallery_time, gallery_name, gallery_titel, ';
  $select .= 'gallery_description, gallery_id, gallery_vote, gallery_count, folders_id';
  $where = "gallery_status = 1 AND gallery_access <= '" . $access_id . "'";
  $where .= " AND folders_id = '" . (int)$folders_id . "'";
  switch ($options['list_sort']) {
    case 0:
      $order = 'gallery_id DESC';
      break;
    case 1:
      $order = 'gallery_id ASC';
      break;
  }
  
  $cs_gallery = cs_sql_select(__FILE__, $from, $select, $where, $order, $start, $cols_rows);
  $gallery_loop = count($cs_gallery);
  $gallery_count = cs_sql_count(__FILE__, 'gallery', $where);
  $from = 'folders';
  $select = 'folders_id, sub_id, folders_name, folders_picture, folders_text, folders_access';
  $where = "folders_mod = 'gallery' AND folders_id = '" . $folders_id . "'";
  $folders_current = cs_sql_select(__FILE__, $from, $select, $where);
  
  if ($folders_current['folders_access'] > $access_id) {
    return;
  }
  
  $where = "folders_mod = 'gallery'";
  $folders = cs_sql_select(__FILE__, $from, $select, $where, 0, 0, 0);
  $folders_loop = count($folders);
  $data['link']['gallery'] = cs_link($cs_lang['mod_name'], 'gallery', 'list');
  $data['link']['subfolders'] = make_folders_head($folders, $folders_current['sub_id'], $folders_current['folders_name']);
  $data['data']['folders_name'] = $folders_current['folders_name'];
  
  if (!empty($folders_loop)) {
    $loop = 0;
    for ($run = 0; $run < $folders_loop; $run++) {
      if ($folders[$run]['sub_id'] == $folders_current['folders_id']) {
        if (empty($folders[$run]['folders_picture'])) {
          $cs_lap = cs_html_img('symbols/gallery/image.gif');
        } else {
          $cs_lap = cs_html_img("uploads/folders/" . $folders[$run]['folders_picture']);
        }
        
        $more = 'folders_id=' . $folders[$run]['folders_id'];
        $sub_folders[$loop]['folders_img'] = cs_link($cs_lap, 'gallery', 'list', $more);
        $sub_folders[$loop]['folders_name'] = $folders[$run]['folders_name'];
        $loop++;
      }
    }
    $data['sub_folders'] = !empty($sub_folders) ? $sub_folders : '';
  }
  
  if (!empty($gallery_loop)) {
    for ($run = 0; $run < $gallery_loop; $run++) {
      $num = $start + $run;
      $img[$run]['img'] = $cs_gallery[$run]['gallery_id'];
      $cs_lap = cs_html_img('symbols/gallery/nowatermark.gif', '100', $options['thumbs']);
      $img[$run]['link'] = cs_link($cs_lap, 'gallery', 'com_view', 'folders_id=' . $folders_id . '&amp;where=' . $cs_gallery[$run]['gallery_id']);
    }
    $data['img'] = !empty($img) ? $img : '';
    $data['data']['pages'] = cs_pages('gallery', 'list', $gallery_count, $start, 0, 1, $cols_rows, 0, 'folders_id=' . $folders_id);
  } elseif (empty($data['sub_folders'])) {
    $data['img'] = '';
    $data['data']['pages'] = '';
    $empty_cat['lang']['empty_cat'] = $cs_lang['empty_cat'];
  } else {
    $data['data']['pages'] = cs_pages('gallery', 'list', 0, 0);
    $data['img'] = '';
  }
  
  if (empty($empty_cat['lang']['empty_cat']) and !empty($folders_id)) {
    $cat_list_1['0']['cat_list_1'] = '1';
  } else {
    $cat_list_1['0']['cat_list_1'] = '';
  }
  
  $data['sub_folders'] = !empty($sub_folders) ? $sub_folders : '';
  $data['tmp']['empty_cat'] = empty($empty_cat) ? '' : cs_subtemplate(__FILE__, $empty_cat, 'usersgallery', 'users_error_2');
  echo cs_subtemplate(__FILE__, $data, 'gallery', 'list_folder');
}