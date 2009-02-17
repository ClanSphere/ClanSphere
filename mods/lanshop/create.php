<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanshop');
require_once('mods/categories/functions.php');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_create'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');

if(isset($_POST['submit'])) {

  $cs_lanshop['categories_id'] = empty($_POST['categories_name']) ? $_POST['categories_id'] : 
  cs_categories_create('lanshop',$_POST['categories_name']);

  $cs_lanshop['lanshop_articles_name'] = $_POST['lanshop_articles_name'];
  $cs_lanshop['lanshop_articles_price'] = $_POST['lanshop_articles_price'];
  $cs_lanshop['lanshop_articles_info'] = $_POST['lanshop_articles_info'];

  $error = 0;
  $errormsg = '';

  if(empty($cs_lanshop['categories_id'])) {
    $error++;
    $errormsg .= $cs_lang['no_cat'] . cs_html_br(1);
  }
  if(empty($cs_lanshop['lanshop_articles_name'])) {
    $error++;
    $errormsg .= $cs_lang['no_name'] . cs_html_br(1);
  }
  if(empty($cs_lanshop['lanshop_articles_price'])) {
    $error++;
    $errormsg .= $cs_lang['no_price'] . cs_html_br(1);
  }
  $where = "categories_id = '" . $cs_lanshop['categories_id'] . "' AND lanshop_articles_name = '";
  $where .= $cs_lanshop['lanshop_articles_name'] . "'";
  $search_article = cs_sql_count(__FILE__,'lanshop_articles',$where);
  if(!empty($search_article)) {
    $error++;
    $errormsg .= $cs_lang['name_used'] . cs_html_br(1);
  }
}
else {
  $cs_lanshop['categories_id'] = 0;
  $cs_lanshop['lanshop_articles_name'] = '';
  $cs_lanshop['lanshop_articles_price'] = '';
  $cs_lanshop['lanshop_articles_info'] = '';
}
if(!isset($_POST['submit'])) {
  echo $cs_lang['body_create'];
}
elseif(!empty($error)) {
  echo $errormsg;
}
else {
  echo $cs_lang['create_done'];
}

echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

if(!empty($error) OR !isset($_POST['submit'])) {

  echo cs_html_form (1,'lanshop_create','lanshop','create');
  echo cs_html_table(1,'forum',1);
  
  echo cs_html_roco(1,'leftc');
  echo cs_icon('folder_yellow') . $cs_lang['category'] . ' *';
  echo cs_html_roco(2,'leftb');
  echo cs_categories_dropdown('lanshop',$cs_lanshop['categories_id']);
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('warehause') . $cs_lang['name'] . ' *';
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('lanshop_articles_name',$cs_lanshop['lanshop_articles_name'],'text',80,40);
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('money') . $cs_lang['price'] . ' *';
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('lanshop_articles_price',$cs_lanshop['lanshop_articles_price'],'text',8,8);
  echo sprintf($cs_lang['cost_cent'],$cs_lanshop['lanshop_articles_price'] / 100);
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('documentinfo') . $cs_lang['info'];
  echo cs_html_br(2);
  echo cs_abcode_smileys('lanshop_articles_info');
  echo cs_html_roco(2,'leftb');
  echo cs_abcode_features('lanshop_articles_info');
  echo cs_html_textarea('lanshop_articles_info',$cs_lanshop['lanshop_articles_info'],'50','6');
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('ksysguard') . $cs_lang['options'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_vote('submit',$cs_lang['submit'],'submit');
  echo cs_html_vote('reset',$cs_lang['reset'],'reset');
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_form(0);
}
else {

  $lanshop_cells = array_keys($cs_lanshop);
  $lanshop_save = array_values($cs_lanshop);
  cs_sql_insert(__FILE__,'lanshop_articles',$lanshop_cells,$lanshop_save);

  cs_redirect($cs_lang['create_done'],'lanshop');
} 

?>