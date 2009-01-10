<?php
// DZCP SQL Connect
//$dzcp_connect = mysql_connect($dzcp_db['place'], $dzcp_db['user'], $dzcp_db['pwd']);
//$dzcp_database = mysql_select_db($dzcp_db['name']);

// GET Articles
//$art_query = "SELECT * FROM " . $dzcp_db['prf'] . "artikel";
//$art_data = mysql_query($art_query, $dzcp_connect);
$art_data = $mysql->query('SELECT * FROM dzcp_artikel');

$run_art = 0;
while ($art_result = $mysql->fetchRow()) { $dzcp_articles[$run_art] = $art_result; $run_art++; }
//mysql_close();

// CSP SQL Connect
//$csp_connect = mysql_connect($csp_db['place'], $csp_db['user'], $csp_db['pwd']);
//$csp_database = mysql_select_db($csp_db['name']) or mysql_error($dzcp_connect);

$data = array();
// Convert Articles Datas
for($run=0; $run<count($dzcp_articles); $run++) {
#  $where = "categories WHERE categories_mod = 'articles' AND old_id = '" . $dzcp_articles[$run]['kat'] ."' LIMIT 1";
#  $sql_query = "SELECT * FROM " . $csp_db['prf'] . $where;
#  $old_art_kat = mysql_query($sql_query , $dzcp_connect);
#  $old = mysql_fetch_assoc($old_art_kat);
  $data['art'][$run]['users_id'] = $dzcp_articles[$run]['autor'];
#  $data['art'][$run]['categories_id'] = $old['categories_id'];
  $data['art'][$run]['articles_time'] = $dzcp_articles[$run]['datum'];
  $data['art'][$run]['articles_text'] = '[html]' . $dzcp_articles[$run]['text'] . '[/html]';
  $data['art'][$run]['articles_headline'] = $dzcp_articles[$run]['titel'];  
}
echo '<pre>';
print_R($data);
echo '<pre>';

// Update Articles
/*for($run=0; $run<count($data['art']); $run++) {
  $data_cells = array_keys($data['art'][$run]);
  $data_saves = array_values($data['art'][$run]);
  $new_data_cells = '';
  $new_data_saves = '';
  for($runb=0; $runb<count($data_cells); $runb++) {
    $set = $runb == 0 ? '' : ', ';
    $new_data_cells .= $set . $data_cells[$runb];
	$new_data_saves .= $set . "'" . $data_saves[$runb] . "'";
  }
  $sql_query = "INSERT INTO " . $csp_db['prf'] . "articles (" . $new_data_cells . ") VALUES (" . $new_data_saves . ");";
  mysql_query($sql_query, $csp_connect);
  $error = mysql_error($csp_connect);
}  
if(!empty($error)) {
  echo 'Ein Fehler ist aufgetreten: ' . mysql_error($csp_connect);
  echo '<img src="../../symbols/crystal_project/16/cancel.png" width="16" height="16" alt="OK" /><br />';
} else {
  echo 'Artikel wurden erfolgreich erstellt. <img src="../../symbols/crystal_project/16/submit.png" width="16" height="16" alt="OK" />';
}
mysql_close();*/

?>