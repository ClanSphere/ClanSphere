<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('install');

global $cs_db;

function cs_installerror($old_query = '') {

  global $cs_db, $cs_lang, $account;
  $cs_lang = cs_translate('install');
  $error = empty($cs_db['last_error']) ? 'Unknown' : $cs_db['last_error'];
  $msg   = 'Error: ' . $error . cs_html_br(2) . 'Query: ' . $old_query . cs_html_br(4);
  $msg  .= cs_link($cs_lang['remove_and_again'], 'install', 'sql', 'lang=' . $account['users_lang'] . '&amp;uninstall=1');
  die(cs_error_internal('sql', $msg));
}

if(!empty($_REQUEST['uninstall'])) {
  $sql_uninstall = file_get_contents('uninstall.sql');
  $sql_array = preg_split("=;[\n\r]+=",$sql_uninstall); 
  foreach($sql_array AS $sql_query) {
    cs_sql_query(__FILE__, $sql_query);
  }
  cs_redirect('','install','sql','lang=' . $account['users_lang']);
}

$sql_install = file_get_contents('install.sql');
$sql_install = str_replace('{time}',cs_time(),$sql_install);

$sql_install = str_replace('{def_lang}',$account['users_lang'],$sql_install);
$sql_install = str_replace('{guest}',$cs_lang['guest'],$sql_install);
$sql_install = str_replace('{community}',$cs_lang['community'],$sql_install);
$sql_install = str_replace('{member}',$cs_lang['member'],$sql_install);
$sql_install = str_replace('{orga}',$cs_lang['orga'],$sql_install);
$sql_install = str_replace('{admin}',$cs_lang['admin'],$sql_install);

if($cs_db['hash'] == 'md5') { 
  $sec_pwd = md5('admin');
}
elseif($cs_db['hash'] == 'sha1') { 
  $sec_pwd = sha1('admin');
}
$sql_install = str_replace('{pwd}',$sec_pwd,$sql_install);

$sql_install = cs_sql_replace($sql_install);

$sql_array = preg_split("=;[\n\r]+=",$sql_install); 
foreach($sql_array AS $sql_query) {
  $sql_query = trim($sql_query);
  if(!empty($sql_query)) {
    if (!cs_sql_query(__FILE__, $sql_query)) {
      cs_installerror($sql_query);
    }
  }
}

if(isset($_POST['module_select'])) {
  $mods = array('articles','awards','banners','board','boardmods','boardranks','buddys','cash','clans','computers','events','explorer','faq','fightus','files','gallery','games','gbook','history','joinus','links','linkus','maps','members','messages','news','newsletter','partner','quotes','ranks','replays','rules','search','servers','shoutbox','squads','static','usersgallery','votes','wars','wizard');
  $mods_count = count($mods);
  for($run=0; $run < $mods_count; $run++) {
    if(!isset($_POST[$mods[$run]])) {
    cs_sql_query(__FILE__,"UPDATE {pre}_access SET access_" . $mods[$run] . " = '0'");
    }
  }
}

cs_redirect('','install','admin','lang=' . $account['users_lang']);