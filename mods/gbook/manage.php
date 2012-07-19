<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gbook');
$cs_post = cs_post('where,start,sort');
$cs_get = cs_get('where,start,sort');
$data = array();

if(!empty($_GET['active'])) {
  cs_sql_update(__FILE__,'gbook',array('gbook_lock'),array('1'),(int) $_GET['active']);
  cs_redirectmsg($cs_lang['active_done']);
}
if(!empty($_GET['deactive'])) {
  cs_sql_update(__FILE__,'gbook',array('gbook_lock'),array('0'),(int) $_GET['deactive']);
  cs_redirectmsg($cs_lang['deactive_done']);
}

$id = empty($cs_get['where']) ? 0 : $cs_get['where'];
if (!empty($cs_post['where']))  $id = $cs_post['where'];
$start = empty($cs_get['start']) ? 0 : $cs_get['start'];
if (!empty($cs_post['start']))  $start = $cs_post['start'];
$sort = empty($cs_get['sort']) ? 1 : $cs_get['sort'];
if (!empty($cs_post['sort']))  $sort = $cs_post['sort'];

$cs_sort[1] = 'gbk.gbook_time DESC';
$cs_sort[2] = 'gbk.gbook_time ASC';
$cs_sort[3] = 'usr.users_email DESC';
$cs_sort[4] = 'usr.users_email ASC';
$order = $cs_sort[$sort];

$user_gb = empty($_POST['user_gb']) ? 0 : $_POST['user_gb'];
if(empty($user_gb)) {
  $user_gb = empty($_GET['user_gb']) ? 0 : $_GET['user_gb'];
}

if(!empty($user_gb)) {
  $where = "users_nick = '" . cs_sql_escape($user_gb) . "'";
  $cs_user = cs_sql_select(__FILE__,'users','users_id',$where);
  $id = $cs_user['users_id'];
}

$where = "gbook_users_id ='" . $id . "'";
$gbook_count = cs_sql_count(__FILE__,'gbook',$where);


$data['head']['count'] = $gbook_count;
$data['head']['pages'] = cs_pages('gbook','manage',$gbook_count,$start,$id,$sort);
$data['head']['user_gb'] = empty($user_gb) ? '' : $user_gb;
$data['head']['getmsg'] = cs_getmsg();

$data['sort']['email'] = cs_sort('gbook','manage',$start,$id,3,$sort);
$data['sort']['time'] = cs_sort('gbook','manage',$start,$id,1,$sort);

$from = 'gbook gbk LEFT JOIN {pre}_users usr ON gbk.users_id = usr.users_id';
$select = 'gbk.gbook_id AS gbook_id, gbk.users_id AS users_id, gbk.gbook_time AS gbook_time, gbk.gbook_nick AS gbook_nick, ';
$select .= 'gbk.gbook_email AS gbook_email, gbk.gbook_lock AS gbook_lock, gbk.gbook_ip AS gbook_ip, ';
$select .= 'usr.users_nick AS users_nick, usr.users_email AS users_email';
$cs_gbook = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);
$gbook_loop = count($cs_gbook);

for($run=0; $run<$gbook_loop; $run++) {
  if($cs_gbook[$run]['users_id'] > 0) {
    $gbook[$run]['nick'] = cs_secure($cs_gbook[$run]['users_nick']);
    $gbook[$run]['email'] = cs_secure($cs_gbook[$run]['users_email']);
  } else {
    $gbook[$run]['nick'] = cs_secure($cs_gbook[$run]['gbook_nick']);
    $gbook[$run]['email'] = cs_secure($cs_gbook[$run]['gbook_email']);
  }
  $gbook[$run]['time'] = cs_date('unix',$cs_gbook[$run]['gbook_time'],1);
  if(empty($user_gb)) {
    $active = cs_link(cs_icon('cancel'),'gbook','manage','active=' . $cs_gbook[$run]['gbook_id'],0,$cs_lang['active']);
    $deactive = cs_link(cs_icon('submit'),'gbook','manage','deactive=' . $cs_gbook[$run]['gbook_id'],0,$cs_lang['deactive']);
  }
  else {
    $active = cs_link(cs_icon('cancel'),'gbook','manage','active=' . $cs_gbook[$run]['gbook_id'] . '&amp;user_gb=' . $user_gb,0,$cs_lang['active']);
    $deactive = cs_link(cs_icon('submit'),'gbook','manage','deactive=' . $cs_gbook[$run]['gbook_id'] . '&amp;user_gb=' . $user_gb,0,$cs_lang['deactive']);
  }
  $gbook[$run]['lock'] = empty($cs_gbook[$run]['gbook_lock']) ? $active : $deactive;
    $gbook[$run]['id'] = $cs_gbook[$run]['gbook_id'];

  $gbook[$run]['ip'] = '';
  if($account['access_gbook'] >= 4) {
    $ip = $cs_gbook[$run]['gbook_ip'];
    if($account['access_gbook'] == 4) {
      $last = strlen(substr(strrchr ($cs_gbook[$run]['gbook_ip'], '.'), 1 ));
      $ip = strlen($gbook_ip);
      $ip = substr($gbook_ip,0,$ip-$last);
      $ip = $ip . '*';
    }
    $ip_show = empty($ip) ? '-' : $ip;
    $gbook[$run]['ip'] = cs_html_img('symbols/' . $cs_main['img_path'] . '/16/important.' . $cs_main['img_ext'],16,16,'title="'. $ip_show .'"');
  }

}

$data['gbook'] = !empty($gbook) ? $gbook : '';
echo cs_subtemplate(__FILE__,$data,'gbook','manage');