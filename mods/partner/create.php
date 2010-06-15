<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('partner');
require_once('mods/categories/functions.php');

$op_partner = cs_sql_option(__FILE__,'partner');
$img_filetypes = array('image/pjpeg' => 'jpg','image/jpeg' => 'jpg','image/gif' => 'gif');
$error = '';
$data = array();
$files = cs_files();

if (!empty($_POST['submit'])) {
  $data['partner']['partner_name'] = empty($_POST['partner_name']) ? '' : $_POST['partner_name'];
  $data['partner']['partner_text'] = empty($_POST['partner_text']) ? '' : $_POST['partner_text'];
  $data['partner']['partner_url'] = empty($_POST['partner_url']) ? '' : $_POST['partner_url'];
  $data['partner']['partner_alt'] = empty($_POST['partner_alt']) ? '' : $_POST['partner_alt'];
  $data['partner']['partner_priority'] = empty($_POST['partner_priority']) ? '' : $_POST['partner_priority'];
  $categories_id = empty($_POST['categories_name']) ? $_POST['categories_id'] : cs_categories_create('partner',$_POST['categories_name']);
  
  if(empty($_POST['partner_name'])) { $error .= $cs_lang['no_name'] .  cs_html_br(1); }
  if(empty($_POST['partner_text'])) { $error .= $cs_lang['no_text'] .  cs_html_br(1); }
  if(empty($_POST['partner_url'])) { $error .= $cs_lang['no_url'] .  cs_html_br(1); }
  if(empty($_POST['partner_alt'])) { $error .= $cs_lang['no_alt'] .  cs_html_br(1); }
  if(empty($_POST['partner_priority'])) { $error .= $cs_lang['no_priority'] .  cs_html_br(1); }
  if(empty($categories_id)) { $error .= $cs_lang['no_cat'] . cs_html_br(1); }
  
  // check nav-image
  if (!empty($files['partner_nimg']['tmp_name'])) {
    $img_size = getimagesize($files['partner_nimg']['tmp_name']);
    if(!empty($files['partner_nimg']['tmp_name']) AND empty($img_size) OR $img_size[2] > 3) {
      $error .= $cs_lang['ext_error'] . cs_html_br(1);
    } elseif(!empty($files['partner_nimg']['tmp_name'])) {
      switch($img_size[2]) {
        case 1:
          $extension = 'gif'; break;
        case 2:
          $extension = 'jpg'; break;
        case 3:
          $extension = 'png'; break;
      }
    
      if($img_size[0] > $op_partner['def_width_navimg']) {
        $error .= $cs_lang['too_wide_nimg'] . cs_html_br(1);
      }
      
      if($img_size[1] > $op_partner['def_height_navimg']) { 
        $error .= $cs_lang['too_high_nimg'] . cs_html_br(1);
      }
      
      if($files['partner_nimg']['size'] > $op_partner['max_size_navimg']) { 
        $error .= $cs_lang['too_big_nimg']  . cs_html_br(1);
      }
    }
  }
  
  // check list_image
  if (!empty($files['partner_limg']['tmp_name'])) {
    $img_size = getimagesize($files['partner_limg']['tmp_name']);
    if(!empty($files['partner_limg']['tmp_name']) AND empty($img_size) OR $img_size[2] > 3) {
      $error .=  $cs_lang['ext_error'] . cs_html_br(1);
    } elseif(!empty($files['partner_limg']['tmp_name'])) {
      switch($img_size[2]) {
        case 1:
          $extension = 'gif'; break;
        case 2:
          $extension = 'jpg'; break;
        case 3:
          $extension = 'png'; break;
      }
    
      if($img_size[0] > $op_partner['def_width_listimg']) {
        $error .= $cs_lang['too_wide_limg'] . cs_html_br(1);
      }
      
      if($img_size[1] > $op_partner['def_height_listimg']) { 
        $error .= $cs_lang['too_high_limg'] . cs_html_br(1);
      }
      
      if($files['partner_limg']['size'] > $op_partner['max_size_listimg']) { 
        $error .= $cs_lang['too_big_limg']  . cs_html_br(1);
      }
    }
  }
  
  // check rotation-image
  if (!empty($files['partner_rimg']['tmp_name'])) {
    $img_size = getimagesize($files['partner_rimg']['tmp_name']);
    if(!empty($files['partner_rimg']['tmp_name']) AND empty($img_size) OR $img_size[2] > 3) {
      $error .= $cs_lang['ext_error'] . cs_html_br(1);
    } elseif(!empty($files['partner_rimg']['tmp_name'])) {
      switch($img_size[2]) {
        case 1:
          $extension = 'gif'; break;
        case 2:
          $extension = 'jpg'; break;
        case 3:
          $extension = 'png'; break;
      }
    
      if($img_size[0] > $op_partner['def_width_rotimg']) {
        $error .= $cs_lang['too_wide_rimg'] . cs_html_br(1);
      }
      
      if($img_size[1] > $op_partner['def_height_rotimg']) { 
        $error .= $cs_lang['too_high_rimg'] . cs_html_br(1);
      }
      
      if($files['partner_nimg']['size'] > $op_partner['max_size_rotimg']) { 
        $error .= $cs_lang['too_big_rimg']  . cs_html_br(1);
      }
    }
  }
  
} else {
  $data['partner']['partner_name'] = '';
  $data['partner']['partner_text'] = '';
  $data['partner']['partner_url'] = '';
  $data['partner']['partner_alt'] = '';
  $data['partner']['partner_priority'] = '1';
  $categories_id = '';
}
if(empty($_POST['submit']) || !empty($error)) {
  $data['form']['create'] = cs_url('partner','create');
  $data['head']['body_text'] = !empty($error) ? $error : $cs_lang['body_text'];
    $data['categories']['dropdown'] = cs_categories_dropdown('partner',$categories_id);
  $data['abcode']['smileys'] = cs_abcode_smileys('partner_text');
  $data['abcode']['features'] = cs_abcode_features('partner_text');

     $matches_n[1] = $cs_lang['infobox'];
  $return_types = '';
  foreach($img_filetypes AS $add => $value) {
    $return_types .= empty($return_types) ? $add : ', ' . $add;
  }
  $matches_n[2] = $cs_lang['max_width'] . $op_partner['def_width_navimg'] . ' px' . cs_html_br(1);
  $matches_n[2] .= $cs_lang['max_height'] . $op_partner['def_height_navimg'] . ' px' . cs_html_br(1);
  $matches_n[2] .= $cs_lang['max_size'] . cs_filesize($op_partner['max_size_navimg']) . cs_html_br(1);
  $matches_n[2] .= $cs_lang['filetypes'] . $return_types;
  $data['clip']['nimg'] = cs_abcode_clip($matches_n);
  
     $matches_l[1] = $cs_lang['infobox'];
  $return_types = '';
  foreach($img_filetypes AS $add => $value) {
    $return_types .= empty($return_types) ? $add : ', ' . $add;
  }
  $matches_l[2] = $cs_lang['max_width'] . $op_partner['def_width_listimg'] . ' px' . cs_html_br(1);
  $matches_l[2] .= $cs_lang['max_height'] . $op_partner['def_height_listimg'] . ' px' . cs_html_br(1);
  $matches_l[2] .= $cs_lang['max_size'] . cs_filesize($op_partner['max_size_listimg']) . cs_html_br(1);
  $matches_l[2] .= $cs_lang['filetypes'] . $return_types;
  $data['clip']['limg'] = cs_abcode_clip($matches_l);
  
     $matches_r[1] = $cs_lang['infobox'];
  $return_types = '';
  foreach($img_filetypes AS $add => $value) {
    $return_types .= empty($return_types) ? $add : ', ' . $add;
  }
  $matches_r[2] = $cs_lang['max_width'] . $op_partner['def_width_rotimg'] . ' px' . cs_html_br(1);
  $matches_r[2] .= $cs_lang['max_height'] . $op_partner['def_height_rotimg'] . ' px' . cs_html_br(1);
  $matches_r[2] .= $cs_lang['max_size'] . cs_filesize($op_partner['max_size_rotimg']) . cs_html_br(1);
  $matches_r[2] .= $cs_lang['filetypes'] . $return_types;
  $data['clip']['rimg'] = cs_abcode_clip($matches_r);
  
echo cs_subtemplate(__FILE__,$data,'partner','create');

} elseif (!empty($_POST['submit']) && empty($error)) {

  
  $cells = array('partner_name','categories_id', 'partner_url','partner_alt','partner_text','partner_priority');
  $values = array($_POST['partner_name'],$categories_id, $_POST['partner_url'],$_POST['partner_alt'],$_POST['partner_text'],$_POST['partner_priority']);
  cs_sql_insert(__FILE__,'partner',$cells,$values);

  // upload navlist-image
    $partner_id = mysql_insert_id();
    
    $where = "partner_id = '".$partner_id."'";
    $getid = cs_sql_select(__FILE__,'partner','partner_id',$where);
    
  if(!empty($files['partner_nimg']['tmp_name'])) {
    $filename_navimg = 'navbanner-' . $getid['partner_id'] . '.' . $extension;
    cs_upload('partner',$filename_navimg,$files['partner_nimg']['tmp_name'],0);

    $cells_navimg = array('partner_nimg');
    $values_navimg = array($filename_navimg);
    cs_sql_update(__FILE__,'partner',$cells_navimg,$values_navimg,$getid['partner_id']);
  }
    
  if(!empty($files['partner_limg']['tmp_name'])) {
  
    $filename_listimg = 'listbanner-' . $getid['partner_id'] . '.' . $extension;
    cs_upload('partner',$filename_listimg,$files['partner_limg']['tmp_name'],0);

    $cells_listimg = array('partner_limg');
    $values_listimg = array($filename_listimg);
    cs_sql_update(__FILE__,'partner',$cells_listimg,$values_listimg,$getid['partner_id']);
    
  }
  
  if(!empty($files['partner_rimg']['tmp_name'])) {
  
    $filename_rotimg = 'rotbanner-' . $getid['partner_id'] . '.' . $extension;
    cs_upload('partner',$filename_rotimg,$files['partner_rimg']['tmp_name'],0);

    $cells_rotimg = array('partner_rimg');
    $values_rotimg = array($filename_rotimg);
    cs_sql_update(__FILE__,'partner',$cells_rotimg,$values_rotimg,$getid['partner_id']);
    
  }
  cs_ajaxfiles_clear();
  
  cs_redirect($cs_lang['create_done'],'partner');
}
