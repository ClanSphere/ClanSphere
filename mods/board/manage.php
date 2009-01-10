<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

$categories_id = empty($_REQUEST['where']) ? 0 : $_REQUEST['where'];
settype($categories_id,'integer');

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$where = empty($categories_id) ? 0 : "categories_id = '" . $categories_id . "'";
$cs_sort[1] = 'cat.categories_id DESC';
$cs_sort[2] = 'cat.categories_id ASC';
$cs_sort[3] = 'board_name DESC';
$cs_sort[4] = 'board_name ASC';
$sort = empty($_REQUEST['sort']) ? 3 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$board_count = cs_sql_count(__FILE__,'board');
$bdf_count = cs_sql_count(__FILE__,'boardfiles');

$data['link']['new_board'] = cs_url('board','create');
$data['link']['sort'] = cs_url('board','sort');
$data['link']['reports'] = cs_url('board','reportlist');
$data['link']['attachments'] = cs_url('board','attachments_admin');
$data['count']['attachments'] = $bdf_count;
$data['count']['all'] = $board_count;
$data['pages']['list'] = cs_pages('board','manage',$board_count,$start,$categories_id,$sort);
$data['lang']['getmsg'] = cs_getmsg();

$from = 'board brd INNER JOIN {pre}_categories cat ON brd.categories_id = cat.categories_id';
$select = 'brd.board_name AS board_name, cat.categories_name AS categories_name, brd.board_id AS board_id';
$cs_board = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);
$board_loop = count($cs_board);

$data['sort']['name'] = cs_sort('board','manage',$start,$categories_id,3,$sort);
$data['sort']['cat'] = cs_sort('board','manage',$start,$categories_id,1,$sort);

if(empty($board_loop)) {
  $data['board'] = '';
}

for($run=0; $run<$board_loop; $run++) {
  $img_edit = cs_icon('edit',16,$cs_lang['edit']);
  $img_del = cs_icon('editdelete',16,$cs_lang['remove']);
	
  $data['board'][$run]['name'] = cs_secure($cs_board[$run]['board_name']);
  $data['board'][$run]['cat'] = cs_secure($cs_board[$run]['categories_name']);
  $data['board'][$run]['edit'] = cs_url('board','edit','id=' . $cs_board[$run]['board_id']);
  $data['board'][$run]['remove'] = cs_url('board','remove','id=' . $cs_board[$run]['board_id']);
}

echo cs_subtemplate(__FILE__,$data,'board','manage');
?>