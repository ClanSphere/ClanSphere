<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

global $com_lang, $cs_logs, $cs_main;

$files = cs_files();

$req_order = '$_REQUEST (' . ini_get('variables_order') . ')';
$get_count = '$_GET (' . count($_GET) . ')';
$post_count = '$_POST (' . count($_POST) . ')';
$cookie_count = '$_COOKIE (' . count($_COOKIE) . ')';
$session_count = '$_SESSION (' . count($_SESSION) . ')';
$files_count = '$_FILES (' . count($files) . ')';
$com_count = '$com_lang (' . count($com_lang) . ')';
$main_count = '$cs_main (' . count($cs_main) . ')';
$logs_count = '$cs_logs (' . count($cs_logs) . ')';
$acc_count = '$account (' . count($account) . ')';

$arrays[$req_order] = $_REQUEST;
$arrays[$get_count] = $_GET;
$arrays[$post_count] = $_POST;
$arrays[$cookie_count] = $_COOKIE;
$arrays[$session_count] = $_SESSION;
$arrays[$files_count] = $files;
$arrays[$com_count] = $com_lang;
$arrays[$main_count] = $cs_main;
$arrays[$logs_count] = $cs_logs;
$arrays[$acc_count] = $account;

foreach($arrays AS $name => $content) {
  $matches = array(1 => $name, 2 => '');
  
  foreach($content AS $key => $value) {
    if(is_array($value)) {
      $content = 'Array';
    }
    else {
      $content = is_int($value) ? $value : "'" . $value . "'";
    }
    $matches[2] .= '[\'' . $key . '\'] = ' . htmlentities($content, ENT_QUOTES, $cs_main['charset']) . cs_html_br(1);
  }
  
  echo cs_abcode_clip($matches);
  echo cs_html_br(1);
}