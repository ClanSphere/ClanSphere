<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clansphere');

$error = '';

$local = array('version' => $cs_main['version_name'], 'published' => $cs_main['version_date'], 'id' => $cs_main['version_id']);

$remote = array('version' => '-', 'published' => '1970-01-01', 'id' => 0);

$remote_url_download = 'http://www.clansphere.net/index/files/view/id/12';

$remote_url_version = 'http://www.clansphere.net/clansphere/version.txt';

$timeout = 5;

$allow_url_fopen = ini_get('allow_url_fopen');
if(empty($allow_url_fopen)) {
  $error = $cs_lang['need_url_fopen'];
}
else {
  $content = '';

  ini_set("default_socket_timeout", $timeout);

  $rfp = fopen($remote_url_version, 'r');
  if(is_resource($rfp)) {
    stream_set_timeout($rfp, $timeout);
    $content = fread($rfp, 4096);
    fclose($rfp);
  }

  if(empty($content))
    $error = $cs_lang['file_not_read'];
  else {
    $content = explode(' ', $content);
    $remote = array('version' => $content[0], 'published' => $content[1], 'id' => $content[2]);
    settype($remote['id'], 'integer');
  }
}

$data['version']['version'] = htmlentities($local['version'], ENT_QUOTES, $cs_main['charset']);
$data['version']['version_date'] = cs_date('date', $local['published']);
$data['version']['available'] = htmlentities($remote['version'], ENT_QUOTES, $cs_main['charset']);
$data['version']['available_date'] = cs_date('date', $remote['published']);

if(empty($error))
  $data['version']['msg'] = $local['id'] >= $remote['id'] ? $cs_lang['up_to_date'] : $cs_lang['new_release'] . ' ' . cs_html_link($remote_url_download, $cs_lang['visit_dlpage']);
else
  $data['version']['msg'] = $error;

echo cs_subtemplate(__FILE__,$data,'clansphere','version');