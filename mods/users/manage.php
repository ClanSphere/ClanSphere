<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');

$letter = empty($_REQUEST['where']) ? 0 : $_REQUEST['where'];
$search_name = empty($_POST['search_name']) ? 0 : $_POST['search_name'];
$data['search']['name'] = empty($_POST['search_name']) ? '' : $_POST['search_name'];
settype($access_id, 'integer');
$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'users_nick DESC';
$cs_sort[2] = 'users_nick ASC';
$cs_sort[3] = 'users_laston DESC';
$cs_sort[4] = 'users_laston ASC';
$cs_sort[5] = 'users_active DESC';
$cs_sort[6] = 'users_active ASC';
$cs_sort[7] = 'access_id ASC';
$cs_sort[8] = 'access_id DESC';
$sort = empty($_REQUEST['sort']) ? 2 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$where = "users_delete = '0'";
$where = empty($letter) ? $where : "users_delete = '0' AND users_nick LIKE '" . cs_sql_escape($letter) . "%'";
$where = empty($search_name) ? $where : "users_delete = '0' AND users_nick LIKE '%" . cs_sql_escape($search_name) . "%'"; 
$users_count = cs_sql_count(__FILE__, 'users', $where);

$data['head']['total'] = $users_count;
$data['head']['pages'] = cs_pages('users', 'manage', $users_count, $start, $letter, $sort);
$data['url']['form'] = cs_url('users', 'manage');

$data['head']['message'] = cs_getmsg();

$data['sort']['nick'] = cs_sort('users', 'manage', $start, $access_id, 1, $sort);
$data['sort']['laston'] = cs_sort('users', 'manage', $start, $access_id, 3, $sort);
$data['sort']['active'] = cs_sort('users', 'manage', $start, $access_id, 5, $sort);
$data['sort']['access'] = cs_sort('users', 'manage', $start, $access_id, 7, $sort);

$select = 'users_id, users_nick, users_laston, users_country, users_active, users_delete, users_invisible, access_id';
$cs_users = cs_sql_select(__FILE__, 'users', $select, $where, $order, $start, $account['users_limit']);
$users_loop = count($cs_users);

for ($run = 0; $run < $users_loop; $run++) {
  $cs_users[$run]['country'] = empty($cs_users[$run]['users_country']) ? 'symbols/countries/fam.png' : 'symbols/countries/' . $cs_users[$run]['users_country'] . '.png';
  $cs_users[$run]['nick'] = cs_user($cs_users[$run]['users_id'], $cs_users[$run]['users_nick'], $cs_users[$run]['users_active'], $cs_users[$run]['users_delete']);
  $cs_users[$run]['laston'] = cs_date('unix', $cs_users[$run]['users_laston']);
  $cs_users[$run]['page'] = cs_userstatus($cs_users[$run]['users_laston'],$cs_users[$run]['users_invisible']);
  $cs_users[$run]['active'] = cs_secure($cs_users[$run]['users_active']);
  $cs_users_access = cs_sql_select(__FILE__, 'access', 'access_id, access_name', "access_id = " . $cs_users[$run]['access_id'], 0, 0, 1);
  $cs_users[$run]['access'] = $cs_users_access['access_name'];
  $cs_users[$run]['url_delete'] = cs_url('users', 'remove', 'id=' . $cs_users[$run]['users_id']);
  $cs_users[$run]['url_edit'] = cs_url('users', 'edit', 'id=' . $cs_users[$run]['users_id']);
  $cs_users[$run]['url_view'] = cs_url('users', 'view', 'id=' . $cs_users[$run]['users_id']);
  $cs_users[$run]['url_picture'] = cs_url('users', 'picture_edit', 'id=' . $cs_users[$run]['users_id']);
  $cs_users[$run]['active'] = !empty($cs_users[$run]['active']) ? $cs_lang['yes'] : $cs_lang['no'];
}

$data['users'] = $cs_users;
echo cs_subtemplate(__FILE__, $data, 'users', 'manage');