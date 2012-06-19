<?php
//Andrew Tajsic - 2011

$data = array();

$data['alert']['query'] = "";
$data['if']['session_exists'] = false;
$data['alert']['session_exists'] = "";

if(isset($_POST['session_id'])){
	$sessionid = (int) cs_secure($_POST['session_id']);
	$userid = (int) $account['users_id'];
	
	//first check if the ID belongs to whom is logged in
	$session_where = "users_id = " . $userid . " AND sessions_id= '" . $sessionid . "'";
	$session_db_count = cs_sql_count(__FILE__, 'sessions', $session_where);
	
	if($session_db_count != 0){
		//remove record if it passed.
		$query = "DELETE FROM {pre}_sessions WHERE users_id = " . $userid . " AND sessions_id = " . $sessionid;
		cs_sql_query(__FILE__, $query);
		$data['query']['alert'] = "Login successfully removed.";
	}
	else{
		$data['query']['alert'] = "Login session was not found - or does not belong to you.";
	}
}


//View for page
$from = 'sessions';
$select = '*';
$order = 'sessions_cookietime DESC';
$where = 'users_id = ' . $account['users_id'];;
$sessions = cs_sql_select(__FILE__, $from, $select, $where, $order, 0, 0);

$count = count($sessions);
$final = array("");
if($count > 0){
	$data['if']['session_exists'] = true;
	for($run = 0; $run < $count; $run++){
		$final[$run]['num'] = $run + 1;
		$final[$run]['id'] = $sessions[$run]['sessions_id'];
		$final[$run]['time'] = cs_date("unix", (int) $sessions[$run]['sessions_cookietime']);
		$final[$run]['ip'] = $sessions[$run]['sessions_ip'];
		$final[$run]['color'] = "";
	
		if(!empty($_COOKIE['cs_cookiehash'])){
			$saved = $sessions[$run]['sessions_cookiehash'];
			$cookie = $_COOKIE['cs_cookiehash'];
			if($saved == $cookie){
				$final[$run]['color'] = "background-color: #5d2d2d";
			}
		}
	}
}
else{
	$data['alert']['session_exists'] = "<br />You currently have no login sessions saved.";
}

$data['sessions'] = $final;

echo cs_subtemplate(__FILE__,$data,'sessions','list');