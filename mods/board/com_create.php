<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

include('mods/board/functions.php');
$cs_lang = cs_translate('board');

$fid = $_REQUEST['id'];
settype($fid,'integer');

$data = array();

$check_sq = 0;
$quote = '';
$options = cs_sql_option(__FILE__,'board');
$max_text = $options['max_text'];
$filetypes = explode(',',$options['file_types']);
$message = '';
$error = 0;
$errormsg = '';
$text = '';

$from = 'threads thr INNER JOIN {pre}_board frm ON thr.board_id = frm.board_id INNER JOIN {pre}_categories cat ON frm.categories_id = cat.categories_id';
$select = 'thr.threads_headline AS threads_headline, frm.board_name AS board_name, frm.board_read AS board_read, cat.categories_name AS categories_name, thr.threads_id AS threads_id, frm.board_id AS board_id, cat.categories_id AS categories_id, frm.board_access AS board_access, frm.squads_id AS squads_id';
$where = "thr.threads_id = '" . $fid . "'";
$data['thread'] = cs_sql_select(__FILE__,$from,$select,$where);

$cond = 'comments_mod = \'board\' AND comments_fid = \''.$fid.'\'';
$data['last_comment'] = cs_sql_select(__FILE__,'comments','users_id, comments_time',$cond,'comments_id DESC');

if(!empty($data['thread']['squads_id']) AND $account['access_board'] < $data['thread']['board_access']) {
  $sq_where = "users_id = '" . $account['users_id'] . "' AND squads_id = '" . $data['thread']['squads_id'] . "'";
  $check_sq = cs_sql_count(__FILE__,'members',$sq_where);
}

if(empty($fid) || (count($data['thread']) == 0)) {
  return errorPage('com_create');
}

if($account['access_board'] < $data['thread']['board_access'] AND empty($check_sq)) {
  return errorPage('com_create');
}

if($account['users_id'] == $data['last_comment']['users_id'] && ( $options['doubleposts'] == -1 || $data['last_comment']['comments_time'] + $options['doubleposts'] > cs_time() )) {
  return errorPage('com_create');
}

$head  = cs_link($cs_lang['board'],'board','list','normalb') .' -> ';
$head .= cs_link($data['thread']['categories_name'],'board','list','where=' .$data['thread']['categories_id'],'normalb') .' -> ';
$head .= cs_link($data['thread']['board_name'],'board','listcat','where=' .$data['thread']['board_id'],'normalb') .' -> ';
$head .= cs_link($data['thread']['threads_headline'],'board','thread','where=' .$data['thread']['threads_id'],'normalb');
$data['thread']['head_link'] = $head;
$files = isset($_POST['files']) ? $_POST['files'] : 0;

if(isset($_POST['new_file'])) {
  $files = '1';
}

$run_loop_files = isset($_POST['run_loop_files']) ? $_POST['run_loop_files'] : 0;

if(!empty($files)) {
  $text = $_POST['comments_text'];
}
  $ori_text = $text;

$a = '0';
$b = '1';

for($run=0; $run < $run_loop_files; $run++) {
  $num = $run+1;
  
  if(!empty($_FILES["file_$num"]['name'])) {
    $board_files_name = $cs_files[$run]['boardfiles_name'] = $_FILES["file_$num"]['name'];

    $ext = substr($board_files_name,strlen($board_files_name)+1-strlen(strrchr($board_files_name,'.')));
    
	if($_FILES["file_$num"]['size'] > $options['file_size']) {
      $message .= $cs_lang['error_filesize'] . cs_html_br(1);
      $error++;
      $file_error[$num] = '1';
    }
    
	$check_type = '';
    $count_filetypes = count($filetypes);
	
	for($run_a=0; $run_a < $count_filetypes; $run_a++) {
	  if('0' == strcasecmp($filetypes[$run_a], $ext)) {
	    $check_type = 1;
	  }
	}
	
	if($check_type != 1) {
	  $message .= $cs_lang['error_filetype'] . cs_html_br(1);
	  $thread_error++;
	  $file_error[$num] = '1';
	}
	
	if(!empty($file_error[$num])) {
	  $data['thread']['errormsg'] = $message;
	}
  }
  
  if(!empty($_FILES["file_$num"]['name']) AND empty($file_error[$num])) {
    $file_name[$num] = $_FILES["file_$num"]['name'];

    $hash = '';
    $pattern = "abcdefghijklmnopqrstuvwxyz";
    
	for($i=0;$i<8;$i++) {
      $hash .= $pattern{rand(0,25)};
    }
    
	$file_upload_name[$num] = $hash . '.' . $ext;
    
	if(cs_upload('board/files', $file_upload_name[$num], $_FILES["file_$num"]['tmp_name'])) {
      $a++;
    }
	else {
      $message .= $cs_lang['error_fileupload'] . cs_html_br(1);
      $thread_error++;
    }
  }
  
  if(!empty($_POST["file_name_$num"]) AND empty($file_error[$num])) {
    $file_name[$num] = $_POST["file_name_$num"];
    $file_upload_name[$num] = $_POST["file_upload_name_$num"];
    
	if(isset($_POST["remove_file_$num"])) {
      cs_unlink('board', $file_upload_name[$num], 'files');
      $file_name[$num] = '';
    }
	else {
      $file_name[$b] = $file_name[$num];
      $a++;
      $b++;
    }
  }
}

$run_loop_files = $a;

if(isset($_POST['files+'])) {
  $run_loop_files++;
}

if(isset($_POST['submit']) OR isset($_POST['preview']) OR isset($_POST['advanced'])) {
  $text = $_POST['comments_text'];
  $text_count = strlen($text);
  
  if($text_count >= $max_text) {
    $error++;
    $count = $text_count - $max_text;
    $errormsg .= $cs_lang['text_to_long'] . $text_count . $cs_lang['text_to_long_2'] . $count . $cs_lang['text_to_long_3'] . cs_html_br(1);
  }

  if(empty($text)) {
    if ( !isset($_POST['advanced'])) {
	$error++;
	$errormsg .= $cs_lang['no_text'] . cs_html_br(1);
	}
  }

  $find = "comments_mod = 'board' AND comments_fid = '" . $fid . "'";
  $last_from = cs_sql_select(__FILE__,'comments','users_id, comments_time',$find,'comments_id DESC');
  $time = cs_time();

  if($account['users_id'] == $last_from['users_id'] && $last_from['comments_time'] + $options['doubleposts'] > $time) {
    $error++;
    $errormsg .= $cs_lang['last_own'];

    if($options['doubleposts'] != -1) {
	  $wait_days = round(($last_from['comments_time'] + $options['doubleposts'] - $time) / 86400, 1);
	  $errormsg .=  ' ' . sprintf($cs_lang['wait_after_comment'],$wait_days);
    }
    $errormsg .= cs_html_br(1);
  }

  $where = "users_id = '" . $account['users_id'] . "' AND comments_mod = 'board'";
  $flood = cs_sql_select(__FILE__,'comments','comments_time',$where,'comments_time DESC');
  $maxtime = $flood['comments_time'] + $cs_main['def_flood'];
  
  if($maxtime > cs_time()) {
    $error++;
    $diff = $maxtime - cs_time();
    $errormsg .= sprintf($cs_lang['flood_on'], $diff);
  }

  $board = cs_sql_select(__FILE__,'threads','threads_close',"threads_id = '" . $fid . "'");
  
  if(!empty($board['threads_close'])) {
    $error++;
    $errormsg .= $cs_lang['not_able'] . cs_html_br(1);
  }

  $text = preg_replace_callback("=\[img\](.*?)\[/img\]=si","cs_abcode_resize",$text);
  $text = preg_replace_callback("=\[img width\=(.*?) height\=(.*?)\](.*?)\[/img\]=si","cs_abcode_resize",$text);
}
$data['if']['error'] = empty($errormsg) ? false : true;
$data['thread']['errormsg'] = $errormsg;

if(!empty($_REQUEST['quote'])) {
  $def = explode('-', $_REQUEST['quote']);
  
  if($def[0]=='c') {
    $quote = cs_sql_select($file,'comments','users_id,comments_text,comments_time',"comments_id = '" . cs_sql_escape($def[1]) . "'");
    $cs_users = cs_sql_select(__FILE__,'users','users_id, users_nick',"users_id = '" . $quote['users_id'] . "'");
    $text = '[quote]' .$quote['comments_text']. '[/quote]';
    $url = $_SERVER['PHP_SELF'] . '?mod=users&action=view&id=' . $cs_users['users_id'];
    $text = cs_date('unix',$quote['comments_time'],1) . ' - [url=' . $url . ']';
    $text .= $cs_users['users_nick'] . "[/url]:\n[quote]" . $quote['comments_text'] . '[/quote]';
  }
  else if($def[0]=='t') {
    $select = "threads thr INNER JOIN {pre}_board brd ON thr.board_id = brd.board_id";
	$cells = "thr.users_id AS users_id, thr.threads_text AS threads_text, thr.threads_time AS threads_time, brd.board_access AS board_access";
	$where = "thr.threads_id = '" . cs_sql_escape($def[1]) . "' AND brd.board_access <= '" . $account['access_board'] . "'";
	$quote = cs_sql_select($file,$select,$cells,$where);
	$cs_users = cs_sql_select(__FILE__,'users','users_id, users_nick',"users_id = '" . $quote['users_id'] . "'");
	$url = $_SERVER['PHP_SELF'] . '?mod=users&action=view&id=' . $cs_users['users_id'];
	$text = cs_date('unix',$quote['threads_time'],1) . ' - [url=' . $url . ']';
	$text .= $cs_users['users_nick'] . "[/url]:\n[quote]" . $quote['threads_text'] . '[/quote]';
  }
}


$data['if']['preview'] = false;
$data['if']['addfile'] = false;
$data['if']['addfile2'] = false;
$data['if']['no_file'] = false;
$data['if']['file'] = false;

if(isset($_POST['preview']) AND empty($error)) {
  $data['if']['preview'] = true;
  $data['thread']['preview_text'] = cs_secure($text,1,1);
}

if(!empty($error) OR isset($_POST['preview']) OR !isset($_POST['submit'])) {
	if(!empty($data['thread']['board_read']) AND $account['access_clansphere'] < 5) {
		$data['thread']['errormsg'] = $cs_lang['thread_only_read'];
		}
		else {
		$data['thread']['smileys_box'] = cs_abcode_smileys('comments_text');
		$data['thread']['text_size'] = $max_text;
		$data['thread']['abcode_box'] = cs_abcode_features('comments_text');
		$data['thread']['comments_text'] = $ori_text;
		
		$a = $run_loop_files;
		$run_loop_files = !empty($run_loop_files) ? $run_loop_files : 1;
		
		if($files == 1) {
			$data['thread']['up_icon'] = cs_icon('download') . $cs_lang['uploads'];
			$data['if']['file'] = true;
			
			
		for($run=0; $run < $run_loop_files; $run++) {
			$num = $run + 1;
			$cs_files["text_$num"] = isset($_POST["text_$num"]) ? $_POST["text_$num"] : '';
				
			$data['files'][$run]['do_icon'] = cs_icon('download') . $cs_lang['file'] . ' ' . $num;
				
			if(empty($file_name[$num])) {
				$data['if'][$run]['no_file'] = true;
				$data['files'][$run]['file_num'] = cs_html_input("file_$num",'','file');
				$matches[1] = $cs_lang['infos'];
				$return_types = '';
			
				foreach($filetypes AS $add) {
					$return_types .= empty($return_types) ? $add : ', ' . $add;
				}
		
				$matches[2] = $cs_lang['max_size'] . cs_filesize($options['file_size']) . cs_html_br(1);
				$matches[2] .= $cs_lang['filetypes'] . $return_types;
				$data['files'][$run]['file_matches'] = ' ' . cs_abcode_clip($matches);
			}
			else {
				$data['files'][$run]['file_name_hidden'] = cs_html_vote("file_name_$num",$file_name[$num],'hidden');
				$data['files'][$run]['file_up_name'] = cs_html_vote("file_upload_name_$num",$file_upload_name[$num],'hidden');
				$file = $file_name[$num];
				$extension = strlen(strrchr($file,"."));
				$name = strlen($file);
				$ext = substr($file,$name - $extension + 1,$name);
					
				if(strcasecmp($ext,'jpg') == '0' OR strcasecmp($ext,'jpeg') == '0' OR strcasecmp($ext,'gif') == '0' OR strcasecmp($ext,'png') == '0') {
					$cs_lap = cs_html_img('mods/gallery/image.php?boardpic=' . $file_name[$num] . '&boardthumb');
					$data['files'][$run]['file_link'] = cs_html_link('mods/gallery/image.php?boardpic=' . $file_name[$num],$cs_lap);
					$data['files'][$run]['file_symbol'] = cs_html_img('symbols/files/filetypes/' . $ext . '.gif',0,0,0,$ext);
					$data['files'][$run]['file_name'] = ' ' . $file_name[$num];
					$data['files'][$run]['remove_file'] = cs_html_vote('remove_file_' . $num,$cs_lang['remove'],'submit');
				}
				else {
					$data['files'][$run]['file_symbol'] = cs_html_img('symbols/files/filetypes/' . $ext . '.gif',0,0,0,$ext);
					$data['files'][$run]['file_name'] = ' ' . $file_name[$num];
					$data['files'][$run]['remove_file'] = cs_html_vote('remove_file_' . $num,$cs_lang['remove'],'submit');
				}
			}
			
		}
		}
		
		
		if($files == '1' AND $account['access_board'] >= '2') {
			$data['if']['addfile2'] = true;
			$data['thread']['files_loop_hidden'] = cs_html_vote('run_loop_files',$run_loop_files,'hidden');
			$data['thread']['files_hidden'] = cs_html_vote('files','1','hidden');
			$data['thread']['new_file'] = cs_html_vote('files+',$cs_lang['add_file'],'submit');
		}
		
		if($files == '0' AND $account['access_board'] >= '2')	{
			$data['if']['addfile'] = true;
			$data['thread']['new_file'] = cs_html_vote('new_file',$cs_lang['add_file'],'submit');
		}
		
		$data['thread']['fid'] = $fid;
	
		require_once('mods/comments/functions.php');
	}
}
else {
  $opt = "comments_mod = 'board' AND comments_fid = '" . $fid . "'";
  $count_com = cs_sql_count(__FILE__,'comments',$opt);

  $options = cs_sql_option(__FILE__,'board');
  if($options['sort'] == 'DESC') {
    $start = 0;
  } else {
    $start = floor($count_com / $account['users_limit']) * $account['users_limit'];
    $count_com = $count_com % $account['users_limit'];
  }

  $user_ip = $_SERVER['REMOTE_ADDR'];
  $time = cs_time();

  $com_cells = array('users_id', 'comments_fid', 'comments_mod', 'comments_ip', 'comments_time', 'comments_text');
  $com_save = array($account['users_id'], $fid, 'board', $user_ip, $time, $text);
  cs_sql_insert(__FILE__,'comments',$com_cells,$com_save);
  
  $where  = "comments_mod='board' AND comments_fid='" . $fid . "' AND comments_ip='";
  $where .= $user_ip . "' AND comments_time='" . $time . "'";
  $comment_now = cs_sql_select(__FILE__,'comments','comments_id',$where);
  
  $thread_cells = array('threads_last_time','threads_last_user');
  $thread_save = array(cs_time(),$account['users_id']);
  cs_sql_update(__FILE__,'threads',$thread_cells,$thread_save,$fid);

  for($run=0; $run < $run_loop_files; $run++) {
    $num = $run+1;
    $files_cells = array('users_id','threads_id','comments_id','boardfiles_time','boardfiles_name');
    $files_save = array($account['users_id'],$fid,$comment_now['comments_id'],cs_time(),$file_name[$num]);
    cs_sql_insert(__FILE__,'boardfiles',$files_cells,$files_save);
    $files_select_new_id = cs_sql_insertid(__FILE__);
    $ext = substr($file_name[$num],strlen($file_name[$num])+1-strlen(strrchr($file_name[$num],'.')));
    $path = $cs_main['def_path'] . '/uploads/board/files/';
    $target = $path . $file_upload_name[$num];
    $target2 = $path . $files_select_new_id . '.' . $ext;
    $fileHand = fopen($target, 'r');
  	fclose($fileHand);
  	rename( $target, $target2 );
  }
  
  include_once('mods/board/repair.php');
	cs_board_comments($data['thread']['board_id']);
	cs_threads_comments($data['thread']['threads_id']);

  $more = 'where=' . $fid . '&start=' . $start . '#com' . ++$count_com;
  cs_redirect($cs_lang['create_done'],'board','thread',$more);
}

echo cs_subtemplate(__FILE__,$data,'board','com_create');

if(!empty($error) OR isset($_POST['preview']) OR !isset($_POST['submit'])) {
	if(!empty($data['thread']['board_read']) AND $account['access_clansphere'] < 5) {
	} else {
	cs_comments_view($fid,'board','com_create','',false,5);	
	}
}
//alt
/*
echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
$head  = cs_link($cs_lang['board'],'board','list','normalb') .' -> ';
$head .= cs_link($data['thread']['categories_name'],'board','list','where=' .$data['thread']['categories_id'],'normalb') .' -> ';
$head .= cs_link($data['thread']['board_name'],'board','listcat','where=' .$data['thread']['board_id'],'normalb') .' -> ';
$head .= cs_link($data['thread']['threads_headline'],'board','thread','where=' .$data['thread']['threads_id'],'normalb');
echo $cs_lang['mod'] .' - '. $cs_lang['head_com_create'];
echo cs_html_roco(1,'leftc');
echo $head;
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);
$files = isset($_POST['files']) ? $_POST['files'] : 0;

if(isset($_POST['new_file'])) {
  $files = '1';
}

$run_loop_files = isset($_POST['run_loop_files']) ? $_POST['run_loop_files'] : 0;

if(!empty($files)) {
  $text = $_POST['comments_text'];
}

$a = '0';
$b = '1';

for($run=0; $run < $run_loop_files; $run++) {
  $num = $run+1;
  
  if(!empty($_FILES["file_$num"]['name'])) {
    $board_files_name = $cs_files[$run]['boardfiles_name'] = $_FILES["file_$num"]['name'];

    $ext = substr($board_files_name,strlen($board_files_name)+1-strlen(strrchr($board_files_name,'.')));
    
  if($_FILES["file_$num"]['size'] > $options['file_size']) {
      $message .= $cs_lang['error_filesize'] . cs_html_br(1);
      $error++;
      $file_error[$num] = '1';
    }
    
  $check_type = '';
    $count_filetypes = count($filetypes);
  
  for($run_a=0; $run_a < $count_filetypes; $run_a++) {
    if('0' == strcasecmp($filetypes[$run_a], $ext)) {
      $check_type = 1;
    }
  }
  
  if($check_type != 1) {
    $message .= $cs_lang['error_filetype'] . cs_html_br(1);
    $thread_error++;
    $file_error[$num] = '1';
  }
  
  if(!empty($file_error[$num])) {
    echo cs_html_table(1,'forum',1);
    echo cs_html_roco(1,'leftc');
    echo cs_icon('important');
    echo $cs_lang['error_subheader'];
    echo cs_html_roco(0);
    echo cs_html_roco(1,'leftb');
    echo $message;
    echo cs_html_roco(0);
    echo cs_html_table(0);
    echo cs_html_br(1);
  }
  }
  
  if(!empty($_FILES["file_$num"]['name']) AND empty($file_error[$num])) {
    $file_name[$num] = $_FILES["file_$num"]['name'];

    $hash = '';
    $pattern = "abcdefghijklmnopqrstuvwxyz";
    
  for($i=0;$i<8;$i++) {
      $hash .= $pattern{rand(0,25)};
    }
    
  $file_upload_name[$num] = $hash . '.' . $ext;
    
  if(cs_upload('board/files', $file_upload_name[$num], $_FILES["file_$num"]['tmp_name'])) {
      $a++;
    }
  else {
      $message .= $cs_lang['error_fileupload'] . cs_html_br(1);
      $thread_error++;
    }
  }
  
  if(!empty($_POST["file_name_$num"]) AND empty($file_error[$num])) {
    $file_name[$num] = $_POST["file_name_$num"];
    $file_upload_name[$num] = $_POST["file_upload_name_$num"];
    
  if(isset($_POST["remove_file_$num"])) {
      cs_unlink('board', $file_upload_name[$num], 'files');
      $file_name[$num] = '';
    }
  else {
      $file_name[$b] = $file_name[$num];
      $a++;
      $b++;
    }
  }
}

$run_loop_files = $a;

if(isset($_POST['files+'])) {
  $run_loop_files++;
}

if(isset($_POST['submit']) OR isset($_POST['preview']) OR isset($_POST['advanced'])) {
  $text = $_POST['comments_text'];
  $text_count = strlen($text);
  
  if($text_count >= $max_text) {
    $error++;
    $count = $text_count - $max_text;
    $errormsg .= $cs_lang['text_to_long'] . $text_count . $cs_lang['text_to_long_2'] . $count . $cs_lang['text_to_long_3'] . cs_html_br(1);
  }

  if(empty($text)) {
    $error++;
    $errormsg .= $cs_lang['no_text'] . cs_html_br(1);
  }

  $find = "comments_mod = 'board' AND comments_fid = '" . $fid . "'";
  $last_from = cs_sql_select(__FILE__,'comments','users_id, comments_time',$find,'comments_id DESC');
  $time = cs_time();

  if($account['users_id'] == $last_from['users_id'] && $last_from['comments_time'] + $options['doubleposts'] > $time) {
    $error++;
    $errormsg .= $cs_lang['last_own'];

    if($options['doubleposts'] != -1) {
    $wait_days = round(($last_from['comments_time'] + $options['doubleposts'] - $time) / 86400, 1);
    $errormsg .=  ' ' . sprintf($cs_lang['wait_after_comment'],$wait_days);
    }
    $errormsg .= cs_html_br(1);
  }

  $where = "users_id = '" . $account['users_id'] . "' AND comments_mod = 'board'";
  $flood = cs_sql_select(__FILE__,'comments','comments_time',$where,'comments_time DESC');
  $maxtime = $flood['comments_time'] + $cs_main['def_flood'];
  
  if($maxtime > cs_time()) {
    $error++;
    $diff = $maxtime - cs_time();
    $errormsg .= sprintf($cs_lang['flood_on'], $diff);
  }

  $board = cs_sql_select(__FILE__,'threads','threads_close',"threads_id = '" . $fid . "'");
  
  if(!empty($board['threads_close'])) {
    $error++;
    $errormsg .= $cs_lang['not_able'] . cs_html_br(1);
  }

  $text = preg_replace_callback("=\[img\](.*?)\[/img\]=si","cs_abcode_resize",$text);
  $text = preg_replace_callback("=\[img width\=(.*?) height\=(.*?)\](.*?)\[/img\]=si","cs_abcode_resize",$text);
}

if(!empty($_REQUEST['quote'])) {
  $def = explode('-', $_REQUEST['quote']);
  
  if($def[0]=='c') {
    $quote = cs_sql_select($file,'comments','users_id,comments_text,comments_time',"comments_id = '" . cs_sql_escape($def[1]) . "'");
    $cs_users = cs_sql_select(__FILE__,'users','users_id, users_nick',"users_id = '" . $quote['users_id'] . "'");
    $text = '[quote]' .$quote['comments_text']. '[/quote]';
    $url = $_SERVER['PHP_SELF'] . '?mod=users&action=view&id=' . $cs_users['users_id'];
    $text = cs_date('unix',$quote['comments_time'],1) . ' - [url=' . $url . ']';
    $text .= $cs_users['users_nick'] . "[/url]:\n[quote]" . $quote['comments_text'] . '[/quote]';
  }
  else if($def[0]=='t') {
    $select = "threads thr INNER JOIN {pre}_board brd ON thr.board_id = brd.board_id";
  $cells = "thr.users_id AS users_id, thr.threads_text AS threads_text, thr.threads_time AS threads_time, brd.board_access AS board_access";
  $where = "thr.threads_id = '" . cs_sql_escape($def[1]) . "' AND brd.board_access <= '" . $account['access_board'] . "'";
  $quote = cs_sql_select($file,$select,$cells,$where);
  $cs_users = cs_sql_select(__FILE__,'users','users_id, users_nick',"users_id = '" . $quote['users_id'] . "'");
  $url = $_SERVER['PHP_SELF'] . '?mod=users&action=view&id=' . $cs_users['users_id'];
  $text = cs_date('unix',$quote['threads_time'],1) . ' - [url=' . $url . ']';
  $text .= $cs_users['users_nick'] . "[/url]:\n[quote]" . $quote['threads_text'] . '[/quote]';
  }
}

if(!empty($error)) {
  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'leftb');
  echo $errormsg;
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_br(1);
}

if(isset($_POST['preview']) AND empty($error)) {
  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'headb');
  echo $cs_lang['preview'];
  echo cs_html_roco(1,'leftc');
  echo cs_secure($text,1,1);
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_br(1);
}

if(!empty($error) OR isset($_POST['preview']) OR !isset($_POST['submit'])) {
if(!empty($data['thread']['board_read']) AND $account['access_clansphere'] < 5) {
    echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'centerb');
  echo $cs_lang['thread_only_read'];
  echo cs_html_roco(0);
  echo cs_html_table(0);  
  }
  else {
  echo cs_html_form (1,'board_com_create','board','com_create',1);
  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'leftc');
  echo cs_icon('kate') . $cs_lang['text'] . ' *';
  echo cs_html_br(2);
  echo cs_abcode_smileys('comments_text');
  echo cs_html_br(2);
  echo 'max. ' . $max_text . $cs_lang['indi'];
  echo cs_html_roco(2,'leftb');
  echo cs_abcode_features('comments_text');
  echo cs_html_textarea('comments_text',$text,'50','20');
  echo cs_html_roco(0);
  
  $a = $run_loop_files;
  $run_loop_files = !empty($run_loop_files) ? $run_loop_files : 1;
  
  if($files == 1) {
    echo cs_html_roco(1,'headb',0,2);
    echo cs_icon('download') . $cs_lang['uploads'];
    echo cs_html_roco(0);
    
  for($run=0; $run < $run_loop_files; $run++) {
      $num = $run + 1;
      $cs_files["text_$num"] = isset($_POST["text_$num"]) ? $_POST["text_$num"] : '';
      
    echo cs_html_roco(1,'leftc');
      echo cs_icon('download') . $cs_lang['file'] . ' ' . $num;
      echo cs_html_roco(2,'leftb');
      
    if(empty($file_name[$num])) {
        echo cs_html_input("file_$num",'','file');
        $matches[1] = $cs_lang['infos'];
    $return_types = '';
    
    foreach($filetypes AS $add) {
      $return_types .= empty($return_types) ? $add : ', ' . $add;
    }
    $matches[2] = $cs_lang['max_size'] . cs_filesize($options['file_size']) . cs_html_br(1);
    $matches[2] .= $cs_lang['filetypes'] . $return_types;
    echo ' ' . cs_abcode_clip($matches);
    }
    else {
        echo cs_html_vote("file_name_$num",$file_name[$num],'hidden');
        echo cs_html_vote("file_upload_name_$num",$file_upload_name[$num],'hidden');
        $file = $file_name[$num];
        $extension = strlen(strrchr($file,"."));
        $name = strlen($file);
        $ext = substr($file,$name - $extension + 1,$name);
        
    if(strcasecmp($ext,'jpg') == '0' OR strcasecmp($ext,'jpeg') == '0' OR strcasecmp($ext,'gif') == '0' OR strcasecmp($ext,'png') == '0') {
          $cs_lap = cs_html_img('mods/gallery/image.php?boardpic=' . $file_name[$num] . '&boardthumb');
      echo cs_html_div(1,'float:left;padding:3px;border:1px solid black;background:gainsboro;');
      echo cs_html_link('mods/gallery/image.php?boardpic=' . $file_name[$num],$cs_lap);
      echo cs_html_div(0);
      echo cs_html_div(1,'float:left;padding:3px;margin-left:10px;');
      echo cs_html_img('symbols/files/filetypes/' . $ext . '.gif',0,0,0,$ext);
      echo ' ' . $file_name[$num];
      echo cs_html_br(1);
      echo cs_html_vote('remove_file_' . $num,$cs_lang['remove'],'submit');
      echo cs_html_div(0);
    }
    else {
      echo cs_html_img('symbols/files/filetypes/' . $ext . '.gif',0,0,0,$ext);
      echo ' ' . $file_name[$num];
      echo cs_html_vote('remove_file_' . $num,$cs_lang['remove'],'submit');
    }
    }
    
    echo cs_html_roco(0);
  }
  }
  
  echo cs_html_roco(1,'leftc');
  echo cs_icon('ksysguard') . $cs_lang['options+'];
  echo cs_html_roco(2,'leftb');
  
  if($files == '1' AND $account['access_board'] >= '2') {
    echo cs_html_vote('run_loop_files',$run_loop_files,'hidden');
    echo cs_html_vote('files','1','hidden');
    echo cs_html_vote('files+',$cs_lang['add_file'],'submit');
  }
  
  if($files == '0' AND $account['access_board'] >= '2')  {
    echo cs_html_vote('new_file',$cs_lang['add_file'],'submit');
  }
  
  echo cs_html_roco(0);
  echo cs_html_roco(1,'leftc');
  echo cs_icon('ksysguard') . $cs_lang['options'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_vote('id',$fid,'hidden');
  echo cs_html_vote('submit',$cs_lang['submit'],'submit');
  echo cs_html_vote('preview',$cs_lang['preview'],'submit');
  echo cs_html_vote('reset',$cs_lang['reset'],'reset');
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_form(0);

  require_once('mods/comments/functions.php');
  echo cs_html_br(2);
  cs_comments_view($fid,'board','com_create','',false,5);
  }
}
else {
  $opt = "comments_mod = 'board' AND comments_fid = '" . $fid . "'";
  $count_com = cs_sql_count(__FILE__,'comments',$opt);

  $options = cs_sql_option(__FILE__,'board');
  if($options['sort'] == 'DESC') {
    $start = 0;
  } else {
    $start = floor($count_com / $account['users_limit']) * $account['users_limit'];
    $count_com = $count_com % $account['users_limit'];
  }

  $user_ip = $_SERVER['REMOTE_ADDR'];
  $time = cs_time();

  $com_cells = array('users_id', 'comments_fid', 'comments_mod', 'comments_ip', 'comments_time', 'comments_text');
  $com_save = array($account['users_id'], $fid, 'board', $user_ip, $time, $text);
  cs_sql_insert(__FILE__,'comments',$com_cells,$com_save);
  
  $where  = "comments_mod='board' AND comments_fid='" . $fid . "' AND comments_ip='";
  $where .= $user_ip . "' AND comments_time='" . $time . "'";
  $comment_now = cs_sql_select(__FILE__,'comments','comments_id',$where);
  
  $thread_cells = array('threads_last_time','threads_last_user');
  $thread_save = array(cs_time(),$account['users_id']);
  cs_sql_update(__FILE__,'threads',$thread_cells,$thread_save,$fid);

  for($run=0; $run < $run_loop_files; $run++) {
    $num = $run+1;
    $files_cells = array('users_id','threads_id','comments_id','boardfiles_time','boardfiles_name');
    $files_save = array($account['users_id'],$fid,$comment_now['comments_id'],cs_time(),$file_name[$num]);
    cs_sql_insert(__FILE__,'boardfiles',$files_cells,$files_save);
    $files_select_new_id = cs_sql_insertid(__FILE__);
    $ext = substr($file_name[$num],strlen($file_name[$num])+1-strlen(strrchr($file_name[$num],'.')));
    $path = $cs_main['def_path'] . '/uploads/board/files/';
    $target = $path . $file_upload_name[$num];
    $target2 = $path . $files_select_new_id . '.' . $ext;
    $fileHand = fopen($target, 'r');
    fclose($fileHand);
    rename( $target, $target2 );
  }
  
  include_once('mods/board/repair.php');
  cs_board_comments($data['thread']['board_id']);
  cs_threads_comments($data['thread']['threads_id']);

  $more = 'where=' . $fid . '&start=' . $start . '#com' . ++$count_com;
  cs_redirect($cs_lang['create_done'],'board','thread',$more);
}

*/
?>