<?PHP
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery', 1);
$data = array();

require_once 'mods/gallery/functions.php';

function cs_find_move ($folders_id, $usersgallery_id) {
  $sql_tmp = cs_sql_select(__FILE__,'usersgallery','usersgallery_id','folders_id = '. $folders_id,'usersgallery_id DESC',0,0);
  $tmp = 0;
  foreach ($sql_tmp as $search_tmp) {
    if(in_array($usersgallery_id, $search_tmp)) {
      return $tmp;
    }
    $tmp++;
  }
  return FALSE;
}

$options = cs_sql_option(__FILE__,'gallery');
$rows = $options['rows'];
$data['lang']['top_list'] = $cs_lang['top_list'].$rows;
$access_id = $account['access_usersgallery'];
$cs_lap = cs_html_img('symbols/gallery/nowatermark.gif','100','100');

$select = 'usersgallery_count, usersgallery_id, folders_id, usersgallery_time, users_id';
$where = 'usersgallery_status = 1 AND usersgallery_access <= ' . $access_id;
$cs_gallery = cs_sql_select(__FILE__,'usersgallery',$select,$where,'usersgallery_count DESC',0,$rows);
if(!empty($cs_gallery) AND $options['top_5_views'] == '1') {
  $run_to = count($cs_gallery);
  if($run_to == 1)
    $data['lang']['top'] = $cs_lang['top1'];
  else
    $data['lang']['top'] = sprintf($cs_lang['top'], $run_to);
  for($run=0; $run < $run_to; $run++) {
    $top_views[$run]['img'] = $cs_gallery[$run]['usersgallery_id'];
    $move = cs_find_move ($cs_gallery[$run]['folders_id'], $cs_gallery[$run]['usersgallery_id']);
    $more = 'id=' . $cs_gallery[$run]['users_id'] . '&amp;cat_id=' . $cs_gallery[$run]['folders_id'];
    if (!empty($move)) $more .= '&amp;move=' . $move;
    $top_views[$run]['link'] = cs_link($cs_lap,'usersgallery','com_view',$more);
  }
  $data['top_views'] = $top_views;
}
$top_views_1['0']['top_views_1'] = empty($data['top_views']) ? '' : '1';
$data['top_views_1'] = !empty($top_views_1['0']['top_views_1']) ? $top_views_1 : '';

$cs_top = cs_sql_select(__FILE__,'usersgallery',$select,$where,'usersgallery_time DESC',0,$rows);
if(!empty($cs_top) AND $options['newest_5'] == '1') {
  $run_to = count($cs_top);
  if($run_to == 1)
    $data['lang']['last_update'] = $cs_lang['newest1'];
  else
    $data['lang']['last_update'] = sprintf($cs_lang['newest'], $run_to);
  for($run=0; $run < $run_to; $run++) {
    $last_update[$run]['img'] = $cs_top[$run]['usersgallery_id'];
    $move = cs_find_move ($cs_top[$run]['folders_id'], $cs_top[$run]['usersgallery_id']);
    $more = 'id=' . $cs_top[$run]['users_id'] . '&amp;cat_id=' . $cs_top[$run]['folders_id'];
    if (!empty($move)) $more .= '&amp;move=' . $move;
    $last_update[$run]['link'] = cs_link($cs_lap,'usersgallery','com_view',$more);
  }
  $data['last_update'] = $last_update;
}
$last_update_1['0']['last_update'] = empty($data['last_update']) ? '' : '1';
$data['last_update_1'] = !empty($last_update_1['0']['last_update']) ? $last_update_1 : '';

if($options['top_5_votes'] == '1') {
  $from = 'voted vod INNER JOIN {pre}_usersgallery gal ON vod.voted_fid = gal.usersgallery_id';
  $select = 'gal.usersgallery_id AS usersgallery_id, AVG(vod.voted_answer) AS voted_answer, ';
  $select .= 'gal.folders_id AS folders_id, gal.users_id AS users_id';
  $where = 'gal.usersgallery_status = 1 AND gal.usersgallery_access <= ' . $access_id;
  $where .= " AND vod.voted_mod = 'usersgallery' GROUP BY gal.usersgallery_id, gal.folders_id, gal.users_id";
  $order = 'voted_answer DESC';
  $cs_voted = cs_sql_select(__FILE__,$from,$select,$where,$order,0,$rows);
  if(!empty($cs_voted)) {
    if(count($cs_voted) == 1)
      $data['lang']['vote'] = $cs_lang['vote1'];
    else
      $data['lang']['vote'] = sprintf($cs_lang['vote'], count($cs_voted));
    $run=0;
    foreach($cs_voted as $voted_run) {
      $vote[$run]['img'] = $voted_run['usersgallery_id'];
    $move = cs_find_move ($cs_voted[$run]['folders_id'], $cs_voted[$run]['usersgallery_id']);
      $more = 'id=' . $voted_run['users_id'] . '&amp;cat_id=' . $voted_run['folders_id'];
    if (!empty($move)) $more .= '&amp;move=' . $move;
      $vote[$run]['link'] = cs_link($cs_lap,'usersgallery','com_view',$more);
      $run++;
    }
  }
  $data['vote'] = !empty($vote) ? $vote : '';
}
$vote_1['0']['vote'] = empty($data['vote']) ? '' : '1';
$data['vote_1'] = !empty($vote_1['0']['vote']) ? $vote_1 : '';

$from = 'comments com INNER JOIN {pre}_usersgallery gal ON com.comments_fid = gal.usersgallery_id';
$select = 'gal.usersgallery_id AS usersgallery_id, COUNT(com.comments_id) AS comments, ';
$select .= 'gal.folders_id AS folders_id, gal.users_id AS users_id';
$where = 'gal.usersgallery_status = 1 AND gal.usersgallery_access <= ' . $access_id;
$where .= " AND com.comments_mod = 'usersgallery' GROUP BY gal.usersgallery_id, gal.folders_id, gal.users_id";
$order = 'comments DESC';
$cs_com = cs_sql_select(__FILE__,$from,$select,$where,$order,0,$rows);
if(!empty($cs_com)) {
  if(count($cs_com) == 1)
    $data['lang']['com'] = $cs_lang['com1'];
  else
    $data['lang']['com'] = sprintf($cs_lang['com'], count($cs_com));
  $run=0;
  foreach($cs_com as $com_run) {
    $com[$run]['img'] = $com_run['usersgallery_id'];
    $move = cs_find_move ($cs_com[$run]['folders_id'], $cs_com[$run]['usersgallery_id']);
    $more = 'id=' . $com_run['users_id'] . '&amp;cat_id=' . $com_run['folders_id'];
    if (!empty($move)) $more .= '&amp;move=' . $move;
    $com[$run]['link'] = cs_link($cs_lap,'usersgallery','com_view',$more);
    $run++;
  }
}

$data['if']['com_1'] = empty($com) ? FALSE : TRUE;

if(!empty($data['if']['com_1']))
  $data['com'] = empty($com) ? array() : $com;

echo cs_subtemplate(__FILE__,$data,'usersgallery','top');