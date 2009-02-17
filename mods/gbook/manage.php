<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gbook');

if(!empty($_GET['active'])) {
  cs_sql_update(__FILE__,'gbook',array('gbook_lock'),array('1'),(int) $_GET['active']);
  $_SESSION['message'] = $cs_lang['active_done'];
}
if(!empty($_GET['deactive'])) {
  cs_sql_update(__FILE__,'gbook',array('gbook_lock'),array('0'),(int) $_GET['deactive']);
  $_SESSION['message'] = $cs_lang['deactive_done'];
}


$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'gbk.gbook_time DESC';
$cs_sort[2] = 'gbk.gbook_time ASC';
$cs_sort[3] = 'usr.users_email DESC';
$cs_sort[4] = 'usr.users_email ASC';
$sort = empty($_REQUEST['sort']) ? 1 : $_REQUEST['sort'];
$order = $cs_sort[$sort];

$user_gb = empty($_POST['user_gb']) ? 0 : $_POST['user_gb'];
$id = 0;

if(!empty($user_gb)) {
  $where = "users_nick = '" . cs_sql_escape($user_gb) . "'";
  $from = 'users';
  $select = 'users_id';
  $cs_users = cs_sql_select(__FILE__,$from,$select,$where);
  $cs_users_loop = count($cs_users);
  $id = $cs_users['users_id'];
}

$where = "gbook_users_id ='" . $id . "'";
$gbook_count = cs_sql_count(__FILE__,'gbook',$where);

$data['lang']['getmsg'] = cs_getmsg();
$data['head']['mod'] = $cs_lang['mod_name'];
$data['head']['action'] = $cs_lang['manage'];
$data['head']['gbook_entry'] = cs_link($cs_lang['submit'],'gbook','entry');
$data['head']['all'] = $cs_lang['total'] . ': ';
$data['head']['gbook_count'] = $gbook_count;
$data['head']['pages'] = cs_pages('gbook','manage',$gbook_count,$start,0,$sort);
$data['head']['users_gb'] = $cs_lang['user_gb'];
$data['head']['user_gb'] = $user_gb;

$data['head']['message'] = cs_getmsg();

$from = 'gbook gbk LEFT JOIN {pre}_users usr ON gbk.users_id = usr.users_id';
$select = 'gbk.gbook_id AS gbook_id, gbk.users_id AS users_id, gbk.gbook_time AS gbook_time, gbk.gbook_nick AS gbook_nick, ';
$select .= 'gbk.gbook_email AS gbook_email, gbk.gbook_lock AS gbook_lock, ';
$select .= 'usr.users_nick AS users_nick, usr.users_email AS users_email';
$cs_gbook = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);
$gbook_loop = count($cs_gbook);

$data['sort']['email'] = cs_sort('gbook','manage',$start,0,3,$sort);
$data['sort']['time'] = cs_sort('gbook','manage',$start,0,1,$sort);
$data['lang']['time'] = $cs_lang['date'];

for($run=0; $run<$gbook_loop; $run++) {
  if($cs_gbook[$run]['users_id'] > 0) {
    $gbook[$run]['nick'] = cs_secure($cs_gbook[$run]['users_nick']);
    $gbook[$run]['email'] = cs_secure($cs_gbook[$run]['users_email']);
  } else {
    $gbook[$run]['nick'] = cs_secure($cs_gbook[$run]['gbook_nick']);
    $gbook[$run]['email'] = cs_secure($cs_gbook[$run]['gbook_email']);
  }
  $gbook[$run]['time'] = cs_date('unix',$cs_gbook[$run]['gbook_time'],1);
  $active = cs_link(cs_icon('cancel'),'gbook','manage','active=' . $cs_gbook[$run]['gbook_id'],0,$cs_lang['active']);
  $deactive = cs_link(cs_icon('submit'),'gbook','manage','deactive=' . $cs_gbook[$run]['gbook_id'],0,$cs_lang['deactive']);
  $gbook[$run]['lock'] = empty($cs_gbook[$run]['gbook_lock']) ? $active : $deactive;
    $img_edit = cs_icon('edit',16,$cs_lang['edit']);
  $gbook[$run]['edit'] = cs_link($img_edit,'gbook','edit','id=' . $cs_gbook[$run]['gbook_id'],0,$cs_lang['edit']);
  $img_del = cs_icon('editdelete',16,$cs_lang['remove']);
    $gbook[$run]['remove'] = cs_link($img_del,'gbook','remove','id=' . $cs_gbook[$run]['gbook_id'],0,$cs_lang['remove']);
  $img_ip = cs_icon('important',16,$cs_lang['ip']);
  $more = 'id=' . $cs_gbook[$run]['gbook_id'];
  $more .= '&amp;action1=' . $cs_main['action'];
    $gbook[$run]['ip'] = cs_link($img_ip,'gbook','ip',$more);
}
$data['gbook'] = !empty($gbook) ? $gbook : '';
echo cs_subtemplate(__FILE__,$data,'gbook','manage');
?>