<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

# Overwrite global settings by using the following array
$cs_main = array('init_sql' => true, 'init_tpl' => false, 'init_mod' => true);

chdir('../../');

require_once 'system/core/functions.php';

cs_init($cs_main);

$term = empty($_GET['term']) ? '' : $_GET['term'];

# Mods like messages support multiple users and that must be considered
$term_array = explode(';', $term);
$current = is_array($term_array) ? end($term_array) : $term;

# Strip current search term from search_users content
$old = substr($term, 0, strlen($term) - strlen($current));

if(!empty($current)) {

  $data = array();
  $data['data']['old'] = htmlspecialchars($old);
  $data['data']['target'] = empty($_GET['target']) ? 'users_nick' : $_GET['target'];

  $alike = cs_sql_escape($current);
  $where = "users_active = 1 AND users_delete = 0 AND (users_nick LIKE '%"
         . $alike . "%' OR users_name LIKE '%" . $alike . "%' OR users_surname LIKE '%"
         . $alike . "%' OR users_email LIKE '%" . $alike . "%')";
  $cells = 'users_nick, users_name, users_surname, users_email';
  $data['result'] = cs_sql_select(__FILE__, 'users', $cells, $where, 0, 0, 5);

  if(!empty($data['result']))
    echo cs_subtemplate(__FILE__, $data, 'ajax', 'search_users');
}