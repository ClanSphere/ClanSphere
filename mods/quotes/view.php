<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('quotes');

$cs_quotes_id = empty($_REQUEST['where']) ? $_REQUEST['id'] : $_REQUEST['where'];
settype($cs_quotes_id,'integer');

$from = 'quotes qts INNER JOIN {pre}_users usr ON qts.users_id = usr.users_id INNER JOIN {pre}_categories cat ON qts.categories_id = cat.categories_id';
$select = 'qts.quotes_id AS quotes_id, qts.quotes_headline AS quotes_headline, qts.quotes_time AS quotes_time, qts.quotes_text AS quotes_text, qts.users_id AS users_id, usr.users_nick AS users_nick, usr.users_active AS users_active, usr.users_delete AS users_delete, qts.categories_id AS categories_id, cat.categories_access AS categories_access, cat.categories_picture AS categories_picture';
$cs_quotes = cs_sql_select(__FILE__,$from,$select,"quotes_id = '" . $cs_quotes_id . "'");

  $data['head']['mod'] = $cs_lang['mod_name'];
  $data['head']['action'] = $cs_lang['details'];
  $data['head']['body'] = $cs_lang['quote_info'];


  $com_where = "comments_mod = 'quotes' AND comments_fid = '" . $cs_quotes['quotes_id'] . "'";
  $data['quotes']['comments_count'] = cs_sql_count(__FILE__,'comments',$com_where);
  $data['quotes']['quotes_id'] = cs_secure($cs_quotes['quotes_id']);
  $data['quotes']['quotes_headline'] = cs_secure($cs_quotes['quotes_headline']);
  $data['quotes']['quotes_time'] = cs_date('unix',$cs_quotes['quotes_time'],1);
  $data['quotes']['quotes_text'] = cs_secure($cs_quotes['quotes_text'],1,1);
  $data['quotes']['users_link'] = cs_user($cs_quotes['users_id'],$cs_quotes['users_nick'], $cs_quotes['users_active'], $cs_quotes['users_delete']);
  $data['lang']['comments'] = $cs_lang['comments'];

  echo cs_subtemplate(__FILE__,$data,'quotes','view');

  echo cs_html_anchor('com0');
  include_once('mods/comments/functions.php');
  if(!empty($data['quotes']['comments_count'])) {
    echo cs_html_br(1);
    echo cs_comments_view($cs_quotes_id,'quotes','view',$data['quotes']['comments_count']);
  }
  echo cs_comments_add($cs_quotes_id,'quotes');