<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('quotes');
require_once('mods/categories/functions.php');

$data = array();

$data['head']['body'] = '';
$data['head']['action'] = $cs_lang['create'];

if(isset($_POST['submit'])) {

  $cs_quotes['categories_id'] = empty($_POST['categories_id']) ? 
    cs_categories_create('quotes',$_POST['categories_name']) : (int) $_POST['categories_id'];

  $cs_quotes['quotes_headline'] = $_POST['quotes_headline'];
  $cs_quotes['quotes_text'] = $_POST['quotes_text'];
  $cs_quotes['quotes_time'] = cs_time();
  $cs_quotes['users_id'] = $account['users_id'];
  
  $error = 0;
  $errormsg = '';

  if(empty($cs_quotes['categories_id'])) {
    $error++;
    $errormsg .= $cs_lang['no_cat'] . cs_html_br(1);
  }
  if(empty($cs_quotes['quotes_headline'])) {
    $error++;
    $errormsg .= $cs_lang['no_headline'] . cs_html_br(1);
  }
  if(empty($cs_quotes['quotes_text'])) {
    $error++;
    $errormsg .= $cs_lang['no_text'] . cs_html_br(1);
  }
}

if(!isset($_POST['submit']) AND empty($error)) {
  $data['head']['body'] = $cs_lang['fill_obligated'];
}
elseif(!empty($error)) {
  $data['head']['error'] = $errormsg;
  $data['head']['body'] = '';

}
if(empty($error)) {
  $data['head']['error'] = '';
}

if(!empty($error) OR !isset($_POST['submit'])) {
  
  $data['head']['body'] = $cs_lang['fill_obligated'];
  
  $categories_id = empty($cs_quotes['categories_id']) ? 0 : $cs_quotes['categories_id'];
  
  $data['categories']['dropdown'] = cs_categories_dropdown('quotes',$categories_id);
  $data['abcode']['features'] = cs_abcode_features('quotes_text');
  $data['data']['smileys'] =  cs_abcode_smileys('quotes_text');
  $data['url']['action'] = cs_url('quotes','create');
  $data['quotes']['quotes_headline'] = empty($cs_quotes['quotes_headline']) ? '' : $cs_quotes['quotes_headline'];
  $data['quotes']['quotes_text'] = empty($cs_quotes['quotes_text']) ? '' : $cs_quotes['quotes_text'];
  
  echo cs_subtemplate(__FILE__,$data,'quotes','create');
  
} else {
  
  $quotes_cells = array_keys($cs_quotes);
  $quotes_save = array_values($cs_quotes);
  cs_sql_insert(__FILE__,'quotes',$quotes_cells,$quotes_save);
  
  cs_redirect($cs_lang['create_done'],'quotes');
} 
