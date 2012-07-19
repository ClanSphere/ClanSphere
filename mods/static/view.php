<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('static');

$cs_option = cs_sql_option(__FILE__, 'static');

$static_id = (int) $_GET['id'];

$where = "static_id = '" . $static_id . "' AND static_access <= '" . $account['access_static'] . "'";
$cells = 'static_title, static_text, static_table, static_admins, static_comments';
$cs_static = cs_sql_select(__FILE__,'static',$cells,$where);

if (empty($cs_static)) {
  include 'mods/errors/403.php';
  return;
}

$cs_main['page_title'] = $cs_static['static_title'];
$cs_view_static['static']['title'] = $cs_static['static_title'];

$cs_view_static['static']['content'] = cs_secure($cs_static['static_text'],1,1,1,1,$cs_option['php_eval']);

$theme = empty($cs_static['static_table']) ? 'view' : 'view_table';
echo cs_subtemplate(__FILE__,$cs_view_static,'static',$theme);

if(!empty($cs_static['static_comments'])) {

  include_once('mods/comments/functions.php');
  $where = "comments_mod = 'static' AND comments_fid = '" . $static_id . "'";
  $count_com = cs_sql_count(__FILE__,'comments',$where);

  if(!empty($count_com)) {
    echo cs_html_br(1);
    echo cs_comments_view($static_id,'static','view',$count_com);
  }

  echo cs_comments_add($static_id,'static');
}