<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clansphere');

$content = cs_paths('uploads/cache');
unset($content['index.html'], $content['.htaccess'], $content['web.config']);

$data['info']['cache_cleared'] = '';
$data['link']['reload'] = cs_url('clansphere','cache');
$data['link']['empty_cache'] = cs_url('clansphere','cache','clear=1');

if(!empty($_GET['clear'])) {

  cs_cache_clear();
  $content = array();
  $data['info']['cache_cleared'] = cs_html_br(2) . $cs_lang['cache_cleared'];
}

$start = empty($_GET['start']) ? 0 : (int) $_GET['start'];
$data['count']['files'] = count($content);
$data['pages']['show']  = cs_pages('clansphere', 'cache', $data['count']['files'], $start);

if(empty($content))
  $data['cache'] = '';

$space = 0;
$run = 0;
$content = array_keys($content);
$end = $start + $account['users_limit'];
$stop = ($end > $data['count']['files']) ? $data['count']['files'] : $end;

for($x = $start; $x < $stop; $x++) {

  $date = filemtime('uploads/cache/' . $content[$x]) - date('Z');
  $size = filesize('uploads/cache/' . $content[$x]);
  $space = $space + $size;

  $data['cache'][$run]['file'] = $content[$x];
  $data['cache'][$run]['date'] = cs_date('unix',$date,1);
  $data['cache'][$run]['size'] = cs_filesize($size);
  $run++;
}

echo cs_subtemplate(__FILE__,$data,'clansphere','cache');