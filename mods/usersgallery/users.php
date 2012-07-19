<?PHP
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery', 1);
$cs_post = cs_post('id,cat_id,start');
$cs_get = cs_get('id_cat_id,start');
$data = array();

$id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $id = $cs_post['id'];
$cat_id = empty($cs_get['cat_id']) ? 0 : $cs_get['cat_id'];
if (!empty($cs_post['cat_id']))  $cat_id = $cs_post['cat_id'];
$start = empty($cs_get['start']) ? 0 : $cs_get['start'];
if (!empty($cs_post['start']))  $start = $cs_post['start'];

require_once 'mods/gallery/functions.php';
$options = cs_sql_option(__FILE__,'gallery');
$cols = $options['cols'];
$rows = $options['rows'];
$cols_rows = $account['users_limit'];

$access_id = $account['access_usersgallery'];

$data['lang']['getmsg'] = cs_getmsg();

$data['data']['addons'] = cs_addons('users','view',$id,'usersgallery');

if(!empty($id)) {
  if(empty($cat_id)) {
    $from = 'usersgallery';
    $select = 'usersgallery_time, usersgallery_name, usersgallery_titel, usersgallery_download, ';
    $select .= 'usersgallery_description, usersgallery_id, usersgallery_vote, usersgallery_count, folders_id';
    $where = "usersgallery_status = '1' AND usersgallery_access <= '" . $access_id . "' AND users_id = '" . $id . "'";
    $order = 'usersgallery_id DESC';
    $cs_gallery = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,0);
    $gallery_loop = count($cs_gallery);

    $from = 'folders';
    $select = 'folders_id, sub_id, folders_name, folders_picture, folders_text';
    $where = "folders_mod='usersgallery' AND users_id='" . $id . "' AND folders_access <= '" . $access_id . "'";
    $order = 'folders_name ASC';
    $folders = cs_sql_select(__FILE__,$from,$select,$where,$order,'',0);
    $folders_loop = count($folders);

    if(empty($folders_loop)) {
      $no_cat['lang']['no_cat'] = $cs_lang['list_no_cat'];
    }
    $data['tmp']['no_cat'] = empty($no_cat) ? '' : cs_subtemplate(__FILE__,$no_cat,'usersgallery','users_error_1');
    if(!empty($folders_loop)) {
      $run = 0;
      foreach($folders as $a) {
        if($a['sub_id'] == '0') {
          if(empty($a['folders_picture'])) {
            $cs_lap = cs_html_img('symbols/gallery/image.gif');
          } else {
            $cs_lap = cs_html_img("uploads/folders/" . $a['folders_picture']);
          }
          $cat[$run]['img'] = cs_link($cs_lap,'usersgallery','users','id='. $id .'&amp;cat_id=' . $a['folders_id']);
          $more = 'id='. $id .'&amp;cat_id=' . $a['folders_id'];
          $cat[$run]['folders_name'] = cs_link(cs_secure($a['folders_name']),'usersgallery','users',$more);
          $cat[$run]['folders_text'] = !empty($a['folders_text']) ? cs_secure($a['folders_text'],1,1) : cs_html_br(1);

          $cat_id_a = $a['folders_id'];
          $pic_loop = '0';
          $last_update = '0';
          for ($run_2 = 0; $run_2 < $gallery_loop; $run_2++) {
            $gal_cat_id = $cs_gallery[$run_2]['folders_id'];
            if($cat_id_a == $gal_cat_id) {
              $pic_loop++;
              if($last_update <= $cs_gallery[$run_2]['usersgallery_time']) {
                $last_update = $cs_gallery[$run_2]['usersgallery_time'];
              }
            }
          }
          if($pic_loop == 1) {
            $cat[$run]['pic_count'] = sprintf($cs_lang['pic_1'], $pic_loop);
            if(!empty($last_update)) {
              $cat[$run]['last_update'] = $cs_lang['pic_akt'] . cs_date('unix',$last_update,1);
            }
          } else {
            $cat[$run]['pic_count'] = sprintf($cs_lang['pic_2'], $pic_loop);
            if(!empty($last_update)) {
              $cat[$run]['last_update'] = $cs_lang['pic_akt'] . cs_date('unix',$last_update,1);
            } else {
              $cat[$run]['last_update'] = '';
            }
          }
          $run++;
        }
      }
    }
    $cs_gallery_move = cs_gallery_move($cs_gallery,$options['list_sort']);
    if(!empty($cs_gallery) AND $options['top_5_views'] == '1') {
      $cs_gallery = cs_array_sort($cs_gallery_move,SORT_DESC,'usersgallery_count');
      if($gallery_loop > $rows) {
        $run_to = $rows;
      } else {
        $run_to = $gallery_loop;
      }
      if($run_to == 1) {
        $data['lang']['top'] = $cs_lang['top1'];
      } else {
        $data['lang']['top'] = sprintf($cs_lang['top'], $run_to);
      }
      for($run=0; $run < $run_to; $run++) {
        $top_views[$run]['img'] = $cs_gallery[$run]['usersgallery_id'];
        $cs_lap = cs_html_img('symbols/gallery/nowatermark.gif','100','100');
        $more = 'id=' . $id . '&amp;cat_id=' . $cs_gallery[$run]['folders_id'];
        $more .= '&amp;move=' . $cs_gallery[$run]['move'];
        $top_views[$run]['link'] = cs_link($cs_lap,'usersgallery','com_view',$more);
      }
      $data['top_views'] = !empty($top_views) ? $top_views : '';
    }
    $top_views_1['0']['top_views_1'] = empty($data['top_views']) ? '' : '1';
    $data['top_views_1'] = !empty($top_views_1['0']['top_views_1']) ? $top_views_1 : '';
    if(!empty($cs_gallery) AND $options['newest_5'] == '1') {
      $cs_gallery = cs_array_sort($cs_gallery_move,SORT_DESC,'usersgallery_time');
      if($gallery_loop > $rows) {
        $run_to = $rows;
      } else {
        $run_to = $gallery_loop;
      }
      if($run_to == 1) {
        $data['lang']['last_update'] = $cs_lang['newest1'];
      } else {
        $data['lang']['last_update'] = sprintf($cs_lang['newest'], $run_to);
      }
      $last_update = '';
      for($run=0; $run < $run_to; $run++) {
        $last_update[$run]['img'] = $cs_gallery[$run]['usersgallery_id'];
        $cs_lap = cs_html_img('symbols/gallery/nowatermark.gif','100','100');
        $more = 'id=' . $id . '&amp;cat_id=' . $cs_gallery[$run]['folders_id'];
        $more .= '&amp;move=' . $cs_gallery[$run]['move'];
        $last_update[$run]['link'] = cs_link($cs_lap,'usersgallery','com_view',$more);
      }
      $data['last_update'] = !empty($last_update) ? $last_update : '';
    }
    $last_update_1['0']['last_update'] = empty($data['last_update']) ? '' : '1';
    $data['last_update_1'] = !empty($last_update_1['0']['last_update']) ? $last_update_1 : '';
    if($options['top_5_votes'] == '1') {
      $from = 'voted vod INNER JOIN {pre}_usersgallery gal ON vod.voted_fid = gal.usersgallery_id';
      $select = 'gal.usersgallery_id AS usersgallery_id, vod.voted_answer AS voted_answer, ';
      $select .= 'gal.folders_id AS folders_id';
      $where = "gal.users_id = '". $id ."' AND gal.usersgallery_status = '1' AND vod.voted_mod = 'usersgallery'  AND gal.usersgallery_access <= '" . $access_id . "'";
      $order = 'gal.usersgallery_id ASC';
      $cs_voted = cs_sql_select(__FILE__,$from,$select,$where,$order,0,0);
      $voted_loop = count($cs_voted);
      for($run=0; $run < $voted_loop; $run++) {
          if($run !== 0) {
          $run2 = $run - 1;
          if($cs_voted[$run]['usersgallery_id'] == $cs_voted[$run2]['usersgallery_id']) {
            $x[$cs_voted[$run]['usersgallery_id']] += $cs_voted[$run]['voted_answer'];
            $y[$cs_voted[$run]['usersgallery_id']] += 1;
          }
          if($cs_voted[$run]['usersgallery_id'] !== $cs_voted[$run2]['usersgallery_id']) {
            $x[$cs_voted[$run]['usersgallery_id']] = $cs_voted[$run]['voted_answer'];
            $y[$cs_voted[$run]['usersgallery_id']] = 1;
          }
        } else {
            $x[$cs_voted[$run]['usersgallery_id']] = $cs_voted[$run]['voted_answer'];
            $y[$cs_voted[$run]['usersgallery_id']] = 1;
        }
      }
      $x_loop = empty($x) ? 0 : count($x);
      if(!empty($x_loop)) {
        if($voted_loop == 1) {
          $data['lang']['vote'] = $cs_lang['vote1'];
        } else {
          $data['lang']['vote'] = sprintf($cs_lang['vote'], $voted_loop);
        }
        for($run=0; $run < $voted_loop; $run++) {
            if($run !== 0) {
            $run3 = $run - 1;
            if($cs_voted[$run]['usersgallery_id'] !== $cs_voted[$run3]['usersgallery_id']) {
                $w = $x[$cs_voted[$run]['usersgallery_id']] / $y[$cs_voted[$run]['usersgallery_id']];
              $z[$run4] = array("usersgallery_id" => $cs_voted[$run]['usersgallery_id'], "folders_id" => $cs_voted[$run]['folders_id'], "voted_answer" => $w);
              $run4++;
            }
          } else {
            $run4 = 0;
            $w = $x[$cs_voted[$run]['usersgallery_id']] / $y[$cs_voted[$run]['usersgallery_id']];
            $z[$run4] = array("usersgallery_id" => $cs_voted[$run]['usersgallery_id'], "folders_id" => $cs_voted[$run]['folders_id'], "voted_answer" => $w);
            $run4++;
          }
        }
        $z_loop = empty($z) ? 0 : count($z);
        if($z_loop > $rows) {
          $run_to = $rows;
        } else {
          $run_to = $z_loop;
        }
        $cs_gallery_move = cs_gallery_move($z,$options['list_sort']);
        if(!empty($z)) {
            $z = cs_array_sort($cs_gallery_move,SORT_ASC,'voted_answer');
        }
        for($run=0; $run < $run_to; $run++) {
          $vote[$run]['img'] = $z[$run]['usersgallery_id'];
          $cs_lap = cs_html_img('symbols/gallery/nowatermark.gif','100','100');
          $more = 'id=' . $id . '&amp;cat_id=' . $z[$run]['folders_id'];
          $more .= '&amp;move=' . $z[$run]['move'];
          $vote[$run]['link'] = cs_link($cs_lap,'usersgallery','com_view',$more);
        }
        $data['vote'] = !empty($vote) ? $vote : '';
      }
    }
    $vote_1['0']['vote'] = empty($data['vote']) ? '' : '1';
    $data['vote_1'] = !empty($vote_1['0']['vote']) ? $vote_1 : '';
    
  } else {
  
    $from = 'usersgallery';
    $select = 'usersgallery_time, usersgallery_name, usersgallery_titel, usersgallery_download, ';
    $select .= 'usersgallery_description, usersgallery_id, usersgallery_vote, usersgallery_count, folders_id';
    $where = "usersgallery_status = 1 AND usersgallery_access <= '" . $access_id . "'";
    $where .= " AND folders_id = '" . cs_sql_escape($cat_id) . "'";
    
    switch($options['list_sort']) {
      case 0:
        $order = 'usersgallery_id DESC';
        break;
      case 1:
        $order = 'usersgallery_id ASC';
        break;
    }
    $cs_gallery = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);
    $gallery_loop = count($cs_gallery);
    $gallery_count = cs_sql_count(__FILE__,'usersgallery',$where);

    $from = 'folders';
    $select = 'folders_id, sub_id, folders_name, folders_picture, folders_text';
    $where = "folders_mod = 'usersgallery' AND folders_id = '" . $cat_id . "'";
    $folders_current = cs_sql_select(__FILE__,$from,$select,$where);

    $where = "folders_mod = 'usersgallery' AND users_id='" . $id . "' AND sub_id = '".$folders_current['folders_id']."'";
    $folders = cs_sql_select(__FILE__,$from,$select,$where,0,0,0);
    $folders_loop = count($folders);
    $data['link']['gallery'] = cs_link($cs_lang['mod_name'],'usersgallery','users','id='. $id);
    $data['link']['subfolders'] = make_folders_head($folders,$folders_current['sub_id'],$id);
    $data['data']['folders_name'] = $folders_current['folders_name'];
    if(!empty($folders_loop)) {
      for($run=0; $run < $folders_loop; $run++) {
        if(empty($folders[$run]['folders_picture'])) {
          $cs_lap = cs_html_img('symbols/gallery/image.gif');
        } else {
          $cs_lap = cs_html_img("uploads/folders/" . $folders[$run]['folders_picture']);
        }
        $more = 'id='. $id .'&amp;cat_id='. $folders[$run]['folders_id'];
        $cat_1[$run]['folders_img'] = cs_link($cs_lap,'usersgallery','users',$more);
        $cat_1[$run]['folders_name'] = $folders[$run]['folders_name'];
      }
    }
    $data['cat_1'] = !empty($cat_1) ? $cat_1 : array();
    if(!empty($gallery_loop)) {
      for($run=0; $run < $gallery_loop; $run++) {
        $img[$run]['img'] = $cs_gallery[$run]['usersgallery_id'];
        $cs_lap = cs_html_img('symbols/gallery/nowatermark.gif','100','100');
        $num = $start + $run;
        $img[$run]['link'] = cs_link($cs_lap,'usersgallery','com_view','id='. $id .'&amp;cat_id='. $cat_id .'&amp;move='. $num);
      }
    }
    $data['img'] = !empty($img) ? $img : array();
    if(!empty($data['cat_1']) OR !empty($gallery_loop)) {
      $data['data']['pages'] = cs_pages('usersgallery','users',$gallery_count,$start,0,0,$cols_rows,0,'cat_id=' . $cat_id . '&amp;id=' . $id);
    } else {
      $empty_cat['lang']['empty_cat'] = $cs_lang['empty_cat'];
    }
  }
  if(empty($empty_cat['lang']['empty_cat']) AND !empty($cat_id)) {
    $cat_list_1['0']['cat_list_1'] = '1';
  } else {
    $cat_list_1['0']['cat_list_1'] = '';
  }
} else {
  $empty_cat['lang']['empty_cat'] = $cs_lang['no_cat'];
}
$data['cat'] = !empty($cat) ? $cat : '';
$cat_list['0']['cat_list'] = empty($cat_id) ? '1' : '';
$data['cat_list'] = !empty($cat_list['0']['cat_list']) ? $cat_list : '';
$data['tmp']['empty_cat'] = empty($empty_cat) ? '' : cs_subtemplate(__FILE__,$empty_cat,'usersgallery','users_error_2');
$data['cat_list_1'] = !empty($cat_list_1['0']['cat_list_1']) ? $cat_list_1 : '';

echo cs_subtemplate(__FILE__,$data,'usersgallery','users');