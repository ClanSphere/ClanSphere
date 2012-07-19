<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clansphere');

$content = cs_cache_info();

$data['data']['cache_mode'] = $cs_main['cache_mode'];
$data['info']['cache_cleared'] = '';
$data['link']['reload'] = cs_url('clansphere','cache');
$data['link']['empty_cache'] = cs_url('clansphere','cache','clear=1');

if(!empty($_GET['clear'])) {
  cs_cache_clear();
  $content = array();
  $data['info']['cache_cleared'] = cs_html_br(2) . $cs_lang['cache_cleared'];
}

$start = empty($_GET['start']) ? 0 : (int) $_GET['start'];
$data['count']['total'] = count($content);
$data['pages']['show']  = cs_pages('clansphere', 'cache', $data['count']['total'], $start);

if(empty($content))
  $data['cache'] = '';

$space = 0;
$run = 0;
$end = $start + $account['users_limit'];
$stop = ($end > $data['count']['total']) ? $data['count']['total'] : $end;

for($x = $start; $x < $stop; $x++) {

  $data['cache'][$run]['name'] = $content[$x]['name'];
  $data['cache'][$run]['date'] = cs_date('unix',$content[$x]['time'] - date('Z'),1);
  $data['cache'][$run]['size'] = cs_filesize($content[$x]['size']);
  $space += $content[$x]['size'];
  $run++;
}

$data['count']['size'] = cs_filesize($space);

echo cs_subtemplate(__FILE__,$data,'clansphere','cache');