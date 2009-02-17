<?php
// DZCP SQL Connect
$dzcp_connect = mysql_connect($dzcp_db['place'], $dzcp_db['user'], $dzcp_db['pwd']);
$dzcp_database = mysql_select_db($dzcp_db['name']);

// GET Newskat Datas
$kat_query = "SELECT * FROM " . $dzcp_db['prf'] . "newskat";
$kat_data = mysql_query($kat_query, $dzcp_connect);

// GET News Datas
$news_query = "SELECT * FROM " . $dzcp_db['prf'] . "news";
$news_data = mysql_query($news_query, $dzcp_connect);

$run_kat = 0;
$run_news = 0;
while ($kat_result = mysql_fetch_assoc($kat_data)) { $dzcp_newskats[$run_kat] = $kat_result; $run_kat++; }
while ($news_result = mysql_fetch_assoc($news_data)) { $dzcp_news[$run_news] = $news_result; $run_news++; }
mysql_close();

$data = array();
// Convert Newskat Datas
for($run=0; $run<count($dzcp_newskats); $run++) {
  $data['kat'][$run]['categories_name'] = $dzcp_newskats[$run]['kategorie'];
  $data['kat'][$run]['categories_picture'] = $dzcp_newskats[$run]['katimg'];
  $data['kat'][$run]['categories_access'] = '0';
  $data['kat'][$run]['categories_order'] = '0';
  $data['kat'][$run]['categories_subid'] = '0';
  $data['kat'][$run]['old_id'] = $dzcp_newskats[$run]['id'];
}

// CSP SQL Connect
$csp_connect = mysql_connect($csp_db['place'], $csp_db['user'], $csp_db['pwd']);
$csp_database = mysql_select_db($csp_db['name']) or mysql_error($dzcp_connect);

// Create old_id for cats
$sql_query = "ALTER TABLE " . $csp_db['prf'] . "categories ADD old_id int(3) NOT NULL default '0'";
$result = mysql_query($sql_query, $csp_connect);

// Update  News Kats
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
  $sql_query = "INSERT INTO " . $csp_db['prf'] . "categories (" . $new_data_cells . ", categories_mod) VALUES (" . $new_data_saves . ", 'news');";
  mysql_query($sql_query, $csp_connect);
  $sql_query = "INSERT INTO " . $csp_db['prf'] . "categories (" . $new_data_cells . ", categories_mod) VALUES (" . $new_data_saves . ", 'articles');";
  mysql_query($sql_query, $csp_connect);  
  $error = mysql_error($csp_connect);
}  
if(!empty($error)) {
  echo 'Ein Fehler ist aufgetreten: ' . mysql_error($csp_connect);
  echo '<img src="../../symbols/crystal_project/16/cancel.png" width="16" height="16" alt="OK" /><br />';
} else {
  echo 'News Kategorien wurden erfolgreich erstellt.<img src="../../symbols/crystal_project/16/submit.png" width="16" height="16" alt="OK" /><br />';
}

// Convert News Datas
for($run=0; $run<count($dzcp_news); $run++) {
  $sql_query = "SELECT * FROM " . $csp_db['prf'] . "categories WHERE categories_mod = 'news' AND old_id = '" . $dzcp_news[$run]['kat'] ."' LIMIT 1";
  $old_news_kat = mysql_query($sql_query , $dzcp_connect);
  $old = mysql_fetch_assoc($old_news_kat);
  $data['news'][$run]['categories_id'] = $old['categories_id'];
  $data['news'][$run]['users_id'] = $dzcp_news[$run]['autor'];
  $data['news'][$run]['news_time'] = $dzcp_news[$run]['datum'];
  $data['news'][$run]['news_headline'] = $dzcp_news[$run]['titel'];
  $data['news'][$run]['news_text'] = '[html]' . $dzcp_news[$run]['text'] . '[/html]';
  $data['news'][$run]['news_close'] = '0';
  $data['news'][$run]['news_public'] = '1';  
  $data['news'][$run]['news_attached'] = $dzcp_news[$run]['sticky'];
}

// Update News
for($run=0; $run<count($data['news']); $run++) {
  $data_cells = array_keys($data['news'][$run]);
  $data_saves = array_values($data['news'][$run]);
  $new_data_cells = '';
  $new_data_saves = '';
  for($runb=0; $runb<count($data_cells); $runb++) {
    $set = $runb == 0 ? '' : ', ';
    $new_data_cells .= $set . $data_cells[$runb];
  $new_data_saves .= $set . "'" . $data_saves[$runb] . "'";
  }
  $sql_query = "INSERT INTO " . $csp_db['prf'] . "news (" . $new_data_cells . ") VALUES (" . $new_data_saves . ");";
  mysql_query($sql_query, $csp_connect);
  $error = mysql_error($csp_connect);
}  
if(!empty($error)) {
  echo 'Ein Fehler ist aufgetreten: ' . mysql_error($csp_connect);
  echo '<img src="../../symbols/crystal_project/16/cancel.png" width="16" height="16" alt="OK" /><br />';
} else {
  echo 'News wurden erfolgreich erstellt. <img src="../../symbols/crystal_project/16/submit.png" width="16" height="16" alt="OK" />';
}
mysql_close();
?>