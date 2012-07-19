<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('static');

$cs_option = cs_sql_option(__FILE__, 'static');

$cs_static_tpl = array();
$errormsg = '';
$levels = 0;

$cs_action_head['head']['mod']      = $cs_lang['mod_name'];
$cs_action_head['head']['action']    = $cs_lang['head_edit'];

$static_id = $_REQUEST['id'];
settype($static_id,'integer');
$select = 'static_id, static_title, static_text, static_comments, static_table, static_admins, static_access';
$static_edit = cs_sql_select(__FILE__,'static',$select,"static_id = '" . $static_id . "'");

if(isset($static_edit['static_admins']) AND $account['access_static'] == '5') {

  $cs_static['static_title'] = $static_edit['static_title'];
  $cs_static['static_text'] = $static_edit['static_text'];
  $cs_static['static_table'] = $static_edit['static_table'];
  $cs_static['static_comments'] = $static_edit['static_comments'];
  $cs_static['static_access'] = $static_edit['static_access'];
  $cs_static['static_admins'] = $static_edit['static_admins'];

/*
echo $account['access_static'];*/

if(isset($_POST['submit'])) {

  $cs_static['static_title'] = $_POST['static_title'];
  $cs_static['static_text'] = empty($cs_main['rte_html']) ? $_POST['static_text'] : cs_abcode_inhtml($_POST['static_text'], 'add');
  $cs_static['static_table'] = isset($_POST['static_table']) ? 1 : 0;
  $cs_static['static_comments'] = isset($_POST['static_comments']) ? 1 : 0;
  $cs_static['static_access'] = $_POST['static_access'];
  $cs_static['static_admins'] = isset($_POST['static_admins']) ? 1 : 0;

    $error = 0;
    $errormsg = '';
  if(empty($cs_static['static_title'])) {
    $error++;
    $errormsg .= $cs_lang['no_title'] . cs_html_br(1);
  }
  if(empty($cs_static['static_text'])) {
    $error++;
    $errormsg .= $cs_lang['no_text'] . cs_html_br(1);
  }
  
if(empty($error)) {

  $static_cells = array_keys($cs_static);
  $static_save = array_values($cs_static);
  cs_sql_update(__FILE__,'static',$static_cells,$static_save,$static_id);
  
  cs_redirect($cs_lang['changes_done'], 'static') ;
  }  
  
}

if(isset($_POST['preview']) AND empty($error)) {

  $cs_static['static_title'] = $_POST['static_title'];
  $cs_static['static_text'] = $_POST['static_text'];
  $cs_static['static_table'] = isset($_POST['static_table']) ? 1 : 0;
  $cs_static['static_comments'] = isset($_POST['static_comments']) ? 1 : 0;
  $cs_static['static_access'] = $_POST['static_access'];
  $cs_static['static_admins'] = isset($_POST['static_admins']) ? 1 : 0;

$cs_view_static['static']['title'] = $cs_static['static_title'];
$cs_view_static['static']['content'] = cs_secure($cs_static['static_text'],1,1,1,1,$cs_option['php_eval']);

if(empty($cs_static['static_table'])) {
echo cs_subtemplate(__FILE__,$cs_view_static,'static','view');
} else {
echo cs_subtemplate(__FILE__,$cs_view_static,'static','view_table');

echo cs_html_br(3);
}

}

if(!isset($_POST['submit']) OR !empty($error)) {
  $static_access = $cs_static['static_access'];
  while($levels < 6)
  {
    $static_access == $levels ? $sel = 'selected="selected"' : $sel = '';
    $cs_static_tpl['access'][$levels]['level_id']    = $levels;
    $cs_static_tpl['access'][$levels]['level_name']  = $cs_lang['lev_'.$levels];
    $cs_static_tpl['access'][$levels]['selected']    = $sel;
    $levels++;
  }
  if(!empty($error)) {
   $cs_action_head['head']['body']    = $errormsg;
   $more = 'id='.$static_id;
  } else {
   $cs_action_head['head']['body']    = $cs_lang['body_edit'];
   $more = 0;
  }
  $cs_static_tpl['url']['action'] = cs_url('static','edit',$more);
  $cs_news_id = empty($_REQUEST['where']) ? $_REQUEST['id'] : $_REQUEST['where'];
  
  $cs_static_tpl['static']['title'] = empty($cs_static['static_title']) ? cs_secure($static_edit['static_title']) : cs_secure($cs_static['static_title']);
  $cs_static_tpl['static']['content'] = empty($cs_static['static_text']) ? $static_edit['static_text'] : $cs_static['static_text'];
  $static_edit['static_table'] == '1' ? $sel = 'checked="checked"' : $sel = '';
  $cs_static_tpl['static']['table'] = $sel;
  $static_edit['static_comments'] == '1' ? $sel = 'checked="checked"' : $sel = '';
  $cs_static_tpl['static']['comments'] = $sel;
  
  
  if($account['access_static'] < 5) {
    $cs_static_tpl['if']['access_php'] = FALSE;
    $cs_static_tpl['if']['access_admin'] = FALSE;
  } else {
    $cs_static_tpl['if']['access_php'] = TRUE;
    $cs_static_tpl['if']['access_admin'] = TRUE;
    $cs_static_tpl['check']['admin'] = empty($static_edit['static_admins']) ? '' : 'checked="checked"';
  }
  
  $cs_static_tpl['static']['id'] = $static_edit['static_id'];
  $cs_static_tpl['static']['lang_form'] = $cs_lang['edit'];

    if(empty($cs_main['rte_html'])) {
        $cs_static_tpl['if']['rte_html'] = 0;
        $cs_static_tpl['if']['no_rte_html'] = 1;
        $cs_static_tpl['abcode']['features'] = cs_abcode_features('static_text', 1, 1);
        $cs_static_tpl['static']['content'] = cs_secure($cs_static_tpl['static']['content']);
    }
    else {
        $cs_static_tpl['if']['rte_html'] = 1;
        $cs_static_tpl['if']['no_rte_html'] = 0;
        $cs_static_tpl['static']['content'] = cs_rte_html('static_text',$cs_static_tpl['static']['content']);
    }

  echo cs_subtemplate(__FILE__,$cs_action_head,'static','action_head');
  echo cs_subtemplate(__FILE__,$cs_static_tpl,'static','action_form');
}

} else {

$cs_action_head['head']['action']  = $cs_lang['edit'];
$cs_action_head['head']['body']  = $cs_lang['no_access'];
echo cs_subtemplate(__FILE__,$cs_action_head,'static','action_head');

}