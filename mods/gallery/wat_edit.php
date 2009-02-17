<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');

$img_max['width'] = 200;
$img_max['height'] = 200;
$img_max['size'] = 76800;
$img_filetypes = array('image/pjpeg' => 'jpg','image/jpeg' => 'jpg', 'image/x-png' => 'png');

$wm_id = $_REQUEST['id'];
settype($wm_id,'integer');

if(isset($_POST['submit'])) 
{  
  $cs_gallery_wm['categories_name'] = $_POST['categories_name'];
  $cs_gallery_wm['categories_id'] = $_REQUEST['id'];
  $cs_gallery_wm['categories_mod'] = 'gallery-watermark';
  $cs_gallery_wm['categories_url'] = '';
  $cs_gallery_wm['categories_text'] = '';
  
  $error = 0;
  $errormsg = '';

  if(!empty($_FILES['picture']['tmp_name'])) 
  {
    $error = 1;
    $errormsg = $cs_lang['ext_error'] . cs_html_br(1);
    foreach($img_filetypes AS $allowed => $new_ext) 
    {
      if($allowed == $_FILES['picture']['type']) 
      {
        $errormsg = '';
        $error = 0;
        $extension = $new_ext;
      }
    }
    $img_size = getimagesize($_FILES['picture']['tmp_name']);
    if($img_size[0]>$img_max['width']) 
    { 
      $errormsg .= $cs_lang['too_wide'] . cs_html_br(1);
      $error++;
    }
    if($img_size[1]>$img_max['height']) 
    { 
      $errormsg .= $cs_lang['too_high'] . cs_html_br(1);
      $error++;
    }
    if($_FILES['picture']['size']>$img_max['size']) { 
      $size = $_FILES['picture']['size'] - $img_max['size'];
      $size = cs_filesize($size);
      $errormsg .= sprintf($cs_lang['too_big'], $size) . cs_html_br(1);
      $error++;
    }
  }

  if(empty($cs_gallery_wm['categories_name'])) 
  {
  $error++;
  $errormsg .= $cs_lang['no_name'] . cs_html_br(1);
  }
}
else 
{  
  $cs_gallery_wm['categories_name'] = '';
  $cs_gallery_wm['categories_mod'] = 'gallery-watermak';
  $cs_gallery_wm['categories_url'] = '';
  $cs_gallery_wm['categories_text'] = '';
}  
echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['edit'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc');
if(!isset($_POST['submit'])) 
{
  echo $cs_lang['body_edit'];
}
elseif(!empty($error)) 
{
  echo $errormsg;
}
else 
{
  echo $cs_lang['changes_done'];
}
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

if(!empty($error) OR !isset($_POST['submit'])) 
{
  $from = 'categories';
  $select = 'categories_picture, categories_name'; 
  $where = "categories_id = '" . $wm_id . "'";
  $cs_gallery_wm = cs_sql_select(__FILE__,$from,$select,$where);

  
  echo cs_html_form(1,'watermark_edit','gallery','wat_edit',1);
  echo cs_html_table(1,'forum',1);
    
  echo cs_html_roco(1,'leftc');
  echo cs_icon('images') . $cs_lang['current'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_img('uploads/categories/' . $cs_gallery_wm['categories_picture']);
  echo cs_html_roco(0);
  
  echo cs_html_roco(1,'leftc');
  echo cs_icon('xpaint') . $cs_lang['name'] . ' *';
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('categories_name',$cs_gallery_wm['categories_name'],'text',80,40);
  echo cs_html_roco(0);
  
  echo cs_html_roco(1,'leftc');
  echo cs_icon('download') . $cs_lang['pic_up'] . ' *';
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('picture','','file');
  
  echo cs_html_br(2);
  $matches[1] = $cs_lang['pic_infos'];
  $return_types = '';
  foreach($img_filetypes AS $add => $value) {
    $return_types .= empty($return_types) ? $add : ', ' . $add;
  }
  $matches[2] = $cs_lang['max_width'] . $img_max['width'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_height'] . $img_max['height'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_size'] . cs_filesize($img_max['size']) . cs_html_br(1);
  $matches[2] .= $cs_lang['filetypes'] . $return_types;
  echo cs_abcode_clip($matches);
  echo cs_html_roco(0);
  
  echo cs_html_roco(1,'leftc');
  echo cs_icon('configure') . $cs_lang['more'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_vote('delete','1','checkbox');
  echo $cs_lang['remove'];
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('ksysguard') . $cs_lang['options'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_vote('id',$wm_id,'hidden');
  echo cs_html_vote('submit',$cs_lang['edit'],'submit');
  echo cs_html_vote('reset',$cs_lang['reset'],'reset');
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_form(0);
}
else 
{  
  $gallery_wm_cells = array_keys($cs_gallery_wm);
  $gallery_wm_save = array_values($cs_gallery_wm);
  cs_sql_update(__FILE__,'categories',$gallery_wm_cells,$gallery_wm_save,$wm_id);

  if(!empty($_FILES['picture']['tmp_name'])) 
  {
    $where = "categories_name = '" . cs_sql_escape($cs_gallery_wm['categories_name']) . "' AND categories_mod = 'gallery-watermark'";
    $getid = cs_sql_select(__FILE__,'categories','categories_id',$where);
    $filename = 'watermark-' . $getid['categories_id'] . '.' . $extension;
    cs_upload('categories',$filename,$_FILES['picture']['tmp_name']);
  
    $cs_gallery_wm2['categories_picture'] = $filename;
    $gallery_wm2_cells = array_keys($cs_gallery_wm2);
    $gallery_wm2_save = array_values($cs_gallery_wm2);      
    cs_sql_update(__FILE__,'categories',$gallery_wm2_cells,$gallery_wm2_save,$getid['categories_id']);
  }
  
  cs_redirect($cs_lang['changes_done'],'gallery','manage','watermark');
}


?>