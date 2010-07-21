<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clansphere');

$content = cs_paths('uploads/cache');
unset($content['index.html'], $content['.htaccess'], $content['web.config']);

$data['lang']['cache_cleared'] = '';
$data['link']['reload'] = cs_url('clansphere','cache');
$data['link']['empty_cache'] = cs_url('clansphere','cache','clear=1');

if(!empty($_GET['clear'])) {

  cs_cache_clear();
  $content = array();
  $data['lang']['cache_cleared'] = cs_html_br(2) . $cs_lang['cache_cleared'];
}

$space = 0;
$files = 0;
$run = 0;

if(empty($content)) {
  $data['cache'] = '';
}

foreach($content AS $file => $name) {
  $date = filemtime('uploads/cache/' . $file) - date('Z');
  $size = filesize('uploads/cache/' . $file);
  $space = $space + $size;
  $files++;

  $data['cache'][$run]['file'] = $file;
  $data['cache'][$run]['date'] = cs_date('unix',$date,1);
  $data['cache'][$run]['size'] = cs_filesize($size);
  $run++;
}

$data['count']['files'] = $files;
$data['count']['total'] = cs_filesize($space);

echo cs_subtemplate(__FILE__,$data,'clansphere','cache');