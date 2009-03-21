<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clansphere');

$display_errors = ini_get('display_errors');
$register_globals = ini_get('register_globals');
$magic_quotes = ini_get('magic_quotes_gpc');
$safe_mode = ini_get('safe_mode');
$trans_sid = ini_get('session.use_trans_sid');
$basedir = ini_get('open_basedir');
$url_fopen = ini_get('allow_url_fopen');
$limit['post_max_size'] = str_replace('M',' MiB', ini_get('post_max_size'));
$limit['upload_max_filesize'] = str_replace('M',' MiB', ini_get('upload_max_filesize'));
$limit['memory_limit'] = str_replace('M',' MiB', ini_get('memory_limit'));

$sql_infos = cs_sql_version(__FILE__);

$data['software']['os'] = @php_uname('s') . ' ' . @php_uname('r');
$data['software']['webserver'] = str_replace('/',' ',$_SERVER['SERVER_SOFTWARE']);
$data['software']['php_mod'] = phpversion();
$data['software']['type'] = $sql_infos['type'];
$data['software']['host'] = $sql_infos['host'];
$data['software']['encoding'] = $sql_infos['encoding'];
$data['software']['server'] = $sql_infos['server'];
$data['software']['client'] = $sql_infos['client'];

if(!empty($sql_infos['tables'])) {
  $data['software']['usage'] = $sql_infos['tables'] . ' ' . $cs_lang['tables'];
  $data['software']['usage'] .= cs_html_br(1) . '--------------------------' . cs_html_br(1);
  $data['software']['usage'] .= cs_filesize($sql_infos['data_size']) . ' ' . $cs_lang['data'];
  $data['software']['usage'] .= cs_html_br(1);
  $data['software']['usage'] .= cs_filesize($sql_infos['index_size']) . ' ' . $cs_lang['indexe'];
  $data['software']['usage'] .= cs_html_br(1) . '--------------------------' . cs_html_br(1);
  $data['software']['usage'] .= cs_filesize($sql_infos['data_size'] + $sql_infos['index_size']) . ' ' . $cs_lang['total'];
}
else {
  $data['software']['usage'] = '-';
}

if(empty($display_errors)) {
  $data['software']['display_err'] = $cs_lang['off'];
}
else {
  $data['software']['display_err'] = $cs_lang['on'];
}

if(empty($register_globals)) {
  $data['software']['reg_global'] = $cs_lang['off'];
}
else {
  $data['software']['reg_global'] = $cs_lang['on'];
}

if(empty($magic_quotes)) {
  $data['software']['m_quotes'] = $cs_lang['off'];
}
else {
  $data['software']['m_quotes'] = $cs_lang['on'];
}

if(empty($safe_mode)) {
  $data['software']['safe_mode'] = $cs_lang['off'];
}
else {
  $data['software']['safe_mode'] = $cs_lang['on'];
}

if(empty($trans_sid)) {
  $data['software']['trans_sid'] = $cs_lang['off'];
}
else {
  $data['software']['trans_sid'] = $cs_lang['on'];
}

if(empty($basedir)) {
  $data['software']['basedir_restriction'] = $cs_lang['off'];
}
else {
  $data['software']['basedir_restriction'] = $cs_lang['on'];
}

if(empty($url_fopen)) {
  $data['software']['allow_url_fopen'] = $cs_lang['off'];
}
else {
  $data['software']['allow_url_fopen'] = $cs_lang['on'];
}

$data['software']['post_max_size'] = $limit['post_max_size'];
$data['software']['upload_max_filesize'] = $limit['upload_max_filesize'];
$data['software']['memory_limit'] = $limit['memory_limit'];


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

?>