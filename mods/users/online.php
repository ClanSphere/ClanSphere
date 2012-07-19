<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');

$start = empty($_REQUEST['start']) ? 0 : (int) $_REQUEST['start'];
$cs_sort[1] = 'users_nick DESC';
$cs_sort[2] = 'users_nick ASC';
$cs_sort[3] = 'users_place DESC';
$cs_sort[4] = 'users_place ASC';
$cs_sort[5] = 'users_laston DESC';
$cs_sort[6] = 'users_laston ASC';
$sort = empty($_REQUEST['sort']) ? 2 : (int) $_REQUEST['sort'];
$order = $cs_sort[$sort];

$five_min = cs_time() - 300;
$upcome = "users_laston > '" . $five_min . "'";
$users_count = cs_sql_count(__FILE__,'users',$upcome);

$data['head']['mod'] = $cs_lang['mod_name'];
$data['head']['action'] = $cs_lang['online'];
$data['head']['body'] = sprintf($cs_lang['count_users'], $users_count);

$data['head']['total'] = $users_count;
$data['head']['pages'] = cs_pages('users','online',$users_count,$start,0,$sort);

$data['sort']['nick'] = cs_sort('users','online',$start,0,1,$sort);
$data['sort']['place'] = cs_sort('users','online',$start,0,3,$sort);
$data['sort']['laston'] = cs_sort('users','online',$start,0,5,$sort);

$select = 'users_id,users_nick,users_place,users_laston,users_country,users_hidden,users_active';
$cs_users = cs_sql_select(__FILE__,'users',$select,$upcome,$order,$start,$account['users_limit']);
$users_loop = count($cs_users);

for($run=0; $run<$users_loop; $run++) {

  $cs_users[$run]['country'] = cs_html_img('symbols/countries/' . $cs_users[$run]['users_country'] . '.png');
  $cs_users[$run]['users_id'] = cs_secure($cs_users[$run]['users_id']);
  $cs_users[$run]['nick'] = cs_user($cs_users[$run]['users_id'], $cs_users[$run]['users_nick'], $cs_users[$run]['users_active']);
  $content = cs_secure($cs_users[$run]['users_place']);
  $hidden = explode(',',$cs_users[$run]['users_hidden']);
  if(in_array('users_place',$hidden)) {
    $content = ($account['access_users'] > 4 OR $cs_users[$run]['users_id'] == $account['users_id']) ?
      cs_html_italic(1) . $content . cs_html_italic(0) : '';
  }
  $cs_users[$run]['place'] = $content;
  $cs_users[$run]['laston'] = cs_date('unix',$cs_users[$run]['users_laston'],1,1);
}

$data['users'] = $cs_users;

echo cs_subtemplate(__FILE__,$data,'users','online');
