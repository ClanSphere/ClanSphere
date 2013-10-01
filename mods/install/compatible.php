<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('install');

function cs_phpconfigcheck ($name, $exception = 0) {

  $value = strtolower(ini_get($name));
  $array_false = array('0', 'off', 'false');
  $array_true = array('1', 'on', 'true');
  if(empty($value) OR in_array($value, $array_false))
    return false;
  elseif(!empty($exception) OR in_array($value, $array_true))
    return true;
  else
    cs_error(__FILE__, 'PHP configuration of "' . $name . '" is not within expected values: "' . $value . '"');
}

$sql_files = cs_paths('system/database');
unset($sql_files['pdo.php']);

$data = array();
$ok = array();
$ok[0] = cs_html_img('symbols/' . $cs_main['img_path'] . '/16/stop.' . $cs_main['img_ext']);
$ok[1] = cs_html_img('symbols/' . $cs_main['img_path'] . '/16/submit.' . $cs_main['img_ext']);

$switch = array();
$switch[0] = $cs_lang['off'];
$switch[1] = $cs_lang['on'];

$check_required = true;

$data['rq']['php'] = '5.0';
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
$data['rq']['database'] = substr($data['rq']['database'],0,-2);
$data['av']['database'] = substr($data['av']['database'],0,-2);
$data['ok']['database'] = $ok[!empty($data['av']['database'])];
if ($data['ok']['database'] != $ok[1]) { $check_required = false; }

$data['data']['ok'] = $ok[1];

$check_recommended = true;

$data['rc']['php'] = '5.4.6';
$data['sv']['php'] = $data['av']['php'];
$comparison = version_compare($data['av']['php'],$data['rc']['php'],'>=');
if (empty($comparison)) { $data['sv']['php'] = '<div style="color:#B91F1D">' . $data['av']['php'] . '</div>'; $check_recommended = 0;}

$data['rc']['short_open_tag'] = $switch[0];
$data['av']['short_open_tag'] = $switch[(int) cs_phpconfigcheck('short_open_tag')];
if ($data['av']['short_open_tag'] != $data['rc']['short_open_tag']) { $data['av']['short_open_tag'] = '<div style="color:#B91F1D">' . $data['av']['short_open_tag'] . '</div>'; $check_recommended = 0; }

$data['rc']['register_globals'] = $switch[0];
$data['av']['register_globals'] = $switch[(int) cs_phpconfigcheck('register_globals')];
if ($data['av']['register_globals'] != $data['rc']['register_globals']) { $data['av']['register_globals'] = '<div style="color:#B91F1D">' . $data['av']['register_globals'] . '</div>'; $check_recommended = 0; }

$data['rc']['magic_quotes_gpc'] = $switch[0];
$data['av']['magic_quotes_gpc'] = $switch[(int) cs_phpconfigcheck('magic_quotes_gpc')];
if ($data['av']['magic_quotes_gpc'] != $data['rc']['magic_quotes_gpc']) { $data['av']['magic_quotes_gpc'] = '<div style="color:#B91F1D">' . $data['av']['magic_quotes_gpc'] . '</div>'; $check_recommended = 0; }

$data['rc']['magic_quotes_runtime'] = $switch[0];
$data['av']['magic_quotes_runtime'] = $switch[(int) cs_phpconfigcheck('magic_quotes_runtime')];
if ($data['av']['magic_quotes_runtime'] != $data['rc']['magic_quotes_runtime']) { $data['av']['magic_quotes_runtime'] = '<div style="color:#B91F1D">' . $data['av']['magic_quotes_runtime'] . '</div>'; $check_recommended = 0; }

$data['rc']['magic_quotes_sybase'] = $switch[0];
$data['av']['magic_quotes_sybase'] = $switch[(int) cs_phpconfigcheck('magic_quotes_sybase')];
if ($data['av']['magic_quotes_sybase'] != $data['rc']['magic_quotes_sybase']) { $data['av']['magic_quotes_sybase'] = '<div style="color:#B91F1D">' . $data['av']['magic_quotes_sybase'] . '</div>'; $check_recommended = 0; }

$data['rc']['safe_mode'] = $switch[0];
$data['av']['safe_mode'] = $switch[(int) cs_phpconfigcheck('safe_mode')];
if ($data['av']['safe_mode'] != $data['rc']['safe_mode']) { $data['av']['safe_mode'] = '<div style="color:#B91F1D">' . $data['av']['safe_mode'] . '</div>'; $check_recommended = 0; }

$data['rc']['trans_sid'] = $switch[0];
$data['av']['trans_sid'] = $switch[(int) cs_phpconfigcheck('session.use_trans_sid')];
if ($data['av']['trans_sid'] != $data['rc']['trans_sid']) { $data['av']['trans_sid'] = '<div style="color:#B91F1D">' . $data['av']['trans_sid'] . '</div>'; $check_recommended = 0; }

$data['rc']['basedir'] = $switch[1];
$basedir = cs_phpconfigcheck('open_basedir', true);
$data['av']['basedir'] = $switch[$basedir];
if ($data['av']['basedir'] != $data['rc']['basedir']) { $data['av']['basedir'] = '<div style="color:#B91F1D">' . $data['av']['basedir'] . '</div>'; $check_recommended = 0; }

$data['rc']['file_uploads'] = $switch[1];
$data['av']['file_uploads'] = $switch[(int) cs_phpconfigcheck('file_uploads')];
if ($data['av']['file_uploads'] != $data['rc']['file_uploads']) { $data['av']['file_uploads'] = '<div style="color:#B91F1D">' . $data['av']['file_uploads'] . '</div>'; $check_recommended = 0; }

$data['rc']['fopen'] = $switch[1];
$data['av']['fopen'] = $switch[(int) cs_phpconfigcheck('allow_url_fopen')];
if ($data['av']['fopen'] != $data['rc']['fopen']) { $data['av']['fopen'] = '<div style="color:#B91F1D">' . $data['av']['fopen'] . '</div>'; $check_recommended = 0; }

$data['rc']['allow_url_include'] = $switch[0];
$data['av']['allow_url_include'] = $switch[(int) cs_phpconfigcheck('allow_url_include')];
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