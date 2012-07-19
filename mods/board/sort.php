<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

if (!empty($_GET['delall'])) {
  cs_sql_update(__FILE__,'board',array('board_order'),array(0),0,'board_order != 0');
  cs_sql_update(__FILE__,'categories',array('categories_order'),array(0),0,"categories_mod = 'board'");
  cs_redirect(NULL, 'board', 'sort');
}

if (!empty($_GET['board'])) {
  $board_cells = array('board_order');
  $board_save = empty($_GET['order']) ? array(0) : array(cs_sql_escape($_GET['order']));
  cs_sql_update(__FILE__,'board',$board_cells,$board_save,cs_sql_escape($_GET['board']));
  cs_redirect(NULL, 'board', 'sort');
}

if (!empty($_GET['cat'])) {
  $board_cells = array('categories_order');
  $board_save = empty($_GET['order']) ? array(0) : array(cs_sql_escape($_GET['order']));
  cs_sql_update(__FILE__,'categories',$board_cells,$board_save,cs_sql_escape($_GET['cat']));
  cs_redirect(NULL, 'board', 'sort');
}

$data['link']['back'] = cs_url('board','manage');
$data['link']['delall'] = cs_url('board','sort', 'delall=1');

$where = "categories_mod = 'board'";
$select = 'categories_name, categories_id, categories_order';
$cs_categories = cs_sql_select(__FILE__,'categories',$select,$where,'categories_order ASC, categories_name ASC',0,0);
$loop_categories = count($cs_categories);

if (!empty($cs_categories)) {
  for($run = 0; $run < $loop_categories; $run++) {
    $data['cat'][$run]['categories_name'] = cs_secure($cs_categories[$run]['categories_name']);
    $data['cat'][$run]['categories_order'] = cs_secure($cs_categories[$run]['categories_order']);

    if ($run > 0 AND ($cs_categories[$run]['categories_order'] - 1) >= $cs_categories[$run-1]['categories_order'])
      $data['cat'][$run]['categories_up'] = cs_html_img('symbols/clansphere/up_arrow_active.png') . ' ' . cs_link($cs_lang['up'],'board','sort','cat=' . $cs_categories[$run]['categories_id'] . '&order=' . $cs_categories[$run-1]['categories_order']);
    else if ($run > 0 AND $cs_categories[$run]['categories_order'] > 0) {
      $cat_new = ($cs_categories[$run-1]['categories_order'] - 1) > 0 ? ($cs_categories[$run-1]['categories_order'] - 1) : 0;
      $data['cat'][$run]['categories_up'] = cs_html_img('symbols/clansphere/up_arrow_active.png') . ' ' . cs_link($cs_lang['up'],'board','sort','cat=' . $cs_categories[$run]['categories_id'] . '&order=' . $cat_new);
    }
    else
      $data['cat'][$run]['categories_up'] = '';
    
    if ($run < ($loop_categories-1) AND ($cs_categories[$run]['categories_order'] + 1) <= $cs_categories[$run+1]['categories_order'])
      $data['cat'][$run]['categories_down'] = cs_html_img('symbols/clansphere/down_arrow_active.png') . ' ' . cs_link($cs_lang['down'],'board','sort','cat=' . $cs_categories[$run]['categories_id'] . '&order=' . $cs_categories[$run+1]['categories_order']);
    else if ($run < ($loop_categories-1) AND $cs_categories[$run]['categories_order'] < 9999) {
      $cat_new = ($cs_categories[$run+1]['categories_order'] + 1) < 9999 ? ($cs_categories[$run+1]['categories_order'] + 1) : 9999;
      $data['cat'][$run]['categories_down'] = cs_html_img('symbols/clansphere/down_arrow_active.png') . ' ' . cs_link($cs_lang['down'],'board','sort','cat=' . $cs_categories[$run]['categories_id'] . '&order=' . $cat_new);
    }
    else
      $data['cat'][$run]['categories_down'] = '';

    $loop_board = 0;
    $select = 'board_id, board_name, board_order';
    $where = 'categories_id =' .$cs_categories[$run]['categories_id'];
    $cs_board = cs_sql_select(__FILE__,'board',$select,$where,'board_order ASC, board_name ASC',0,0);
    $loop_board = count($cs_board);
    
    if (!empty($cs_board)) {
      for($board_run = 0; $board_run < $loop_board; $board_run++) {
        $data['cat'][$run]['board'][$board_run]['board_name'] = cs_secure($cs_board[$board_run]['board_name']);
        $data['cat'][$run]['board'][$board_run]['board_order'] = cs_secure($cs_board[$board_run]['board_order']);

        if ($board_run > 0 AND ($cs_board[$board_run]['board_order'] - 1) >= $cs_board[$board_run-1]['board_order'])
          $data['cat'][$run]['board'][$board_run]['board_up'] = cs_html_img('symbols/clansphere/up_arrow.png') . ' ' . cs_link($cs_lang['up'],'board','sort','board=' . $cs_board[$board_run]['board_id'] . '&order=' . $cs_board[$board_run-1]['board_order']);
        else if ($board_run > 0 AND $cs_board[$board_run]['board_order'] > 0) {
          $board_new = ($cs_board[$board_run-1]['board_order'] - 1) > 0 ? ($cs_board[$board_run-1]['board_order'] - 1) : 0;
          $data['cat'][$run]['board'][$board_run]['board_up'] = cs_html_img('symbols/clansphere/up_arrow.png') . ' ' . cs_link($cs_lang['up'],'board','sort','board='.$cs_board[$board_run]['board_id'] . '&order=' . $board_new); 
        }
        else
          $data['cat'][$run]['board'][$board_run]['board_up'] = '';

        if ($board_run < ($loop_board-1) AND ($cs_board[$board_run]['board_order'] + 1) <= $cs_board[$board_run+1]['board_order'])
          $data['cat'][$run]['board'][$board_run]['board_down'] = cs_html_img('symbols/clansphere/down_arrow.png') . ' ' . cs_link($cs_lang['down'],'board','sort','board=' . $cs_board[$board_run]['board_id'] . '&order=' . $cs_board[$board_run+1]['board_order']);
        else if ($board_run < ($loop_board-1) AND $cs_board[$board_run]['board_order'] < 9999) {
          $board_new = ($cs_board[$board_run+1]['board_order'] + 1) < 9999 ? ($cs_board[$board_run+1]['board_order'] + 1) : 9999;
          $data['cat'][$run]['board'][$board_run]['board_down'] = cs_html_img('symbols/clansphere/down_arrow.png') . ' ' . cs_link($cs_lang['down'],'board','sort','board=' . $cs_board[$board_run]['board_id'] . '&order=' . $board_new);
        }
        else
          $data['cat'][$run]['board'][$board_run]['board_down'] = '';
      }  
    }
    else {
      $data['cat'][$run]['board'] = array();
    }
  }
}
else {
  $data['cat'] = '';
}

echo cs_subtemplate(__FILE__,$data,'board','sort');