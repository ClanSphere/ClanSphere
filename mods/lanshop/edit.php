<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanshop');
$cs_post = cs_post('id');
$cs_get = cs_get('id');
$data = array();

require_once('mods/categories/functions.php');

$lanshop_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $lanshop_id = $cs_post['id'];

$cells = 'categories_id, lanshop_articles_name, lanshop_articles_price, lanshop_articles_info';
$cs_lanshop = cs_sql_select(__FILE__,'lanshop_articles',$cells,'lanshop_articles_id = ' . $lanshop_id);


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
  $where .= $cs_lanshop['lanshop_articles_name'] . "' AND lanshop_articles_id != '" . $lanshop_id . "'";
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
  $data['ls']['price'] = sprintf($cs_lang['cost'],$cs_lanshop['lanshop_articles_price'] / 100);

  $data['abcode']['smileys'] = cs_abcode_smileys('lanshop_articles_info');
  $data['abcode']['features'] = cs_abcode_features('lanshop_articles_info');
  
  $data['lanshop']['id'] = $lanshop_id;
  
 echo cs_subtemplate(__FILE__,$data,'lanshop','edit');
}
else {

  $lanshop_cells = array_keys($cs_lanshop);
  $lanshop_save = array_values($cs_lanshop);
 cs_sql_update(__FILE__,'lanshop_articles',$lanshop_cells,$lanshop_save,$lanshop_id);
  
 cs_redirect($cs_lang['changes_done'], 'lanshop') ;
} 

?>
