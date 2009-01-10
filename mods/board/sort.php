<?php
$cs_lang = cs_translate('board');

if(!empty($_GET['board'])) {
  $board_cells = array('board_order');
  $board_save = array(cs_sql_escape($_GET['order']));
  cs_sql_update(__FILE__,'board',$board_cells,$board_save,cs_sql_escape($_GET['board']));
  header('location:' . $_SERVER['PHP_SELF'] . '?mod=board&action=sort');
}
 
if(!empty($_GET['cat'])) {
  $board_cells = array('categories_order');
  $board_save = array(cs_sql_escape($_GET['order']));
  cs_sql_update(__FILE__,'categories',$board_cells,$board_save,cs_sql_escape($_GET['cat']));
  header('location:' . $_SERVER['PHP_SELF'] . '?mod=board&action=sort');
}

$data['link']['back'] = cs_url('board','manage');
 

$where = "categories_mod = 'board'";
$select = 'categories_name, categories_id, categories_order';
$cs_categories = cs_sql_select(__FILE__,'categories',$select,$where,'categories_order ASC, categories_name ASC',0,0);
$loop_categories = count($cs_categories);

if(!empty($cs_categories)) {
  for($run = 0; $run < $loop_categories; $run++) {      
    $data['cat'][$run]['categories_name'] = cs_secure($cs_categories[$run]['categories_name']);
	$data['cat'][$run]['categories_order'] = cs_secure($cs_categories[$run]['categories_order']);

	if($cs_categories[$run]['categories_order'] != 0) {
      $data['cat'][$run]['categories_up'] = cs_html_img('symbols/clansphere/down_arrow_active.png') . ' ' . cs_link($cs_lang['up'],'board','sort','cat=' . $cs_categories[$run]['categories_id'] . '&order=' . ($cs_categories[$run]['categories_order']-1));
	}
	else {
	  $data['cat'][$run]['categories_up'] = '';
	}
	   
	if($cs_categories[$run]['categories_order'] <= 9999) {
      $data['cat'][$run]['categories_down'] = cs_html_img('symbols/clansphere/up_arrow_active.png') . ' ' . cs_link($cs_lang['down'],'board','sort','cat=' . $cs_categories[$run]['categories_id'] . '&order=' . ($cs_categories[$run]['categories_order']+1));
	}
	else {
	  $data['cat'][$run]['categories_down'] = '';
	}

	$select = 'board_id, board_name, board_order';
	$where = 'categories_id =' .$cs_categories[$run]['categories_id'];
	$cs_board = cs_sql_select(__FILE__,'board',$select,$where,'board_order ASC, board_name ASC',0,0);
	$loop_board = count($cs_board);
	
	if(!empty($cs_board)) {
	
	  for($board_run = 0; $board_run < $loop_board; $board_run++) {     
		$data['cat'][$run]['board'][$board_run]['board_name'] = cs_secure($cs_board[$board_run]['board_name']);
        $data['cat'][$run]['board'][$board_run]['board_order'] = cs_secure($cs_board[$board_run]['board_order']);

		if($cs_board[$board_run]['board_order'] != 0) {
			$data['cat'][$run]['board'][$board_run]['board_up'] = cs_html_img('symbols/clansphere/up_arrow.png') . ' ' . cs_link($cs_lang['up'],'board','sort','board='.$cs_board[$board_run]['board_id'] . '&order=' . ($cs_board[$board_run]['board_order']-1)); 
		}
		else {
		  $data['cat'][$run]['board'][$board_run]['board_up'] = '';
		}

		if($cs_board[$board_run]['board_order'] <= 9999) {
			$data['cat'][$run]['board'][$board_run]['board_down'] = cs_html_img('symbols/clansphere/down_arrow.png') . ' ' . cs_link($cs_lang['down'],'board','sort','board=' . $cs_board[$board_run]['board_id'] . '&order=' . ($cs_board[$board_run]['board_order']+1));
		}
		else {
		  $data['cat'][$run]['board'][$board_run]['board_down'] = '';
		}		
	  }	 	
	}
	else {
	  $data['board'] = '';
	}
  }
}
else {
	   $data['cat'] = '';
	}

echo cs_subtemplate(__FILE__,$data,'board','sort');
?>