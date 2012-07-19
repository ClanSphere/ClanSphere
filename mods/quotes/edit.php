

<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('quotes');
require_once('mods/categories/functions.php');

$quotes_id = $_REQUEST['id'];
settype($quotes_id,'integer');

 $data['head']['mod'] = $cs_lang['mod_name'];
 $data['head']['action'] = $cs_lang['edit'];
 $data['head']['body'] = $cs_lang['fill_obligated'];


if(isset($_POST['submit'])) {

    $cs_quotes['categories_id'] = empty($_POST['categories_name']) ? $_POST['categories_id'] : 
  cs_categories_create('quotes',$_POST['categories_name']);

  $cs_quotes['quotes_headline'] = $_POST['quotes_headline'];
  $cs_quotes['quotes_text'] = $_POST['quotes_text'];
  $cs_quotes['quotes_time'] = $_POST['quotes_time'];
  
  if(!empty($_POST['quotes_newtime'])) {
    $cs_quotes['quotes_time'] = cs_time();
    $quotes_newtime = 1;
  }

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
else {
  $cells = 'categories_id, quotes_headline, quotes_text, users_id, quotes_time';
  $cs_quotes = cs_sql_select(__FILE__,'quotes',$cells,"quotes_id = '" . $quotes_id . "'");
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
  
  $data['data']['quotes_id'] = $quotes_id;
  $data['data']['quotes_time'] = $cs_quotes['quotes_time'];
  $data['data']['quotes_headline'] = $cs_quotes['quotes_headline'];
  $data['data']['categories_id'] = $cs_quotes['categories_id'];
  
  $data['lang']['text'] =  $cs_lang['text'];
    $data['data']['smileys'] =  cs_abcode_smileys('quotes_text');
  
  
  $data['data']['quotes_text'] = $cs_quotes['quotes_text'];
    if(!empty($cs_quotes['quotes_com'])) {
  $data['data']['quotes_com_checked'] = 'checked';
  } else { $data['data']['quotes_com_checked'] = ''; }
    if(!empty($cs_quotes['quotes_navlist'])) {
  $data['data']['quotes_navlist_checked'] = 'checked';
  } else { $data['data']['quotes_navlist_checked'] = ''; }
    if(!empty($cs_quotes['quotes_fornext'])) {
  $data['data']['quotes_fornext_checked'] = 'checked';
  } else { $data['data']['quotes_fornext_checked'] = ''; }
  
  $data['lang']['headline'] = $cs_lang['headline'];
  $data['lang']['categories'] = $cs_lang['categories'];
  $data['categories']['dropdown'] = cs_categories_dropdown('quotes',$cs_quotes['categories_id']);
    $data['abcode']['features'] = cs_abcode_features('quotes_text');
  $data['lang']['more'] = $cs_lang['more'];
  $data['lang']['nocom'] = $cs_lang['nocom'];
  $data['lang']['nav'] = $cs_lang['nav']; 
  $data['lang']['fornext'] = $cs_lang['fornext'];
  $data['lang']['new_date'] = $cs_lang['new_date']; 
  $data['lang']['options'] = $cs_lang['options'];
  $data['lang']['edit'] = $cs_lang['edit'];
  $data['lang']['reset'] = $cs_lang['reset'];
  echo cs_subtemplate(__FILE__,$data,'quotes','edit');
  
} else {

  $quotes_cells = array_keys($cs_quotes);
  $quotes_save = array_values($cs_quotes);
  cs_sql_update(__FILE__,'quotes',$quotes_cells,$quotes_save,$quotes_id);
  
   cs_redirect($cs_lang['changes_done'], 'quotes') ;
} 
