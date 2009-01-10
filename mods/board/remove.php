<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

$board_id = $_REQUEST['id'];
settype($board_id,'integer');

$board_form = 1;
$change_threads = 0;

$from = 'threads';
$select = 'threads_id';
$where = "board_id = '" . $board_id . "'";
$cs_threads = cs_sql_select(__FILE__,$from,$select,$where,'','',0);
$threads_loop = count($cs_threads);

if(isset($_POST['agree'])) {
  $cs_board['change_threads'] = isset($_POST['change_threads']) ? $_POST['change_threads'] : 0;
  $cs_board['board_id'] = isset($_POST['board_id']) ? $_POST['board_id'] : 0;

  $board_form = 0;
  cs_sql_delete(__FILE__,'board',$board_id);
  $query = "DELETE FROM {pre}_boardpws WHERE board_id = '" . $board_id . "'";
  cs_sql_query(__FILE__,$query);
  
  if(empty($cs_board['change_threads'])) {
    $query = "DELETE FROM {pre}_threads WHERE board_id = '" . $board_id . "'";
    cs_sql_query(__FILE__,$query);
    
	for($run = 0; $run < $threads_loop; $run++) {
      $thread_id = $cs_threads[$run]['threads_id'];
      $query = "DELETE FROM {pre}_comments WHERE comments_fid = '" . $thread_id . "' ";
      $query .= "AND comments_mod = 'board'";
      cs_sql_query(__FILE__,$query);  
      $query = "DELETE FROM {pre}_abonements WHERE threads_id='" . $thread_id . "'";
      cs_sql_query(__FILE__,$query);
			
			
      $files_select = 'boardfiles_id, threads_id, boardfiles_name';
      $files_where = "threads_id = '" . $thread_id . "'";
      $files_id = cs_sql_select(__FILE__,'boardfiles',$files_select,$files_where,0,0,0);
      $files_loop = count($files_id);		

      for($run2=0; $run2 < $files_loop; $run2++) {
        $file = $files_id[$run2]['boardfiles_name'];
        $extension = strlen(strrchr($file,"."));
        $name = strlen($file);
        $ext = substr($file,$name - $extension + 1,$name); 
        echo 'uploads/board/files/' . $files_id[$run2]['boardfiles_id'] . '.' . $ext . cs_html_br(1);
        cs_unlink('board', $files_id[$run2]['boardfiles_id'] . '.' . $ext, 'files');
      }
      
	  $query = "DELETE FROM {pre}_boardfiles WHERE threads_id= '" . $thread_id . "'";
      cs_sql_query(__FILE__,$query);
    }
  }
  else {
    $cs_board_id = $cs_board['board_id'];
    $query = "UPDATE {pre}_threads SET board_id='$cs_board_id' ";
    $query .= "WHERE board_id = '$board_id'";
    cs_sql_query(__FILE__,$query);
  }
  cs_redirect($cs_lang['del_true'], 'board');
}

if(isset($_POST['cancel'])) {
	$board_form = 0;
	cs_redirect($cs_lang['del_false'], 'board');
}

if(!empty($board_form)) {
  $data['action']['form'] = cs_url('board','remove');
  $data['lang']['body'] = sprintf($cs_lang['del_rly'],$board_id);
  
  if(!empty($threads_loop)) {
    $data['if']['threads_loop'] = true;
    $cs_board['change_threads'] = 0;
			
    if($cs_board['change_threads'] == 0) {
      $data['remove']['checked'] = '';
    }
    else {
      $data['remove']['checked'] = 'checked="checked"';
    }

    $cs_board['board_id'] = 0;

    $where = "board_id != '" . $board_id . "'";
    $board_data = cs_sql_select(__FILE__,'board','*',$where,'board_name',0,0);
    
	$data['remove']['dropdown'] = cs_dropdown('board_id','board_name',$board_data,$cs_board['board_id']);
  }
  else {
    $data['if']['threads_loop'] = false;
  }
  $data['remove']['id'] = $board_id;
}

echo cs_subtemplate(__FILE__,$data,'board','remove');
?>