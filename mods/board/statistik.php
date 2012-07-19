<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

// Statistik Start
$data = array();

$all_threads = cs_sql_count(__FILE__,'threads');
$all_comment = cs_sql_count(__FILE__,'comments',"comments_mod = 'board'");

$data['stats']['threads'] = cs_html_big(1) . $all_threads . cs_html_big(0);
$data['stats']['comments'] = cs_html_big(1) . $all_comment . cs_html_big(0);

$select = 'users_id, users_nick, users_register, users_active';
$order = 'users_register DESC';
$cs_users = cs_sql_select(__FILE__,'users',$select,'users_delete = 0 AND users_active = 1',$order,0,1);

$secure_name = cs_secure($cs_users['users_nick']);
$data['user']['newest'] = cs_user($cs_users['users_id'],$cs_users['users_nick'], $cs_users['users_active']);
// Statistik End

// All Users Start
$data['user']['all'] = cs_sql_count(__FILE__,'users', 'users_delete = 0 AND users_active = 1');
// All Users End

// Online Users Start
$five_min = cs_time() - 300;
$select = 'users_id, users_nick, users_country, users_active, users_invisible, users_delete';
$upcome = "users_laston > '" . $five_min . "' AND users_invisible = '0'";
$order = 'users_laston DESC';
$users_count = cs_sql_count(__FILE__,'users',$upcome);
$data['stats']['online'] = sprintf($cs_lang['user_online'], $users_count);
$where = 'count_time > \'' . $five_min . '\'';
$visitor_online = cs_sql_count(__FILE__,'count',$where) - $users_count;
if($visitor_online < 0) { $visitor_online = 0; }
$data['stats']['online'] .= sprintf($cs_lang['visitor_online'], $visitor_online);
$cs_users = cs_sql_select(__FILE__,'users',$select,$upcome,$order,0,0);

if(empty($cs_users)) {
  $data['users'][0]['nick'] = $cs_lang['no_data'];
} else {
  for($run = 0; $run < count($cs_users); $run++) {
    if($run != 0) {
  $data['users'][$run]['nick'] = ', ';
  }
  else {
  $data['users'][$run]['nick'] = '';
  }
  $data['users'][$run]['nick'] .= cs_html_img('symbols/countries/' . $cs_users[$run]['users_country'] . '.png') . ' ';
    $data['users'][$run]['nick'] .= cs_user($cs_users[$run]['users_id'], $cs_users[$run]['users_nick'], $cs_users[$run]['users_active'], $cs_users[$run]['users_delete']);
  }
}
// Online Users End
$data['if']['list'] = false;
$data['if']['listcat'] = false;
if(empty($_GET['action']) OR $_GET['action'] == 'list') { $data['if']['list'] = true; }
if(!empty($_GET['action']) AND $_GET['action'] == 'listcat') { $data['if']['listcat'] = true; }
echo cs_subtemplate(__FILE__,$data,'board','statistik');
