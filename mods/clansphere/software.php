<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clansphere');

$display_errors = ini_get('display_errors');
$file_uploads = ini_get('file_uploads');
$short_open_tag = ini_get('short_open_tag');
$register_globals = ini_get('register_globals');
$magic_quotes = ini_get('magic_quotes_gpc');
$safe_mode = ini_get('safe_mode');
$trans_sid = ini_get('session.use_trans_sid');
$basedir = ini_get('open_basedir');
$url_fopen = ini_get('allow_url_fopen');
$url_include = ini_get('allow_url_include');
$limit['post_max_size'] = str_replace('M',' MiB', ini_get('post_max_size'));
$limit['upload_max_filesize'] = str_replace('M',' MiB', ini_get('upload_max_filesize'));
$limit['memory_limit'] = str_replace('M',' MiB', ini_get('memory_limit'));

$data['software']['os'] = @php_uname('s') . ' ' . @php_uname('r') . ' ' . @php_uname('v');
$data['software']['machine'] = @php_uname('m');
$data['software']['host'] = @php_uname('n');
$data['software']['webserver'] = str_replace('/',' ',$_SERVER['SERVER_SOFTWARE']);
$data['software']['php_mode'] = php_sapi_name();
$data['software']['php_mod'] = phpversion();
$data['software']['zend_core'] = zend_version();

$data['software']['file_uploads'] = empty($file_uploads) ? $cs_lang['off'] : $cs_lang['on'];
$data['software']['check_file_uploads'] = empty($file_uploads) ? cs_icon('stop') : cs_icon('submit');
$data['software']['recom_file_uploads'] = $cs_lang['on'];

$data['software']['short_open_tag'] = empty($short_open_tag) ? $cs_lang['off'] : $cs_lang['on'];
$data['software']['check_short_open_tag'] = empty($short_open_tag) ? cs_icon('submit') : cs_icon('stop');
$data['software']['recom_short_open_tag'] = $cs_lang['off'];

$data['software']['reg_global'] = empty($register_globals) ? $cs_lang['off'] : $cs_lang['on'];
$data['software']['check_reg_global'] = empty($register_globals) ? cs_icon('submit') : cs_icon('stop');
$data['software']['recom_reg_global'] = $cs_lang['off'];

$data['software']['m_quotes'] = empty($magic_quotes) ? $cs_lang['off'] : $cs_lang['on'];
$data['software']['check_m_quotes'] = empty($magic_quotes) ? cs_icon('submit') : cs_icon('stop');
$data['software']['recom_m_quotes'] = $cs_lang['off'];

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

$gle = get_loaded_extensions();
$eco = count($gle);
$run = 0;
$ext = '';

while($run != $eco) {
  $ext .= $gle[$run] . ', ';
  $run++;
}
$data['software']['php_extensions'] = substr($ext,0,-2);

echo cs_subtemplate(__FILE__,$data,'clansphere','software');