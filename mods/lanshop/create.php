<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanshop');
$data = array();

require_once('mods/categories/functions.php');

$cs_lanshop['categories_id'] = 0;
$cs_lanshop['lanshop_articles_name'] = '';
$cs_lanshop['lanshop_articles_price'] = '';
$cs_lanshop['lanshop_articles_info'] = '';

if(isset($_POST['submit'])) {

  $cs_lanshop['categories_id'] = empty($_POST['categories_name']) ? $_POST['categories_id'] : 
  cs_categories_create('lanshop',$_POST['categories_name']);

  $cs_lanshop['lanshop_articles_name'] = $_POST['lanshop_articles_name'];
  $cs_lanshop['lanshop_articles_price'] = $_POST['lanshop_articles_price'];
  $cs_lanshop['lanshop_articles_info'] = $_POST['lanshop_articles_info'];

  $error = '';

  if(empty($cs_lanshop['categories_id']))
    $error .= $cs_lang['no_cat'] . cs_html_br(1);
  if(empty($cs_lanshop['lanshop_articles_name']))
    $error .= $cs_lang['no_name'] . cs_html_br(1);
  if(empty($cs_lanshop['lanshop_articles_price']))
    $error .= $cs_lang['no_price'] . cs_html_br(1);
  
  $where = "categories_id = '" . $cs_lanshop['categories_id'] . "' AND lanshop_articles_name = '";
  $where .= $cs_lanshop['lanshop_articles_name'] . "'";
  $search_article = cs_sql_count(__FILE__,'lanshop_articles',$where);
  if(!empty($search_article))
    $error .= $cs_lang['name_used'] . cs_html_br(1);

}

if(!isset($_POST['submit']))
	$data['head']['body'] = $cs_lang['body_create'];
elseif(!empty($error))
	$data['head']['body'] = $error;


if(!empty($error) OR !isset($_POST['submit'])) {

	$data['data'] = $cs_lanshop;

  $data['ls']['categories'] = cs_categories_dropdown('lanshop',$cs_lanshop['categories_id']);
  $data['ls']['price'] = sprintf($cs_lang['cost_cent'],$cs_lanshop['lanshop_articles_price'] / 100);

  $data['abcode']['smileys'] = cs_abcode_smileys('lanshop_articles_info');
  $data['abcode']['features'] = cs_abcode_features('lanshop_articles_info');
  
 echo cs_subtemplate(__FILE__,$data,'lanshop','create');
}
else {

  $lanshop_cells = array_keys($cs_lanshop);
  $lanshop_save = array_values($cs_lanshop);
 cs_sql_insert(__FILE__,'lanshop_articles',$lanshop_cells,$lanshop_save);

 cs_redirect($cs_lang['create_done'],'lanshop');
} 

?>