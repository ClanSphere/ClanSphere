<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('rules');
require_once('mods/categories/functions.php');

$data = array();
	
$rules_id = $_REQUEST['id'];
settype($rules_id,'integer');

$data['if']['head'] = 1;
$data['if']['preview'] = false;

if(isset($_POST['submit']) OR isset($_POST['preview'])) {

  $cs_rules['categories_id'] = empty($_POST['categories_name']) ? $_POST['categories_id'] : 
	cs_categories_create('rules',$_POST['categories_name']);

	$cs_rules['rules_order'] = $_POST['rules_order'];
	$cs_rules['rules_title'] = $_POST['rules_title'];
	$cs_rules['rules_rule'] = $_POST['rules_rule'];

  $error = 0;
  $errormsg = '';

if(empty($cs_rules['categories_id'])) {
	$error++;
  $errormsg .= $cs_lang['no_cat'] . cs_html_br(1);
}
if(empty($cs_rules['rules_order'])) {
	$error++;
  $errormsg .= $cs_lang['no_order'] . cs_html_br(1);
}
if(empty($cs_rules['rules_title'])) {
	$error++;
  $errormsg .= $cs_lang['no_title'] . cs_html_br(1);
}
if(empty($cs_rules['rules_rule'])) {
	$error++;
  $errormsg .= $cs_lang['no_rule'] . cs_html_br(1);
	}
} else {
  $cells = 'rules_order, rules_title, rules_rule, categories_id';
  $cs_rules = cs_sql_select(__FILE__,'rules',$cells,"rules_id = '" . $rules_id . "'");
}

if(!isset($_POST['submit']) AND empty($error) AND !isset($_POST['preview'])) {
  $data['head']['body'] = $cs_lang['errors_here'];
}
elseif(!empty($error)) {
  $data['head']['error'] = $errormsg;
  $data['head']['body'] = '';
}
elseif(isset($_POST['preview'])) {
  $data['if']['preview'] = true;
  $data['ru']['rules_order'] = cs_secure($cs_rules['rules_order']);
  $data['ru']['rules_title'] = cs_secure($cs_rules['rules_title']);
  $data['ru']['rules_rule'] = cs_secure($cs_rules['rules_rule']);
}

if(empty($error)) {
  $data['head']['error'] = '';
  $data['head']['body'] = $cs_lang['body_edit'];
}

if(!empty($error) OR !isset($_POST['submit'])) {

  $data['url']['form'] = cs_url('rules','edit');	
  
  $data['data']['rules_id'] = $rules_id;
	$data['data']['rules_order'] = $cs_rules['rules_order'];
	$data['data']['rules_title'] = $cs_rules['rules_title'];
	$data['data']['rules_rule'] = $cs_rules['rules_rule'];
	$data['data']['categories_id'] = $cs_rules['categories_id'];
	
	$data['categories']['dropdown'] = cs_categories_dropdown('rules',$cs_rules['categories_id']);

	echo cs_subtemplate(__FILE__,$data,'rules','edit');
	
} else {

  $rules_cells = array_keys($cs_rules);
  $rules_save = array_values($cs_rules);
  cs_sql_update(__FILE__,'rules',$rules_cells,$rules_save,$rules_id);

  cs_redirect($cs_lang['changes_done'], 'rules') ;
} 

?>
