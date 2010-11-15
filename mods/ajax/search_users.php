<?php
// ClanSphere 2010 - www.clansphere.net
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

  $where = "users_nick LIKE '%" . cs_sql_escape(trim($current)) . "%' AND users_active = 1 AND users_delete = 0";
  $data['result'] = cs_sql_select(__FILE__, 'users', 'users_nick', $where, 0, 0, 7);

  if(!empty($data['result'])) {

    $loop = count($data['result']);
    for($run = 0; $run < $loop; $run++) {
      $data['result'][$run]['users_nick'] = cs_secure($data['result'][$run]['users_nick']);
    }
    echo cs_subtemplate(__FILE__, $data, 'ajax', 'search_users');
  }
}