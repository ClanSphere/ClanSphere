<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clansphere');

$error = '';

$local = array('version' => $cs_main['version_name'], 'published' => $cs_main['version_date'], 'id' => $cs_main['version_id']);

$remote = array('version' => '-', 'published' => '1970-01-01', 'id' => 0);

$allow_url_fopen = ini_get('allow_url_fopen');
if(empty($allow_url_fopen)) {
  $error = $cs_lang['need_url_fopen'];
}
else {
  if($content = file_get_contents('http://www.clansphere.net/version.txt')) {
    $content = explode(' ',$content);
    $remote = array('version' => $content[0], 'published' => $content[1], 'id' => $content[2]);
    settype($remote['id'],'integer');
  }
  else {
    $error = $cs_lang['file_not_read'];
  }
}

$data['version']['version'] = $local['version'];
$data['version']['version_date'] = cs_date('date',$local['published']);
$data['version']['available'] = $remote['version'];
$data['version']['available_date'] = cs_date('date',$remote['published']);

if(empty($error)) {
  $data['version']['msg'] = $local['id'] >= $remote['id'] ? $cs_lang['up_to_date'] : $cs_lang['new_release'] . ' ' . cs_html_link('http://www.clansphere.net/index.php?mod=files&action=listcat&where=14',$cs_lang['visit_dlpage']);
}
else {
  $data['version']['msg'] = $error;
}

echo cs_subtemplate(__FILE__,$data,'clansphere','version');
?>