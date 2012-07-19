<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('rules');
$cs_post = cs_post('id');
$cs_get = cs_get('id');
$data = array();

$rules_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $rules_id = $cs_post['id'];

require_once('mods/categories/functions.php');

$data['if']['preview'] = false;

$cells = 'rules_order, rules_title, rules_rule, categories_id';
$cs_rules = cs_sql_select(__FILE__,'rules',$cells,"rules_id = '" . $rules_id . "'");

if(isset($_POST['submit']) OR isset($_POST['preview'])) {

  $cs_rules['categories_id'] = empty($_POST['categories_name']) ? $_POST['categories_id'] : 
  cs_categories_create('rules',$_POST['categories_name']);

  $cs_rules['rules_order'] = $_POST['rules_order'];
  $cs_rules['rules_title'] = $_POST['rules_title'];
  $cs_rules['rules_rule'] = $_POST['rules_rule'];

  $error = '';

  if(empty($cs_rules['categories_id']))
    $error .= $cs_lang['no_cat'] . cs_html_br(1);
  if(empty($cs_rules['rules_order']))
    $error .= $cs_lang['no_order'] . cs_html_br(1);
  if(empty($cs_rules['rules_title']))
    $error .= $cs_lang['no_title'] . cs_html_br(1);
  if(empty($cs_rules['rules_rule']))
    $error .= $cs_lang['no_rule'] . cs_html_br(1);

}

if(!isset($_POST['submit']) AND empty($error) AND !isset($_POST['preview'])) {
  $data['head']['body'] = $cs_lang['body_edit'];
}
elseif(!empty($error)) {
  $data['head']['body'] = $error;
}
elseif(isset($_POST['preview']) AND empty($error)) {
  $data['head']['body'] = $cs_lang['preview'];
  $data['if']['preview'] = true;
  $data['ru']['rules_order'] = cs_secure($cs_rules['rules_order']);
  $data['ru']['rules_title'] = cs_secure($cs_rules['rules_title']);
  $data['ru']['rules_rule'] = cs_secure($cs_rules['rules_rule'],1);
}

if(!empty($error) OR !isset($_POST['submit'])) {

  $data['data'] = $cs_rules;
  $data['abcode']['features'] = cs_abcode_features('rules_rule');
  $data['categories']['dropdown'] = cs_categories_dropdown('rules',$cs_rules['categories_id']);
  $data['data']['rules_id'] = $rules_id;

 echo cs_subtemplate(__FILE__,$data,'rules','edit');
}
else {

  $rules_cells = array_keys($cs_rules);
  $rules_save = array_values($cs_rules);
 cs_sql_update(__FILE__,'rules',$rules_cells,$rules_save,$rules_id);

 cs_redirect($cs_lang['changes_done'], 'rules') ;
} 
