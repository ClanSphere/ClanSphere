<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('links');

$files_gl = cs_files();

$cs_post = cs_post('id');
$cs_get = cs_get('id');
$data = array();

require_once('mods/categories/functions.php');

$links_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $links_id = $cs_post['id'];

$img_max['width'] = 470;
$img_max['height'] = 100;
$img_max['size'] = 256000;
$img_filetypes = array('gif','jpg','png');

$data['if']['abcode'] = FALSE;
$data['if']['rte_html'] = FALSE;
$data['if']['img'] = FALSE;
$data['if']['allow_del'] = FALSE;

$select = 'links_name, categories_id, links_url, links_stats, links_info, links_sponsor, links_banner';
$cs_links = cs_sql_select(__FILE__,'links',$select,"links_id = '" . $links_id . "'");


if(isset($_POST['submit'])) {

  $cs_links['links_name'] = $_POST['links_name'];
  $cs_links['categories_id'] = empty($_POST['categories_name']) ? $_POST['categories_id'] : cs_categories_create('links', $_POST['categories_name']);
  $cs_links['links_url'] = $_POST['links_url'];
  $cs_links['links_stats'] = $_POST['links_stats'];
  $cs_links['links_info'] = empty($cs_main['rte_html']) ? $_POST['links_info'] : cs_abcode_inhtml($_POST['links_info'], 'add');
  $cs_links['links_sponsor'] = isset($_POST['links_sponsor']) ? $_POST['links_sponsor'] : 0;
  $del_banner = isset($_POST['del_banner']) ? $_POST['del_banner'] : 0;
  
  $error = '';
  
  //check name
  if(!empty($cs_links['links_name'])) {
    $where = "links_name = '" . $cs_links['links_name'] ."' AND links_id != '" . $links_id . "'";
    $check_name = cs_sql_count(__FILE__,'links',$where);
    if(!empty($check_name))
      $error .= sprintf($cs_lang['name_exists'],$cs_links['links_name']) . cs_html_br(1);
  } else {
    $error .= $cs_lang['no_name'] . cs_html_br(1);
  }
    
  if(empty($cs_links['categories_id']))
    $error .= $cs_lang['no_cat'] . cs_html_br(1);

  //check url
  if(!empty($cs_links['links_url'])) {
    $where = "links_url = '" . $cs_links['links_url'] . "' AND links_id != '" . $links_id . "'";
    $check_url = cs_sql_count(__FILE__,'links',$where);
    if(!empty($check_url)) {
      $link_exists = cs_sql_select(__FILE__,'links','links_name',$where);
      $url = cs_html_link($cs_links['links_url'],$cs_links['links_url']);
      $error .= sprintf($cs_lang['url_exists'],$link_exists['links_name'],$url) . cs_html_br(1);
    }
  } else {
    $error .= $cs_lang['no_url'] . cs_html_br(1);
  }

  if(empty($cs_links['links_stats']))
    $error .= $cs_lang['no_status'] . cs_html_br(1);
  if(empty($cs_links['links_info']))
    $error .= $cs_lang['no_info'] . cs_html_br(1);

  $img_size = false;
  if(!empty($files_gl['symbol']['tmp_name']))
    $img_size = getimagesize($files_gl['symbol']['tmp_name']);

  if(!empty($files_gl['symbol']['tmp_name']) AND empty($img_size) OR $img_size[2] > 3) {
    $error .= $cs_lang['ext_error'] . cs_html_br(1);
  }
  elseif(!empty($files_gl['symbol']['tmp_name'])) {
    switch($img_size[2]) {
     case 1:
      $ext = 'gif'; break;
     case 2:
      $ext = 'jpg'; break;
     case 3:
      $ext = 'png'; break;
    }
    if($img_size[0] > $img_max['width'])
      $error .= $cs_lang['too_wide'] . cs_html_br(1);
    if($img_size[1] > $img_max['height'])
      $error .= $cs_lang['too_high'] . cs_html_br(1);
    if($files_gl['symbol']['size'] > $img_max['size'])
      $error .= $cs_lang['too_big'] . cs_html_br(1);
  }

}

if(!isset($_POST['submit']))
  $data['head']['body'] = $cs_lang['body_create'];
elseif(!empty($error))
  $data['head']['body'] = $error;


if(!empty($error) OR !isset($_POST['submit'])) {

  $data['data'] = $cs_links;
  $data['cat']['dropdown'] = cs_categories_dropdown('links',$cs_links['categories_id']);

  $linksstat[0]['links_stats'] = 'on';
  $linksstat[0]['name'] = $cs_lang['online'];
  $linksstat[1]['links_stats'] = 'off';
  $linksstat[1]['name'] = $cs_lang['offline'];
  $data['status']['dropdown'] = cs_dropdown('links_stats','name',$linksstat,$cs_links['links_stats']);

  if(empty($cs_main['rte_html'])) {
    $data['if']['abcode'] = TRUE;
    $data['abcode']['smileys'] = cs_abcode_smileys('links_info', 1);
    $data['abcode']['features'] = cs_abcode_features('links_info', 1, 1);
  } else {
    $data['if']['rte_html'] = TRUE;
    $data['rte']['html'] = cs_rte_html('links_info',$cs_links['links_info']);
  }
  
  if(!empty($cs_links['links_banner'])) {
    $data['if']['img'] = TRUE;
    $data['if']['allow_del'] = TRUE;
    $src = 'uploads/links/' . $cs_links['links_banner'];
    $data['links']['img'] = cs_html_img($src);
  }
  
  $matches[1] = $cs_lang['pic_infos'];
  $return_types = '';
  foreach($img_filetypes AS $add) {
    $return_types .= empty($return_types) ? $add : ', ' . $add;
  }
  $matches[2] = $cs_lang['max_width'] . $img_max['width'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_height'] . $img_max['height'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_size'] . cs_filesize($img_max['size']) . cs_html_br(1);
  $matches[2] .= $cs_lang['filetypes'] . $return_types;
  $data['picup']['clip'] = cs_abcode_clip($matches);

  $data['check']['sponsor'] = empty($cs_links['links_sponsor']) ? '' : 'checked="checked"';
  $data['links']['id'] = $links_id;

 echo cs_subtemplate(__FILE__,$data,'links','edit');
}
else {

  $cells = array_keys($cs_links);
  $save = array_values($cs_links);
 cs_sql_update(__FILE__,'links',$cells,$save,$links_id);

  if(!empty($files_gl['symbol']['tmp_name'])) {
    $filename = $links_id . '.' . $ext;
   cs_upload('links',$filename,$files_gl['symbol']['tmp_name']);

    $file_cell = array('links_banner');
    $file_save = array($filename);      
   cs_sql_update(__FILE__,'links',$file_cell,$file_save,$links_id);
  }
  
  if(empty($files_gl['symbol']['tmp_name']) AND $del_banner == 1) {
   cs_unlink('links', $cs_links['links_banner']);
    $banner_cells = array('links_banner');
    $banner_save = array();
   cs_sql_update(__FILE__,'links',$banner_cells,$banner_save,$links_id);
  }

 cs_redirect($cs_lang['edit_done'],'links');
}