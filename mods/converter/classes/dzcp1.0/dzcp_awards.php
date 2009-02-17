<?php
// DZCP SQL Connect
$dzcp_connect = mysql_connect($dzcp_db['place'], $dzcp_db['user'], $dzcp_db['pwd']);
$dzcp_database = mysql_select_db($dzcp_db['name']);

// GET Awards
$awards_query = "SELECT * FROM " . $dzcp_db['prf'] . "awards";
$awards_data = mysql_query($awards_query, $dzcp_connect);

$run_awards = 0;
while ($awards_result = mysql_fetch_assoc($awards_data)) { $dzcp_awards[$run_awards] = $awards_result; $run_awards++; }
mysql_close();

$data = array();
// Convert Awards
for($run=0; $run<count($dzcp_awards); $run++) {
  $data['awards'][$run]['users_id'] = '1';
  $data['awards'][$run]['awards_rank'] = $dzcp_awards[$run]['place'];
  $data['awards'][$run]['awards_time'] = $dzcp_awards[$run]['date'];
  $data['awards'][$run]['awards_event'] = $dzcp_awards[$run]['event'];
  $data['awards'][$run]['awards_event_url'] = $dzcp_awards[$run]['url'];
}

// CSP SQL Connect
$csp_connect = mysql_connect($csp_db['place'], $csp_db['user'], $csp_db['pwd']);
$csp_database = mysql_select_db($csp_db['name']) or mysql_error($dzcp_connect);

// Create Categorie for Games
$sql_query = "INSERT INTO " . $csp_db['prf'] . "categories (categories_mod, categories_name, old_id) VALUES ('games','DZCP Award-Game EDIT ME','999');";
mysql_query($sql_query, $csp_connect);

// Create Game for Awards
$values = "'" . mysql_insert_id($csp_connect) . "', 'Award-Game EDIT ME', '1'";
$sql_query = "INSERT INTO " . $csp_db['prf'] . "games (categories_id, games_name, games_version) VALUES (" . $values . ");";
mysql_query($sql_query, $csp_connect);
$last_id = mysql_insert_id($csp_connect);

// Update Awards
for($run=0; $run<count($data['awards']); $run++) {
  $data['awards'][$run]['games_id'] = $last_id;
  $data_cells = array_keys($data['awards'][$run]);
  $data_saves = array_values($data['awards'][$run]);
  $new_data_cells = '';
  $new_data_saves = '';
  for($runb=0; $runb<count($data_cells); $runb++) {
    $set = $runb == 0 ? '' : ', ';
    $new_data_cells .= $set . $data_cells[$runb];
  $new_data_saves .= $set . "'" . $data_saves[$runb] . "'";
  }
  $sql_query = "INSERT INTO " . $csp_db['prf'] . "awards (" . $new_data_cells . ") VALUES (" . $new_data_saves . ");";
  mysql_query($sql_query, $csp_connect);
  $error = mysql_error($csp_connect);
}  
if(!empty($error)) {
  echo 'Ein Fehler ist aufgetreten: ' . mysql_error($csp_connect);
  echo '<img src="../../symbols/crystal_project/16/cancel.png" width="16" height="16" alt="OK" /><br />';
} else {
  echo 'Awards wurden erfolgreich erstellt. <img src="../../symbols/crystal_project/16/submit.png" width="16" height="16" alt="OK" />';
}
mysql_close();

?>