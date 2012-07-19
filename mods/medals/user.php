<?php

$cs_lang = cs_translate('medals');
$data = array();

if(isset($_POST['submit'])) {
  $medals_id = $_POST['medals_id'];
  if(!empty($_POST['users_nick'])) {
    $users_nick = cs_sql_escape($_POST['users_nick']);
    $users_id = cs_sql_select(__FILE__,'users','users_id',"users_nick = '$users_nick'",0,0,1);
  if($users_id > 0) {
    $insertion = array('medals_id' => $medals_id, 'users_id' => $users_id['users_id'], 'medalsuser_date' => cs_time());
    cs_sql_insert(__FILE__, 'medalsuser', array_keys($insertion), array_values($insertion)); 
    cs_redirect($cs_lang['create_done'], 'medals', 'user', 'where='.$medals_id);
  }
  else cs_redirect($cs_lang['user_not_found'], 'medals', 'user', 'where='.$medals_id);
  }
} else {
  $medals_id = $_GET['where'];
}

if(isset($_GET['delete'])) {
  $medalsuser_id = cs_sql_escape($_GET['delete']);
  cs_sql_delete(__FILE__,'medalsuser',$medalsuser_id);
  cs_redirect($cs_lang['del_true'], 'medals', 'user', 'where='.$medals_id);
}

$start = empty($_GET['start']) ? 0 : $_GET['start'];
$cs_sort[1] = 'md.medalsuser_date DESC';
$cs_sort[2] = 'md.medalsuser_date ASC';
$cs_sort[3] = 'usr.users_nick DESC';
$cs_sort[4] = 'usr.users_nick ASC';
$sort = empty($_GET['sort']) ? 1 : $_GET['sort'];
$order = $cs_sort[$sort];

$tables = 'medalsuser md LEFT JOIN {pre}_users usr ON usr.users_id = md.users_id';
$cells  = 'usr.users_nick AS users_nick, md.users_id AS users_id, usr.users_active AS users_active, usr.users_delete AS users_delete, ';
$cells .= 'md.medals_id AS medals_id, md.medalsuser_date AS medalsuser_date, md.medalsuser_id AS medalsuser_id';
$where = 'medals_id = '.$medals_id.'';

$data['medals_user'] = array();

$data['medals_user'] = cs_sql_select(__FILE__,$tables,$cells,$where,$order,$start,$account['users_limit']);
$data['count']['medals_user'] = count($data['medals_user']);
$data['count']['all_medals_user'] = cs_sql_count(__FILE__, 'medalsuser',$where);

$data['sort']['date'] = cs_sort('medals','user',$start,$medals_id,1,$sort);
$data['sort']['users_nick'] = cs_sort('medals','user',$start,$medals_id,3,$sort);

$data['pages']['list'] = cs_pages('medals','user',$data['count']['all_medals_user'],$start,$medals_id,$sort);

for ($i = 0; $i < $data['count']['medals_user']; $i++) {
  
  $data['medals_user'][$i]['user'] = cs_user($data['medals_user'][$i]['users_id'], $data['medals_user'][$i]['users_nick'], $data['medals_user'][$i]['users_active'], $data['medals_user'][$i]['users_delete']);
  $data['medals_user'][$i]['remove_url'] = cs_url('medals','user','where=' . $data['medals_user'][$i]['medals_id'].'&delete=' . $data['medals_user'][$i]['medalsuser_id']);
  $data['medals_user'][$i]['medals_date'] = cs_date('unix',$data['medals_user'][$i]['medalsuser_date'],1);
}

$data['medals']['id'] = $medals_id;
$data['message']['medals'] = cs_getmsg();
$data['form']['dirname'] = $cs_main['php_self']['dirname'];

echo cs_subtemplate(__FILE__,$data,'medals','user');