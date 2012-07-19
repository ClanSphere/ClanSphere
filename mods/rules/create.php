<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('rules');
require_once('mods/categories/functions.php');
  
$data = array();
$data['if']['preview'] = false;

$data['ru']['rules_order'] = '';
$data['ru']['rules_title'] = '';
$data['ru']['rules_rule'] = '';

if(isset($_POST['submit']) OR isset($_POST['preview'])) {

  $data['ru']['categories_id'] = empty($_POST['categories_id']) ? cs_categories_create('rules',$_POST['categories_name']) 
  : (int) $_POST['categories_id'];

  $data['ru']['rules_order'] = $_POST['rules_order'];
  $data['ru']['rules_title'] = $_POST['rules_title'];
  $data['ru']['rules_rule'] = $_POST['rules_rule'];
  
  $error = '';

  if(empty($data['ru']['categories_id']))
    $error .= $cs_lang['no_cat'] . cs_html_br(1);
  if(empty($data['ru']['rules_order']))
    $error .= $cs_lang['no_order'] . cs_html_br(1);
  if(empty($data['ru']['rules_title']))
    $error .= $cs_lang['no_title'] . cs_html_br(1);
  if(empty($data['ru']['rules_rule']))
    $error .= $cs_lang['no_rule'] . cs_html_br(1);

}

if(!isset($_POST['submit']) AND empty($error) AND !isset($_POST['preview'])) {
  $data['head']['body'] = $cs_lang['body_create'];
}
elseif(!empty($error)) {
  $data['head']['body'] = $error;
}
elseif(isset($_POST['preview']) AND empty($error)) {
  $data['head']['body'] = $cs_lang['preview'];
  $data['if']['preview'] = true;
  $data['ru']['order'] = cs_secure($data['ru']['rules_order']);
  $data['ru']['title'] = cs_secure($data['ru']['rules_title']);
  $data['ru']['rule'] = cs_secure($data['ru']['rules_rule'],1);
}

if(!empty($error) OR !isset($_POST['submit']) OR isset($_POST['preview'])) {

  $categories_id = empty($_POST['categories_id']) ? 0 : $_POST['categories_id'];
  $data['categories']['dropdown'] = cs_categories_dropdown('rules',$categories_id);
  $data['abcode']['features'] = cs_abcode_features('rules_rule');
  
 echo cs_subtemplate(__FILE__,$data,'rules','create');

} else {
  
  $rules_cells = array_keys($data['ru']);
  $rules_save = array_values($data['ru']);
 cs_sql_insert(__FILE__,'rules',$rules_cells,$rules_save);
  
 cs_redirect($cs_lang['create_done'],'rules');
} 
