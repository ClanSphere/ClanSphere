<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('search');

$data = array();

$search_error = 0; 
$data['search']['where'] = ''; 
$data['search']['text'] = '';
$data['search']['errmsg'] = '';
$submit = empty($_REQUEST['submit']) ? 0 : 1;

$data['if']['errmsg'] = false;
$data['if']['text'] = false;

if(!empty($submit)) {
  if(!empty($_REQUEST['text'])) {
    $data['if']['text'] = true;
    $data['search']['text'] = $_REQUEST['text'];
    } else {
    $data['search']['errmsg'] = cs_icon('important'). $cs_lang['error_text'] . cs_html_br(1);
    $search_error++;
  } 
  if(!empty($_REQUEST['where'])) {
    $data['search']['where'] = $_REQUEST['where'];
    } else {
    $data['search']['errmsg'] .= cs_icon('important'). $cs_lang['error_modul'];
    $search_error++;
  }
}

$sel = 'selected="selected"';
$checked = 'checked="checked"';

$data['search']['articles_check'] = $data['search']['where'] == 'articles' ? $sel : '';
$data['search']['clans_check'] = $data['search']['where'] == 'clans' ? $sel : '';
$data['search']['news_check'] = $data['search']['where'] == 'news' ? $sel : '';
$data['search']['users_check'] = $data['search']['where'] == 'users' ? $sel : '';
$data['search']['files_check'] = $data['search']['where'] == 'files' ? $sel : '';


if(!empty($search_error)) {
  $data['if']['errmsg'] = true;
}

echo cs_subtemplate(__FILE__,$data,'search','list');

if(!empty($submit) AND empty($search_error)) {
    
  switch ($data['search']['where']) {
    case 'articles':
      $target = 'mods/search/mods/articles.php';
    break;
    case 'clans':
      $target = 'mods/search/mods/clans.php';
    break;
    case 'news':
      $target = 'mods/search/mods/news.php';
    break;
    case 'users':
      $target = 'mods/search/mods/users.php';
    break;
    case 'files':
      $target = 'mods/search/mods/files.php';
    break;
  }
  require($target);
}
