<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('rules');
require_once('mods/categories/functions.php');
  
$data = array();

$data['head']['body'] = $cs_lang['body_create'];
$data['if']['head'] = 1;
$data['if']['preview'] = false;

if(isset($_POST['submit']) OR isset($_POST['preview'])) {

  $data['ru']['categories_id'] = empty($_POST['categories_id']) ? cs_categories_create('rules',$_POST['categories_name']) 
	: (int) $_POST['categories_id'];

	$data['ru']['rules_order'] = $_POST['rules_order'];
	$data['ru']['rules_title'] = $_POST['rules_title'];
	$data['ru']['rules_rule'] = $_POST['rules_rule'];
	
  $error = 0;
  $errormsg = '';

  if(empty($data['ru']['categories_id'])) {
    $error++;
    $errormsg .= $cs_lang['no_cat'] . cs_html_br(1);
  }
  if(empty($data['ru']['rules_order'])) {
    $error++;
    $errormsg .= $cs_lang['no_order'] . cs_html_br(1);
  }
  if(empty($data['ru']['rules_title'])) {
    $error++;
    $errormsg .= $cs_lang['no_title'] . cs_html_br(1);
  }
  if(empty($data['ru']['rules_rule'])) {
    $error++;
    $errormsg .= $cs_lang['no_rule'] . cs_html_br(1);
  }
} else {
	$data['ru']['rules_order'] = '';
	$data['ru']['rules_title'] = '';
	$data['ru']['rules_rule'] = '';
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
  $data['ru']['order'] = cs_secure($data['ru']['rules_order']);
  $data['ru']['title'] = cs_secure($data['ru']['rules_title']);
  $data['ru']['rule'] = cs_secure($data['ru']['rules_rule']);
}

if(empty($error)) {
	$data['head']['error'] = '';
}

if(!empty($error) OR !isset($_POST['submit'])) {

	$categories_id = empty($_POST['categories_id']) ? 0 : $_POST['categories_id'];
	$data['categories']['dropdown'] = cs_categories_dropdown('rules',$categories_id);
	$data['url']['form'] = cs_url('rules','create');

} else {
	
	$rules_cells = array_keys($data['ru']);
	$rules_save = array_values($data['ru']);
	cs_sql_insert(__FILE__,'rules',$rules_cells,$rules_save);
	
  cs_redirect($cs_lang['create_done'],'rules');
} 

  echo cs_subtemplate(__FILE__,$data,'rules','create');

?>
