<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');

$start = empty($_GET['start']) ? 0 : (int) $_GET['start'];
$cs_sort[1] = 'users_nick DESC';
$cs_sort[2] = 'users_nick ASC';
$cs_sort[3] = 'users_place DESC';
$cs_sort[4] = 'users_place ASC';
$cs_sort[5] = 'users_laston DESC';
$cs_sort[6] = 'users_laston ASC';
$sort = empty($_GET['sort']) ? 2 : (int) $_GET['sort'];
$order = $cs_sort[$sort];
//$where = empty($_REQUEST['where']) ? 0 : $_REQUEST['where'];
//$mof = empty($where) ? '' : " AND users_sex = '" . cs_sql_escape($where) . "'";
$where = empty($_GET['where']) ? 0 : $_GET['where'];
$mof = empty($where) ? '' : " AND users_nick LIKE '" . cs_sql_escape($where) . "%'";
$condition = 'users_delete = 0 AND users_active = 1' . $mof;
$users_count = cs_sql_count(__FILE__,'users',$condition);

$data['head']['mod'] = $cs_lang['mod_name'];
$data['head']['action'] = $cs_lang['list'];

$data['head']['total'] = $users_count;
$data['head']['pages'] = cs_pages('users','list',$users_count,$start,$where,$sort);
$sel_female = $where === 'female' ? 'selected' : '';
$data['head']['sel_female'] = $sel_female;
$sel_male = $where === 'male' ? 'selected' : '';
$data['head']['sel_male'] = $sel_male;

$data['sort']['nick'] = cs_sort('users','list',$start,$where,1,$sort);
$data['sort']['place'] = cs_sort('users','list',$start,$where,3,$sort);
$data['sort']['laston'] = cs_sort('users','list',$start,$where,5,$sort);

$select = 'users_id, users_nick, users_place, users_laston, users_country, users_hidden, users_active, users_invisible';
$cs_users = cs_sql_select(__FILE__,'users',$select,$condition,$order,$start,$account['users_limit']);
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
  $cs_users[$run]['laston'] = cs_date('unix',$cs_users[$run]['users_laston']);
  $cs_users[$run]['page'] = cs_userstatus($cs_users[$run]['users_laston'],$cs_users[$run]['users_invisible']);

}

$data['users'] = $cs_users;
echo cs_subtemplate(__FILE__,$data,'users','list');
