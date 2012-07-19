<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('search');

$data = array();

$mods_allowed = array('articles', 'clans', 'files', 'news', 'users');

$search_error = 0; 
$data['search']['raw_where'] = ''; 
$data['search']['raw_text'] = '';
$data['search']['errmsg'] = '';
$submit = empty($_REQUEST['submit']) ? 0 : 1;

$data['if']['errmsg'] = false;
$data['if']['text'] = false;

if(!empty($submit)) {
  if(!empty($_REQUEST['text'])) {
    $data['if']['text'] = true;
    $data['search']['raw_text'] = $_REQUEST['text'];
    } else {
    $data['search']['errmsg'] = cs_icon('important'). $cs_lang['error_text'] . cs_html_br(1);
    $search_error++;
  } 
  if(!empty($_REQUEST['where']) AND in_array($_REQUEST['where'], $mods_allowed)) {
    $data['search']['raw_where'] = $_REQUEST['where'];
    } else {
    $data['search']['errmsg'] .= cs_icon('important'). $cs_lang['error_modul'];
    $search_error++;
  }
}

$sel = 'selected="selected"';
$checked = 'checked="checked"';

$data['search']['articles_check'] = $data['search']['raw_where'] == 'articles' ? $sel : '';
$data['search']['clans_check'] = $data['search']['raw_where'] == 'clans' ? $sel : '';
$data['search']['news_check'] = $data['search']['raw_where'] == 'news' ? $sel : '';
$data['search']['users_check'] = $data['search']['raw_where'] == 'users' ? $sel : '';
$data['search']['files_check'] = $data['search']['raw_where'] == 'files' ? $sel : '';

$data['if']['articles'] = empty($account['access_articles']) ? 0 : 1;
$data['if']['clans'] = empty($account['access_clans']) ? 0 : 1;
$data['if']['news'] = empty($account['access_news']) ? 0 : 1;
$data['if']['users'] = empty($account['access_users']) ? 0 : 1;
$data['if']['files'] = empty($account['access_files']) ? 0 : 1;

if(!empty($search_error))
  $data['if']['errmsg'] = true;

$data['search']['text'] = cs_secure($data['search']['raw_text']);
$data['search']['where'] = cs_secure($data['search']['raw_where']);

echo cs_subtemplate(__FILE__,$data,'search','list');

if(!empty($submit) AND empty($search_error)) {

  $data['search']['text'] = $data['search']['raw_text'];
  $data['search']['where'] = str_replace('..', '', $data['search']['raw_where']);

  $target = 'mods/search/mods/' . $data['search']['where'] . '.php';
  require($target);
}