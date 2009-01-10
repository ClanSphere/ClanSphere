<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('install');

$data = array();

$ok = array();
$ok[0] = cs_icon('stop');
$ok[1] = cs_html_img('symbols/crystal_project/16/submit.png');#cs_icon('submit');

$switch = array();
$switch[0] = $cs_lang['off'];
$switch[1] = $cs_lang['on'];

$check_required = true;

$data['rq']['php'] = '4.3.0';
$data['av']['php'] = phpversion();
$data['ok']['php'] = $ok[version_compare($data['av']['php'],$data['rq']['php'],'>=')];
if ($data['ok']['php'] != $ok[1]) { $check_required = false; }

$data['rq']['upload'] = $cs_lang['on'];
$data['av']['upload'] = $switch[ini_get('file_uploads')];
$data['ok']['upload'] = $ok[$data['av']['upload'] == $switch[1]];
if ($data['ok']['upload'] != $ok[1]) { $check_required = false; }

$dba_pool = array('mssql', 'mysql', 'mysqli', 'pdo_mysql', 'pdo_pgsql', 'pdo_sqlite', 'pgsql', 'sqlite');
$data['rq']['database'] = '';
$data['av']['database'] = '';
foreach ($dba_pool AS $dba_ex) {
  $data['rq']['database'] .= $dba_ex . ', ';
  if (extension_loaded($dba_ex)) { $data['av']['database'] .= $dba_ex . ', '; }
}
$data['rq']['database'] = @substr($data['rq']['database'],0,-2);
$data['av']['database'] = @substr($data['av']['database'],0,-2);
$data['ok']['database'] = $ok[!empty($data['av']['database'])];
if ($data['ok']['database'] != $ok[1]) { $check_required = false; }

$data['data']['ok'] = $ok[1];

$check_recommended = true;

$data['rc']['php'] = '5.2.0';
$comparison = version_compare($data['av']['php'],$data['rc']['php'],'>=');
if (empty($comparison)) { $data['av']['php'] = cs_html_div(1,'color:#B91F1D') . $data['av']['php'] . cs_html_div(0); $check_recommended = 0;}

$data['rc']['register_globals'] = $switch[0];
$data['av']['register_globals'] = $switch[(int) ini_get('register_globals')];
if ($data['av']['register_globals'] != $data['rc']['register_globals']) { $data['av']['register_globals'] = cs_html_div(1,'color:#B91F1D') . $data['av']['register_globals'] . cs_html_div(0); $check_recommended = 0; }

$data['rc']['magic_quotes'] = $switch[0];
$data['av']['magic_quotes'] = $switch[(int) ini_get('magic_quotes_gpc')];
if ($data['av']['magic_quotes'] != $data['rc']['magic_quotes']) { $data['av']['magic_quotes'] = cs_html_div(1,'color:#B91F1D') . $data['av']['magic_quotes'] . cs_html_div(0); $check_recommended = 0; }

$data['rc']['safe_mode'] = $switch[0];
$data['av']['safe_mode'] = $switch[(int) ini_get('safe_mode')];
if ($data['av']['safe_mode'] != $data['rc']['safe_mode']) { $data['av']['safe_mode'] = cs_html_div(1,'color:#B91F1D') . $data['av']['safe_mode'] . cs_html_div(0); $check_recommended = 0; }

$data['rc']['trans_sid'] = $switch[0];
$data['av']['trans_sid'] = $switch[(int) ini_get('session.use_trans_sid')];
if ($data['av']['trans_sid'] != $data['rc']['trans_sid']) { $data['av']['trans_sid'] = cs_html_div(1,'color:#B91F1D') . $data['av']['trans_sid'] . cs_html_div(0); $check_recommended = 0; }

$data['rc']['basedir'] = $switch[1];
$basedir = ini_get('open_basedir');
$basedir = empty($basedir) ? 0 : 1;
$data['av']['basedir'] = $switch[$basedir];
if ($data['av']['basedir'] != $data['rc']['basedir']) { $data['av']['basedir'] = cs_html_div(1,'color:#B91F1D') . $data['av']['basedir'] . cs_html_div(0); $check_recommended = 0; }

$data['rc']['fopen'] = $switch[1];
$data['av']['fopen'] = $switch[(int) ini_get('allow_url_fopen')];
if ($data['av']['fopen'] != $data['rc']['fopen']) { $data['av']['fopen'] = cs_html_div(1,'color:#B91F1D') . $data['av']['fopen'] . cs_html_div(0); $check_recommended = 0; }

$data['rc']['gd'] = $switch[1];
$data['av']['gd'] = $switch[(int) extension_loaded('gd')];
if ($data['av']['gd'] != $data['rc']['gd']) { $data['av']['gd'] = cs_html_div(1,'color:#B91F1D') . $data['av']['gd'] . cs_html_div(0); $check_recommended = 0; }

if (!empty($check_required) && !empty($check_recommended)) {
  $data['info']['result'] = $cs_lang['check_perfect'] . cs_html_br(2) . cs_link($cs_lang['continue'],'install','license','lang=' . $account['users_lang']);
} elseif (!empty($check_required)) {
  $data['info']['result'] = $cs_lang['check_ok'] . cs_html_br(2) . cs_link($cs_lang['continue'],'install','license','lang=' . $account['users_lang']);
} else {
  $data['info']['result'] = $cs_lang['check_failed'];
}

echo cs_subtemplate(__FILE__,$data,'install','compatible');

?>