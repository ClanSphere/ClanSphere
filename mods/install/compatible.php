<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('install');

$sql_files = cs_paths('system/database');
unset($sql_files['pdo.php']);

$data = array();
$ok = array();
$ok[0] = cs_html_img('symbols/crystal_project/16/stop.png');
$ok[1] = cs_html_img('symbols/crystal_project/16/submit.png');

$switch = array();
$switch[0] = $cs_lang['off'];
$switch[1] = $cs_lang['on'];

$check_required = true;

$data['rq']['php'] = '4.3.0';
$data['av']['php'] = phpversion();
$data['ok']['php'] = $ok[version_compare($data['av']['php'],$data['rq']['php'],'>=')];
if ($data['ok']['php'] != $ok[1]) { $check_required = false; }

$data['rq']['database'] = '';
$data['av']['database'] = '';
foreach($sql_files AS $sql_file => $num) {
  $extension = substr($sql_file, 0, -4);
  $data['rq']['database'] .= $extension . ', ';
  if(extension_loaded($extension)) {
    $data['av']['database'] .= $extension . ', ';
  }
}
$data['rq']['database'] = @substr($data['rq']['database'],0,-2);
$data['av']['database'] = @substr($data['av']['database'],0,-2);
$data['ok']['database'] = $ok[!empty($data['av']['database'])];
if ($data['ok']['database'] != $ok[1]) { $check_required = false; }

$data['data']['ok'] = $ok[1];

$check_recommended = true;

$data['rc']['php'] = '5.2.10';
$comparison = version_compare($data['av']['php'],$data['rc']['php'],'>=');
if (empty($comparison)) { $data['av']['php'] = '<div style="color:#B91F1D">' . $data['av']['php'] . '</div>'; $check_recommended = 0;}

$data['rc']['short_open_tag'] = $switch[0];
$data['av']['short_open_tag'] = $switch[(int) ini_get('short_open_tag')];
if ($data['av']['short_open_tag'] != $data['rc']['short_open_tag']) { $data['av']['short_open_tag'] = '<div style="color:#B91F1D">' . $data['av']['short_open_tag'] . '</div>'; $check_recommended = 0; }

$data['rc']['register_globals'] = $switch[0];
$data['av']['register_globals'] = $switch[(int) ini_get('register_globals')];
if ($data['av']['register_globals'] != $data['rc']['register_globals']) { $data['av']['register_globals'] = '<div style="color:#B91F1D">' . $data['av']['register_globals'] . '</div>'; $check_recommended = 0; }

$data['rc']['magic_quotes'] = $switch[0];
$data['av']['magic_quotes'] = $switch[(int) ini_get('magic_quotes_gpc')];
if ($data['av']['magic_quotes'] != $data['rc']['magic_quotes']) { $data['av']['magic_quotes'] = '<div style="color:#B91F1D">' . $data['av']['magic_quotes'] . '</div>'; $check_recommended = 0; }

$data['rc']['safe_mode'] = $switch[0];
$data['av']['safe_mode'] = $switch[(int) ini_get('safe_mode')];
if ($data['av']['safe_mode'] != $data['rc']['safe_mode']) { $data['av']['safe_mode'] = '<div style="color:#B91F1D">' . $data['av']['safe_mode'] . '</div>'; $check_recommended = 0; }

$data['rc']['trans_sid'] = $switch[0];
$data['av']['trans_sid'] = $switch[(int) ini_get('session.use_trans_sid')];
if ($data['av']['trans_sid'] != $data['rc']['trans_sid']) { $data['av']['trans_sid'] = '<div style="color:#B91F1D">' . $data['av']['trans_sid'] . '</div>'; $check_recommended = 0; }

$data['rc']['basedir'] = $switch[1];
$basedir = ini_get('open_basedir');
$basedir = empty($basedir) ? 0 : 1;
$data['av']['basedir'] = $switch[$basedir];
if ($data['av']['basedir'] != $data['rc']['basedir']) { $data['av']['basedir'] = '<div style="color:#B91F1D">' . $data['av']['basedir'] . '</div>'; $check_recommended = 0; }

$data['rc']['file_uploads'] = $switch[1];
$data['av']['file_uploads'] = $switch[(int) ini_get('file_uploads')];
if ($data['av']['file_uploads'] != $data['rc']['file_uploads']) { $data['av']['file_uploads'] = '<div style="color:#B91F1D">' . $data['av']['file_uploads'] . '</div>'; $check_recommended = 0; }

$data['rc']['fopen'] = $switch[1];
$data['av']['fopen'] = $switch[(int) ini_get('allow_url_fopen')];
if ($data['av']['fopen'] != $data['rc']['fopen']) { $data['av']['fopen'] = '<div style="color:#B91F1D">' . $data['av']['fopen'] . '</div>'; $check_recommended = 0; }

$data['rc']['allow_url_include'] = $switch[0];
$data['av']['allow_url_include'] = $switch[(int) ini_get('allow_url_include')];
if ($data['av']['allow_url_include'] != $data['rc']['allow_url_include']) { $data['av']['allow_url_include'] = '<div style="color:#B91F1D">' . $data['av']['allow_url_include'] . '</div>'; $check_recommended = 0; }

$data['rc']['gd'] = $switch[1];
$data['av']['gd'] = $switch[(int) extension_loaded('gd')];
if ($data['av']['gd'] != $data['rc']['gd']) { $data['av']['gd'] = '<div style="color:#B91F1D">' . $data['av']['gd'] . '</div>'; $check_recommended = 0; }

if (!empty($check_required) && !empty($check_recommended)) {
  $data['info']['result'] = $cs_lang['check_perfect'] . cs_html_br(2) . cs_link($cs_lang['continue'],'install','license','lang=' . $account['users_lang']);
} elseif (!empty($check_required)) {
  $data['info']['result'] = $cs_lang['check_ok'] . cs_html_br(2) . cs_link($cs_lang['continue'],'install','license','lang=' . $account['users_lang']);
} else {
  $data['info']['result'] = $cs_lang['check_failed'];
}

echo cs_subtemplate(__FILE__,$data,'install','compatible');