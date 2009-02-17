<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');

$img_max['width'] = 200;
$img_max['height'] = 200;
$img_max['size'] = 76800;
$img_filetypes = array('jpg','png');

if(isset($_POST['submit'])) 
{  
  $cs_categories['categories_name'] = $_POST['categories_name'];
  $cs_categories['categories_mod'] = 'gallery-watermark';
  $cs_categories['categories_url'] = '';
  $cs_categories['categories_text'] = '';
  
  $error = 0;
  $errormsg = '';

  if(!empty($_FILES['picture']['tmp_name'])) 
  {
    $img_size = getimagesize($_FILES['picture']['tmp_name']);
      switch($img_size[2])
      {
      case 2:
        $ext = 'jpg'; break;
      case 3:
        $ext = 'png'; break;
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

  if(empty($cs_categories['categories_name'])) 
  {
    $error++;
    $errormsg .= $cs_lang['no_name'] . cs_html_br(1);
  }

  $where = "categories_name = '" . cs_sql_escape($cs_categories['categories_name']) . "' AND categories_mod = 'gallery-watermark'";
  $search = cs_sql_count(__FILE__,'categories',$where);
  if(!empty($search)) 
  {
    $error++;
    $errormsg .= $cs_lang['watermark_exists'] . cs_html_br(1);
  }
}
else 
{  
  $cs_categories['categories_name'] = '';
  $cs_categories['categories_mod'] = 'gallery';
  $cs_categories['categories_url'] = '';
  $cs_categories['categories_text'] = '';
}  
echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_create'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc');
if(!isset($_POST['submit'])) 
{
  echo $cs_lang['body_create'];
}
elseif(!empty($error)) 
{
  echo $errormsg;
}
else 
{
  echo $cs_lang['create_done'];
}
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

if(!empty($error) OR !isset($_POST['submit'])) 
{
  echo cs_html_form(1,'watermark_create','gallery','wat_create',1);
  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'leftc');
  echo cs_icon('xpaint') . $cs_lang['name'] . ' *';
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('categories_name',$cs_categories['categories_name'],'text',80,40);
  echo cs_html_roco(0);
  
  echo cs_html_roco(1,'leftc');
  echo cs_icon('download') . $cs_lang['pic_up'] . ' *';
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('picture','','file');
  
  echo cs_html_br(2);
  $matches[1] = $cs_lang['pic_infos'];
  $return_types = '';
  foreach($img_filetypes AS $add) {
    $return_types .= empty($return_types) ? $add : ', ' . $add;
  }
  $matches[2] = $cs_lang['max_width'] . $img_max['width'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_height'] . $img_max['height'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_size'] . cs_filesize($img_max['size']) . cs_html_br(1);
  $matches[2] .= $cs_lang['filetypes'] . $return_types;
  echo cs_abcode_clip($matches);

  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('ksysguard') . $cs_lang['options'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_vote('submit',$cs_lang['create'],'submit');
  echo cs_html_vote('reset',$cs_lang['reset'],'reset');
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_form(0);
}
else 
{  
  $categories_cells = array_keys($cs_categories);
  $categories_save = array_values($cs_categories);
  cs_sql_insert(__FILE__,'categories',$categories_cells,$categories_save);

  if(!empty($_FILES['picture']['tmp_name'])) 
  {
    $where = "categories_name = '" . $cs_categories['categories_name'] . "' AND categories_mod = 'gallery-watermark'";
    $getid = cs_sql_select(__FILE__,'categories','categories_id',$where);
    $filename = 'watermark-' . $getid['categories_id'] . '.' . $ext;
    cs_upload('categories',$filename,$_FILES['picture']['tmp_name']);
  
    $cs_categories2['categories_picture'] = $filename;
    $categories2_cells = array_keys($cs_categories2);
    $categories2_save = array_values($cs_categories2);      
    cs_sql_update(__FILE__,'categories',$categories2_cells,$categories2_save,$getid['categories_id']);
  }
  
  cs_redirect($cs_lang['create_done'],'gallery','manage','watermark');
}

?>