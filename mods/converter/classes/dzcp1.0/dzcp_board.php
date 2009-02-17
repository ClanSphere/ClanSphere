<?php
// DZCP SQL Connect
$dzcp_connect = mysql_connect($dzcp_db['place'], $dzcp_db['user'], $dzcp_db['pwd']);
$dzcp_database = mysql_select_db($dzcp_db['name']);

// GET Board Kategorien
$kat_query = "SELECT * FROM " . $dzcp_db['prf'] . "forumkats";
$kat_data = mysql_query($kat_query, $dzcp_connect);
$subkat_query = "SELECT * FROM " . $dzcp_db['prf'] . "forumsubkats";
$subkat_data = mysql_query($subkat_query, $dzcp_connect);
$threads_query = "SELECT * FROM " . $dzcp_db['prf'] . "forumthreads";
$threads_data = mysql_query($threads_query, $dzcp_connect);
$comments_query = "SELECT * FROM " . $dzcp_db['prf'] . "forumposts";
$comments_data = mysql_query($comments_query, $dzcp_connect);

$run_kat = 0;
$run_subkat = 0;
$run_threads = 0;
$run_comments = 0;
while ($board_result = mysql_fetch_assoc($kat_data)) { $dzcp_boardkats[$run_kat] = $board_result; $run_kat++; }
while ($subboard_result = mysql_fetch_assoc($subkat_data)) { $dzcp_subboard[$run_subkat] = $subboard_result; $run_subkat++; }
while ($threads_result = mysql_fetch_assoc($threads_data)) { $dzcp_threads[$run_threads] = $threads_result; $run_threads++; }
while ($comments_result = mysql_fetch_assoc($comments_data)) { $dzcp_comments[$run_comments] = $comments_result; $run_comments++; }
mysql_close();

$data = array();
// Convert ForumKat Datas
for($run=0; $run<count($dzcp_boardkats); $run++) {
  $data['kat'][$run]['categories_mod'] = 'board';
  $data['kat'][$run]['categories_name'] = $dzcp_boardkats[$run]['name'];
  $data['kat'][$run]['categories_access'] = $dzcp_boardkats[$run]['intern'] == '1' ? '3' : '0';
  $data['kat'][$run]['categories_order'] = $dzcp_boardkats[$run]['kid'];
  $data['kat'][$run]['old_id'] = $dzcp_boardkats[$run]['id'];
}

// CSP SQL Connect
$csp_connect = mysql_connect($csp_db['place'], $csp_db['user'], $csp_db['pwd']);
$csp_database = mysql_select_db($csp_db['name']) or mysql_error($dzcp_connect);

// Create old_id for cats
$sql_query = "ALTER TABLE " . $csp_db['prf'] . "categories ADD old_id int(3) NOT NULL default '0'";
$result = mysql_query($sql_query, $csp_connect);

// Create Board Kats
for($run=0; $run<count($data['kat']); $run++) {
  $data_cells = array_keys($data['kat'][$run]);
  $data_saves = array_values($data['kat'][$run]);
  $new_data_cells = '';
  $new_data_saves = '';
  for($runb=0; $runb<count($data_cells); $runb++) {
    $set = $runb == 0 ? '' : ', ';
    $new_data_cells .= $set . $data_cells[$runb];
  $new_data_saves .= $set . "'" . $data_saves[$runb] . "'";
  }
  $sql_query = "INSERT INTO " . $csp_db['prf'] . "categories (" . $new_data_cells . ") VALUES (" . $new_data_saves . ");";
  mysql_query($sql_query, $csp_connect);
  $error = mysql_error($csp_connect);
}  
if(!empty($error)) {
  echo 'Ein Fehler ist aufgetreten: ' . mysql_error($csp_connect);
  echo '<img src="../../symbols/crystal_project/16/cancel.png" width="16" height="16" alt="OK" /><br />';
} else {
  echo 'Board Kategorien wurden erfolgreich erstellt.<img src="../../symbols/crystal_project/16/submit.png" width="16" height="16" alt="OK" /><br />';
}

// Create old_id for Boards
$sql_query = "ALTER TABLE " . $csp_db['prf'] . "board ADD old_id int(3) NOT NULL default '0'";
$result = mysql_query($sql_query, $csp_connect);

// Convert Board Sub Kats
for($run=0; $run<count($dzcp_subboard); $run++) {
  $sql_query = "SELECT * FROM " . $csp_db['prf'] . "categories WHERE old_id = '" . $dzcp_subboard[$run]['sid'] ."' LIMIT 1";
  $old_subboard_kat = mysql_query($sql_query, $csp_connect);
  $old = mysql_fetch_assoc($old_subboard_kat);
  $data['board'][$run]['categories_id'] = $old['categories_id'];
  $data['board'][$run]['old_id'] = $dzcp_subboard[$run]['id'];
  $data['board'][$run]['users_id'] = '1';
  $data['board'][$run]['board_name'] = $dzcp_subboard[$run]['kattopic'];
  $data['board'][$run]['board_text'] = $dzcp_subboard[$run]['subtopic'];
  $data['board'][$run]['board_time'] = time();
}
// Update Baord Sub Kats
for($run=0; $run<count($data['board']); $run++) {
  $data_cells = array_keys($data['board'][$run]);
  $data_saves = array_values($data['board'][$run]);
  $new_data_cells = '';
  $new_data_saves = '';
  for($runb=0; $runb<count($data_cells); $runb++) {
    $set = $runb == 0 ? '' : ', ';
    $new_data_cells .= $set . $data_cells[$runb];
  $new_data_saves .= $set . "'" . $data_saves[$runb] . "'";
  }
  $sql_query = "INSERT INTO " . $csp_db['prf'] . "board (" . $new_data_cells . ") VALUES (" . $new_data_saves . ");";
  mysql_query($sql_query, $csp_connect);
  $error = mysql_error($csp_connect);
}  
if(!empty($error)) {
  echo 'Ein Fehler ist aufgetreten: ' . mysql_error($csp_connect);
  echo '<img src="../../symbols/crystal_project/16/cancel.png" width="16" height="16" alt="OK" /><br />';
} else {
  echo 'Board Sub-Kategorien wurden erfolgreich erstellt.<img src="../../symbols/crystal_project/16/submit.png" width="16" height="16" alt="OK" /><br />';
}

// Create old_id for Threads
$sql_query = "ALTER TABLE " . $csp_db['prf'] . "threads ADD old_id int(3) NOT NULL default '0'";
$result = mysql_query($sql_query, $csp_connect);

// Convert Threads
for($run=0; $run<count($dzcp_threads); $run++) {
  $sql_query = "SELECT * FROM " . $csp_db['prf'] . "board WHERE old_id = '" . $dzcp_threads[$run]['kid'] ."' LIMIT 1";
  $old_board_kat = mysql_query($sql_query, $csp_connect);
  $old = mysql_fetch_assoc($old_board_kat);
  $data['threads'][$run]['board_id'] = $old['board_id'];
  $data['threads'][$run]['users_id'] = $dzcp_threads[$run]['t_reg'];
  $data['threads'][$run]['threads_headline'] = $dzcp_threads[$run]['topic'];
  $text = $dzcp_threads[$run]['t_text'];
  $text = str_replace('&#34;','"',$text);
  $text = preg_replace('=<p align\="(left|center|right|justify)">(.*?)</p>=si','[\\1]\\2[/\\1]',$text);
  $replace = array();
  $replace['b'] = 'b';
  $replace['u'] = 'u';
  $replace['ul'] = 'list';
  $old = array();
  $new = array();
  foreach ($replace AS $key => $value) {
    $old[] = '<' . $key . '>';
    $new[] = '[' . $value . ']';
    $old[] = '</' . $key . '>';
    $new[] = '[/' . $value . ']';
  }
  $text = str_replace($old,$new,$text);
  $text = str_replace('<br />',"\r\n",$text);
  $text = str_replace(array('<p>','</p>'),array('','<br />'),$text);
  $text = str_replace(array('<ol>','</ol>'),array('[list]','[/list]'),$text);
  $text = str_replace(array('<li>','</li>'),array('[*]',''),$text);
  $text = str_replace(array('&auml;','&Auml;','&uuml;','&Uuml;','&ouml;','&Ouml;','&nbsp;'),array('ä','Ä','ü','Ü','ö','Ö',' '),$text);
  $text = strip_tags($text);
  $text = htmlspecialchars_decode($text);
  $data['threads'][$run]['threads_text'] = $text;
  $data['threads'][$run]['threads_time'] = $dzcp_threads[$run]['t_date'];  
  $data['threads'][$run]['threads_view'] = $dzcp_threads[$run]['hits'];
  $data['threads'][$run]['threads_important'] = $dzcp_threads[$run]['sticky'];   
  $data['threads'][$run]['threads_close'] = $dzcp_threads[$run]['closed'];   
  $data['threads'][$run]['old_id'] = $dzcp_threads[$run]['id'];
}

// Update Threads
for($run=0; $run<count($data['threads']); $run++) {
  $data_cells = array_keys($data['threads'][$run]);
  $data_saves = array_values($data['threads'][$run]);
  $new_data_cells = '';
  $new_data_saves = '';
  for($runb=0; $runb<count($data_cells); $runb++) {
    $set = $runb == 0 ? '' : ', ';
    $new_data_cells .= $set . $data_cells[$runb];
  $new_data_saves .= $set . "'" . $data_saves[$runb] . "'";
  }
  $sql_query = "INSERT INTO " . $csp_db['prf'] . "threads (" . $new_data_cells . ") VALUES (" . $new_data_saves . ");";
  mysql_query($sql_query, $csp_connect);
  $error = mysql_error($csp_connect);
} 
if(!empty($error)) {
  echo 'Ein Fehler ist aufgetreten: ' . mysql_error($csp_connect);
  echo '<img src="../../symbols/crystal_project/16/cancel.png" width="16" height="16" alt="OK" /><br />';
} else {
  echo 'Threads wurden erfolgreich erstellt.<img src="../../symbols/crystal_project/16/submit.png" width="16" height="16" alt="OK" /><br />';
}

// Convert Comments
for($run=0; $run<count($dzcp_comments); $run++) {
  $sql_query = "SELECT * FROM " . $csp_db['prf'] . "threads WHERE old_id = '" . $dzcp_comments[$run]['sid'] ."' LIMIT 1";
  $old_thread = mysql_query($sql_query, $csp_connect);
  $old = mysql_fetch_assoc($old_thread);
  $data['comments'][$run]['users_id'] = $dzcp_comments[$run]['reg'];
  $data['comments'][$run]['comments_fid'] = $old['threads_id'];
  $data['comments'][$run]['comments_mod'] = 'board';
  $data['comments'][$run]['comments_ip'] = $dzcp_comments[$run]['ip'];
  $data['comments'][$run]['comments_time'] = $dzcp_comments[$run]['date'];
  $text = $dzcp_comments[$run]['text'];
  $text = str_replace('&#34;','"',$text);
  $text = preg_replace('=<p align\="(left|center|right|justify)">(.*?)</p>=si','[\\1]\\2[/\\1]',$text);
  $replace = array();
  $replace['b'] = 'b';
  $replace['u'] = 'u';
  $replace['ul'] = 'list';
  $old = array();
  $new = array();
  foreach ($replace AS $key => $value) {
    $old[] = '<' . $key . '>';
    $new[] = '[' . $value . ']';
    $old[] = '</' . $key . '>';
    $new[] = '[/' . $value . ']';
  }
  $text = str_replace($old,$new,$text);
  $text = str_replace('<br />',"\r\n",$text);
  $text = str_replace(array('<p>','</p>'),array('','<br />'),$text);
  $text = str_replace(array('<ol>','</ol>'),array('[list]','[/list]'),$text);
  $text = str_replace(array('<li>','</li>'),array('[*]',''),$text);
  $text = str_replace(array('&auml;','&Auml;','&uuml;','&Uuml;','&ouml;','&Ouml;','&nbsp;'),array('ä','Ä','ü','Ü','ö','Ö',' '),$text);
  $text = strip_tags($text);
  $text = htmlspecialchars_decode($text);
  $data['comments'][$run]['comments_text'] = $text;
}

// Update Comments
for($run=0; $run<count($data['comments']); $run++) {
  $data_cells = array_keys($data['comments'][$run]);
  $data_saves = array_values($data['comments'][$run]);
  $new_data_cells = '';
  $new_data_saves = '';
  for($runb=0; $runb<count($data_cells); $runb++) {
    $set = $runb == 0 ? '' : ', ';
    $new_data_cells .= $set . $data_cells[$runb];
  $new_data_saves .= $set . "'" . $data_saves[$runb] . "'";
  }
  $sql_query = "INSERT INTO " . $csp_db['prf'] . "comments (" . $new_data_cells . ") VALUES (" . $new_data_saves . ");";
  mysql_query($sql_query, $csp_connect);
  $error = mysql_error($csp_connect);
} 
if(!empty($error)) {
  echo 'Ein Fehler ist aufgetreten: ' . mysql_error($csp_connect);
  echo '<img src="../../symbols/crystal_project/16/cancel.png" width="16" height="16" alt="OK" /><br />';
} else {
  echo 'Thread Comments wurden erfolgreich erstellt.<img src="../../symbols/crystal_project/16/submit.png" width="16" height="16" alt="OK" /><br />';
}
mysql_close();
?>