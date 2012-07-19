<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('articles');

require_once 'mods/categories/functions.php';
require_once 'mods/pictures/functions.php';

$data['if']['head'] = 1;
$data['if']['preview'] = false;
$files = cs_files();

if(isset($_POST['submit']) OR isset($_POST['preview'])) {

    $cs_articles['categories_id'] = empty($_POST['categories_name']) ? $_POST['categories_id'] : 
  cs_categories_create('articles',$_POST['categories_name']);

  $cs_articles['articles_com'] = isset($_POST['articles_com']) ? $_POST['articles_com'] : 0;
  $cs_articles['articles_navlist'] = isset($_POST['articles_navlist']) ? $_POST['articles_navlist'] : 0;
  $cs_articles['articles_fornext'] = isset($_POST['articles_fornext']) ? $_POST['articles_fornext'] : 0;
  $cs_articles['articles_headline'] = $_POST['articles_headline'];
  $cs_articles['articles_time'] = $_POST['articles_time'];
  $cs_articles['articles_text'] = empty($cs_main['rte_html']) ? $_POST['articles_text'] : cs_abcode_inhtml($_POST['articles_text'], 'add');

  $categories = cs_sql_select(__FILE__,'categories','categories_picture',"categories_id = '" . $cs_articles['categories_id'] . "'");
  
  if(!empty($_POST['articles_newtime'])) {
    $cs_articles['articles_time'] = cs_time();
    $articles_newtime = 1;
  }

  $error = 0;
  $errormsg = '';

  if(empty($cs_articles['categories_id'])) {
    $error++;
    $errormsg .= $cs_lang['no_cat'] . cs_html_br(1);
  }
  if(empty($cs_articles['articles_headline'])) {
    $error++;
    $errormsg .= $cs_lang['no_headline'] . cs_html_br(1);
  }
  if(empty($cs_articles['articles_text'])) {
    $error++;
    $errormsg .= $cs_lang['no_text'] . cs_html_br(1);
  }
}
else {
  $articles_id = $_GET['id'];
  settype($articles_id,'integer');
  $cells = 'categories_id, articles_headline, articles_text, users_id, articles_time, articles_com, articles_navlist, articles_fornext';
  $cs_articles = cs_sql_select(__FILE__,'articles',$cells,"articles_id = '" . $articles_id . "'");
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
  $data['if']['catimg'] = empty($categories['categories_picture']) ? false : true;
  $data['cat']['url_catimg'] = empty($data['if']['catimg']) ? '' : 'uploads/categories/'.$categories['categories_picture'];
  $data['art']['articles_text_preview'] = cs_secure($cs_articles['articles_text'],1,1,1,1);
}
if(empty($error)) {
  $data['head']['error'] = '';
  $data['head']['body'] = $cs_lang['body_edit'];
}

if(!empty($error) OR !isset($_POST['submit'])) {

  $data['data']['articles_id'] = empty($_POST['id']) ? $_GET['id'] : $_POST['id'];
  $data['data']['articles_time'] = $cs_articles['articles_time'];
  $data['data']['articles_headline'] = $cs_articles['articles_headline'];
  $data['data']['categories_id'] = $cs_articles['categories_id'];
  $data['data']['articles_text'] = $cs_articles['articles_text'];
  
  if(empty($cs_main['rte_html'])) {
    $data['if']['rte_html'] = 0;
    $data['if']['no_rte_html'] = 1;
    $data['abcode']['features'] = cs_abcode_features('articles_text', 1, 1);
  } else {
    $data['if']['rte_html'] = 1;
    $data['if']['no_rte_html'] = 0;
    $data['articles']['content'] = cs_rte_html('articles_text',$data['data']['articles_text']);
  }
  
  $data['data']['articles_com_checked'] = empty($cs_articles['articles_com']) ? '' : 'checked="checked"';
  $data['data']['articles_navlist_checked'] = empty($cs_articles['articles_navlist']) ? '' : 'checked="checked"';
  $data['data']['articles_fornext_checked'] = empty($cs_articles['articles_fornext']) ? '' : 'checked="checked"';
  
  $data['pictures']['select'] = cs_pictures_select('articles', $data['data']['articles_id']);
  $data['categories']['dropdown'] = cs_categories_dropdown('articles',$cs_articles['categories_id']);

  echo cs_subtemplate(__FILE__,$data,'articles','edit');
  
} else {
  
  $articles_id = (int) $_POST['id'];
  
  $articles_cells = array_keys($cs_articles);
  $articles_save = array_values($cs_articles);
  cs_sql_update(__FILE__,'articles',$articles_cells,$articles_save,$articles_id);

  if(!empty($files['picture'])) cs_pictures_upload($files['picture'], 'articles', $articles_id);

  cs_redirect($cs_lang['changes_done'], 'articles') ;
}