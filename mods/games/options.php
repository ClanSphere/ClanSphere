<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('games');

if (!empty($_POST['submit'])) {
  
  $save = array();
  $save['max_width'] = (int) $_POST['max_width'];
  $save['max_height'] = (int) $_POST['max_height'];
  $save['max_size'] = (int) $_POST['max_size'];
  
  require_once 'mods/clansphere/func_options.php';
  cs_optionsave('games', $save);
  
  cs_redirect($cs_lang['success'], 'options','roots');
  
}

$data = array();
$data['op'] = cs_sql_option(__FILE__, 'games');

echo cs_subtemplate(__FILE__, $data, 'games', 'options');