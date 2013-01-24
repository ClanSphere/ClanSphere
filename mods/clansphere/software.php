<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clansphere');

function cs_kisort($k1, $k2) {

  return strtolower($k1) > strtolower($k2);
}

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

$display_errors = cs_phpconfigcheck('display_errors');
$file_uploads = cs_phpconfigcheck('file_uploads');
$short_open_tag = cs_phpconfigcheck('short_open_tag');
$register_globals = cs_phpconfigcheck('register_globals');
$magic_quotes_gpc = cs_phpconfigcheck('magic_quotes_gpc');
$magic_quotes_runtime = cs_phpconfigcheck('magic_quotes_runtime');
$magic_quotes_sybase = cs_phpconfigcheck('magic_quotes_sybase');
$safe_mode = cs_phpconfigcheck('safe_mode');
$trans_sid = cs_phpconfigcheck('session.use_trans_sid');
$basedir = cs_phpconfigcheck('open_basedir', true);
$url_fopen = cs_phpconfigcheck('allow_url_fopen');
$url_include = cs_phpconfigcheck('allow_url_include');
$limit['post_max_size'] = str_replace('M',' MiB', ini_get('post_max_size'));
$limit['upload_max_filesize'] = str_replace('M',' MiB', ini_get('upload_max_filesize'));
$limit['memory_limit'] = str_replace('M',' MiB', ini_get('memory_limit'));

$data['software']['os'] = @php_uname('s') . ' ' . @php_uname('r') . ' ' . @php_uname('v');
$data['software']['host'] = @php_uname('n');

if(function_exists('apache_get_version'))
  $data['software']['webserver'] = apache_get_version();
if(empty($data['software']['webserver']))
  $data['software']['webserver'] = isset($_SERVER['SERVER_SOFTWARE']) ? str_replace('/',' ',$_SERVER['SERVER_SOFTWARE']) : '';

$data['software']['php_mode'] = php_sapi_name();
$data['software']['php_mod'] = phpversion();
$data['software']['zend_core'] = zend_version();

$gd_vers = '-';
if(extension_loaded('gd')) {
  $gd_info = gd_info();
  $gd_vers = $gd_info['GD Version'];
}
$data['software']['php_gd_ext'] = $gd_vers;

$data['software']['file_uploads'] = empty($file_uploads) ? $cs_lang['off'] : $cs_lang['on'];
$data['software']['check_file_uploads'] = empty($file_uploads) ? cs_icon('stop') : cs_icon('submit');
$data['software']['recom_file_uploads'] = $cs_lang['on'];

$data['software']['short_open_tag'] = empty($short_open_tag) ? $cs_lang['off'] : $cs_lang['on'];
$data['software']['check_short_open_tag'] = empty($short_open_tag) ? cs_icon('submit') : cs_icon('stop');
$data['software']['recom_short_open_tag'] = $cs_lang['off'];

$data['software']['reg_global'] = empty($register_globals) ? $cs_lang['off'] : $cs_lang['on'];
$data['software']['check_reg_global'] = empty($register_globals) ? cs_icon('submit') : cs_icon('stop');
$data['software']['recom_reg_global'] = $cs_lang['off'];

$data['software']['m_quotes_gpc'] = empty($magic_quotes_gpc) ? $cs_lang['off'] : $cs_lang['on'];
$data['software']['recom_m_quotes_gpc'] = $cs_lang['off'];
$data['software']['m_quotes_runtime'] = empty($magic_quotes_runtime) ? $cs_lang['off'] : $cs_lang['on'];
$data['software']['recom_m_quotes_runtime'] = $cs_lang['off'];
$data['software']['m_quotes_sybase'] = empty($magic_quotes_sybase) ? $cs_lang['off'] : $cs_lang['on'];
$data['software']['recom_m_quotes_sybase'] = $cs_lang['off'];

if(empty($magic_quotes_gpc) AND empty($magic_quotes_runtime) AND empty($magic_quotes_sybase))
  $data['software']['check_m_quotes'] = cs_icon('submit');
else
  $data['software']['check_m_quotes'] = cs_icon('stop');

$data['software']['safe_mode'] = empty($safe_mode) ? $cs_lang['off'] : $cs_lang['on'];
$data['software']['check_safe_mode'] = empty($safe_mode) ? cs_icon('submit') : cs_icon('stop');
$data['software']['recom_safe_mode'] = $cs_lang['off'];

$data['software']['trans_sid'] = empty($trans_sid) ? $cs_lang['off'] : $cs_lang['on'];
$data['software']['check_trans_sid'] = empty($trans_sid) ? cs_icon('submit') : cs_icon('stop');
$data['software']['recom_trans_sid'] = $cs_lang['off'];

$data['software']['basedir_restriction'] = empty($basedir) ? $cs_lang['off'] : $cs_lang['on'];
$data['software']['check_basedir_restriction'] = empty($basedir) ? cs_icon('stop') : cs_icon('submit');
$data['software']['recom_basedir_restriction'] = $cs_lang['on'];

$data['software']['allow_url_fopen'] = empty($url_fopen) ? $cs_lang['off'] : $cs_lang['on'];
$data['software']['check_allow_url_fopen'] = empty($url_fopen) ? cs_icon('stop') : cs_icon('submit');
$data['software']['recom_allow_url_fopen'] = $cs_lang['on'];

$data['software']['allow_url_include'] = empty($url_include) ? $cs_lang['off'] : $cs_lang['on'];
$data['software']['check_allow_url_include'] = empty($url_include) ? cs_icon('submit') : cs_icon('stop');
$data['software']['recom_allow_url_include'] = $cs_lang['off'];

$data['software']['display_err'] = empty($display_errors) ? $cs_lang['off'] : $cs_lang['on'];
$data['software']['recom_display_err'] = '-';

$data['software']['post_max_size'] = $limit['post_max_size'];
$data['software']['recom_post_max_size'] = '-';

$data['software']['upload_max_filesize'] = $limit['upload_max_filesize'];
$data['software']['recom_upload_max_filesize'] = '-';

$data['software']['memory_limit'] = $limit['memory_limit'];
$data['software']['recom_memory_limit'] = '-';

# fetch active php extensions and order them from a to z
$gle = get_loaded_extensions();
$gle = array_flip($gle);
uksort($gle, "cs_kisort");
$gle = array_flip($gle);

# parse php extensions into a loop compatible array
$data['php_ext'] = array();
foreach($gle AS $num => $ext)
  $data['php_ext'][$num]['name'] = $ext;

echo cs_subtemplate(__FILE__,$data,'clansphere','software');