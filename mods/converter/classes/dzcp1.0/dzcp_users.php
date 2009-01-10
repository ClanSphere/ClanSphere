<?php
// DZCP SQL Connect
$dzcp_connect = mysql_connect($dzcp_db['place'], $dzcp_db['user'], $dzcp_db['pwd']);
$dzcp_database = mysql_select_db($dzcp_db['name']);

$sql_query = "SELECT * FROM " . $dzcp_db['prf'] . "users";
$sql_data = mysql_query($sql_query, $dzcp_connect);

$run_ = 0;
while ($sql_result = mysql_fetch_assoc($sql_data)) { $dzcp_users[$run_] = $sql_result; $run_++; }
mysql_close();

$data = array();
for($run=0; $run<count($dzcp_users); $run++) {
  $dzcp_users[$run]['level'] = $dzcp_users[$run]['level'] == '0' ? 0 : $dzcp_users[$run]['level'] + 1;
  $data[$run]['access_id'] = $dzcp_users[$run]['level'];
  $data[$run]['users_nick'] = $dzcp_users[$run]['nick'];
  $data[$run]['users_pwd'] = $dzcp_users[$run]['pwd'];
  $name = empty($dzcp_users[$run]['rlname']) ? 0 : explode(" ", $dzcp_users[$run]['rlname']);
  $data[$run]['users_name'] = empty($name) ?  '' : $name[0];
  $data[$run]['users_surname'] = empty($name) ?  '' : $name[1];
  $sex = $dzcp_users[$run]['sex'] == '1' ? 'male' : 'female';
  $sex = $dzcp_users[$run]['sex'] == '0' ? '' : $sex;
  $data[$run]['users_sex'] = $sex;
  if(!empty($dzcp_users[$run]['bday'])) {
    $date = explode(".", $dzcp_users[$run]['bday']);
    $data[$run]['users_age'] = $date[2] . '-' . $date[1] . '-' .$date[0];
  } else {
    $data[$run]['users_age'] = '';
  }
  $data[$run]['users_height'] = 0;
  $data[$run]['users_lang'] = 'German';
  $data[$run]['users_country'] = $dzcp_users[$run]['country'];
  $data[$run]['users_postalcode'] = '';
  $data[$run]['users_place'] = $dzcp_users[$run]['city'];
  $data[$run]['users_adress'] = '';
  $data[$run]['users_icq'] = $dzcp_users[$run]['icq'];    
  $data[$run]['users_msn'] = '';
  $data[$run]['users_skype'] = '';
  $data[$run]['users_email'] = $dzcp_users[$run]['email'];
  $data[$run]['users_url'] = $dzcp_users[$run]['hp'];
  $data[$run]['users_phone'] = '';
  $data[$run]['users_mobile'] = '';
  $data[$run]['users_active'] = $data[$run]['access_id'] == '0' ? '0' : '1';
  $data[$run]['users_limit'] = '20';
  $data[$run]['users_view'] = '';
  $data[$run]['users_register'] = $dzcp_users[$run]['regdatum'];
  $data[$run]['users_laston'] = $dzcp_users[$run]['time']; 
  $data[$run]['users_picture'] = '';
  $data[$run]['users_avatar'] = '';
  $data[$run]['users_signature'] = '';
  $data[$run]['users_info'] = $dzcp_users[$run]['beschreibung']; 
  $data[$run]['users_timezone'] = '7200';
  $data[$run]['users_dstime'] = '0';  
  $data[$run]['users_hidden'] = '0';
  $data[$run]['users_regkey'] = '0';  
  $data[$run]['users_homelimit'] = '8';  
  $data[$run]['users_readtime'] = '0';    
}

// CSP SQL Connect
$csp_connect = mysql_connect($csp_db['place'], $csp_db['user'], $csp_db['pwd']);
$csp_database = mysql_select_db($csp_db['name']) or mysql_error();

// Delete exists datas
$sql_query = 'TRUNCATE ' . $csp_db['prf'] . 'users;';
mysql_query($sql_query, $csp_connect) or mysql_error($csp_connect);
for($run=0; $run<count($data); $run++) {
  $data_cells = array_keys($data[$run]);
  $data_saves = array_values($data[$run]);
  $new_data_cells = '';
  $new_data_saves = '';
  for($runb=0; $runb<count($data_cells); $runb++) {
    $set = $runb == 0 ? '' : ', ';
    $new_data_cells .= $set . $data_cells[$runb];
	$new_data_saves .= $set . "'" . $data_saves[$runb] . "'";
  }
  $sql_query = "INSERT INTO " . $csp_db['prf'] . "users (" . $new_data_cells . ") VALUES (" . $new_data_saves . ");";
  $result = mysql_query($sql_query, $csp_connect);
  $error = mysql_error($csp_connect);
}  
 if(!empty($error)) {
    echo 'Ein Fehler ist aufgetreten: ' . mysql_error($csp_connect) . '<br />';
  } else {
    echo 'User Daten wurden erfolgreich kopiert. <img src="../../symbols/crystal_project/16/submit.png" width="16" height="16" alt="OK" />';
  }
mysql_close();
?>