<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');

require_once('mods/gallery/functions.php');

$cs_gallery['users_id'] = $account['users_id'];
$cs_gallery['gallery_time'] = cs_time();
$cs_option = cs_sql_option(__FILE__,'gallery');

$advance = isset($_POST['advance-']) ? 0 : 1;
$advance = isset($_POST['advance+']) ? 1 : 0;

$error = 0;
$g_error = 0;
$f_error = 0;
$message = '';

$img_filetypes = array('gif','jpg','png');

if(isset($_POST['submit']) OR isset($_POST['advance-']) OR isset($_POST['advance+']))
{
  $file_up = isset($_POST['file_up']) ? $_POST['file_up'] : 0;
  if ($file_up == 0)
  {
    $cs_gallery['gallery_name'] = $_FILES['picture']['name'];
  }
  elseif ($file_up == 1)
  {
    $cs_gallery['gallery_name'] = $_POST['gallery_name'];
  }
  $cs_gallery['gallery_titel'] = $_POST['gallery_titel'];
  $cs_gallery['folders_id'] = empty($_POST['folders_name']) ? $_POST['folders_id'] : cs_categories_create('gallery',$_POST['categories_name']);
  $cs_gallery['gallery_access'] =  isset($_POST['gallery_access']) ? $_POST['gallery_access'] : 0;
  $cs_gallery['gallery_watermark'] = isset($_POST['gallery_watermark']) ? $_POST['gallery_watermark'] : '';
  $cs_gallery['gallery_description'] = $_POST['gallery_description'];
  $cs_gallery['gallery_status'] =  isset($_POST['gallery_status']) ? $_POST['gallery_status'] : 1;
  $cs_gallery['gallery_vote'] = isset($_POST['gallery_vote']) ? $_POST['gallery_vote'] : 1;
  $cs_gallery['gallery_close'] = isset($_POST['gallery_close']) ? $_POST['gallery_close'] : 0;
  $gray = isset($_POST['gray']) ? $_POST['gray'] : 0;
  $download = isset($_POST['download']) ? $_POST['download'] : 1;
  $download_original = isset($_POST['download_original']) ? $_POST['download_original'] : 1;
  $cs_gallery['gallery_download'] = $download . '|--@--|' . $download_original;
  $gallery_watermark_trans = isset($_POST['gallery_watermark_trans']) ? $_POST['gallery_watermark_trans'] : '20';
  $watermark_pos = isset($_POST['watermark_pos']) ? $_POST['watermark_pos'] : '1';
}
else
{
  $cs_gallery['gallery_name'] = '';
  $cs_gallery['gallery_titel'] = '';
  $cs_gallery['categories_id'] = 0;
  $cs_gallery['gallery_access'] = 0;
  $cs_gallery['gallery_watermark'] = '';
  $gallery_watermark_trans = '20';
  $cs_gallery['gallery_description'] = '';
  $cs_gallery['gallery_close'] = '0';
  $cs_gallery['gallery_vote'] = '1';
  $download = '1';
  $download_original = '1';
  $gray = '0';
  $watermark_pos = '1';
  $file_up = 0;
}

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
$link = cs_link($cs_lang['mod'],'gallery','manage');
echo $link . ' - ' . $cs_lang['pic'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');

if(isset($_POST['submit']))
{
  if($file_up == 0 AND empty($_FILES['picture']['tmp_name']))
  {
    $g_error++;
    $f_error++;
    $message .= $cs_lang['error_pic'] . cs_html_br(1);
  }

  if(!empty($_POST['gallery_watermark']))
  {
    $watermark_pos = $_POST['watermark_pos'];
    $watermark_trans = $_POST['gallery_watermark_trans'];
    $cs_gallery['gallery_watermark_pos'] = $watermark_pos . '|--@--|' . $watermark_trans;
  }
  else
  {
    $cs_gallery['gallery_watermark_pos'] = '';
  }
  if(empty($_POST['gallery_titel']))
  {
    $g_error++;
    $message .= $cs_lang['no_titel'] . cs_html_br(1);
  }

  if ($file_up == 0)
  {
    $check_file = $cs_gallery['gallery_name'];
    $cs_gallery_pic_check = cs_sql_select(__FILE__,'gallery','*',"gallery_name = '" . cs_sql_escape($check_file) . "'",'gallery_id DESC',0,0);
    $gallery_loop_pic_check = count($cs_gallery_pic_check);

    if(!empty($gallery_loop_pic_check))
    {
      $g_error++;
      $f_error++;
      $message .= $cs_lang['img_is'] . cs_html_br(1);
    }
  }
  if(empty($_POST['folders_id']))
  {
    $g_error++;
    $message .= $cs_lang['no_cat'] . cs_html_br(1);
  }
  if(empty($_POST['gallery_description']))
  {
    $g_error++;
    $message .= $cs_lang['no_description'] . cs_html_br(1);
  }
  if($file_up == 0)
  {
    $img_size = getimagesize($_FILES['picture']['tmp_name']);
    if(!empty($_FILES['picture']['tmp_name']) AND empty($img_size) OR $img_size[2] > 3)
    {
      $message .= $cs_lang['ext_error'] . cs_html_br(1);
      $error++;
      $f_error++;
    }
    elseif(!empty($_FILES['picture']['tmp_name']))
    {
        $filename = $_FILES['picture']['name'];
      if($img_size[0]>$cs_option['width'])
      {
        $message .= $cs_lang['too_wide'] . cs_html_br(1);
        $error++;
      }
      if($img_size[1]>$cs_option['height'])
      {
        $message .= $cs_lang['too_high'] . cs_html_br(1);
        $error++;
      }
      if($_FILES['picture']['size']>$cs_option['size'])
      {
        $size = $_FILES['picture']['size'] - $cs_option['size'];
        $size = cs_filesize($size);
        $message .= sprintf($cs_lang['too_big'], $size) . cs_html_br(1);
        $error++;
      }
      if(extension_loaded('gd') AND !empty($gray))
      {
        require_once('mods/gallery/gd_2.php');
        cs_gray($_FILES['picture']['tmp_name']);
      }
      if(empty($f_error) AND empty($error) AND cs_upload('gallery/pics', $filename, $_FILES['picture']['tmp_name']) OR empty($f_error) AND !empty($error) AND extension_loaded('gd') AND cs_resample($_FILES['picture']['tmp_name'], 'uploads/gallery/pics/' . $filename, $cs_option['width'], $cs_option['height']))
      {
        if(empty($f_error) AND empty($error) AND !extension_loaded('gd') AND cs_upload('gallery/thumbs', 'Thumb_' . $filename, $_FILES['picture_thumb']['tmp_name']) OR empty($f_error) AND empty($error) AND extension_loaded('gd') AND cs_resample('uploads/gallery/pics/' . $filename, 'uploads/gallery/thumbs/' . 'Thumb_' . $filename, $cs_option['thumbs'], $cs_option['thumbs']) OR empty($f_error) AND !empty($error) AND extension_loaded('gd') AND cs_resample('uploads/gallery/pics/' . $filename, 'uploads/gallery/thumbs/' . 'Thumb_' . $filename, $cs_option['thumbs'], $cs_option['thumbs']))
        {
          $error = 0;
          $file_up = 1;
        }
        else
        {
          $error = 1;
          $message .= $cs_lang['upload_error'] . cs_html_br(1);
        }
      }
      else
      {
        $error = 1;
        $message .= $cs_lang['upload_error'] . cs_html_br(1);
      }
    }
  }
  if(empty($error) AND empty($g_error))
  {
    $gallery_cells = array_keys($cs_gallery);
    $gallery_save = array_values($cs_gallery);
    cs_sql_insert(__FILE__,'gallery',$gallery_cells,$gallery_save);
    
      cs_redirect($cs_lang['create_done'],'gallery');
  }
}

if(!empty($g_error) OR !empty($error) OR !empty($f_error) OR $advance <= 1)
{
  if(!empty($message))
  {
    echo cs_icon('important');
    echo $cs_lang['error'];
    echo cs_html_roco(1,'leftc');
    echo $message;
  }
  else
  {
    echo $cs_lang['body_picture'];
  }
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_br(1);
}


if(!isset($_POST['submit']) OR !empty($error) OR !empty($g_error))
{
  echo cs_html_form (1,'gallerypic','gallery','create',1);
  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'leftc');
  echo cs_icon('download') . $cs_lang['upload'] . ' *';
  echo cs_html_roco(2,'leftb',0,2);
  if($file_up == 0)
  {
    echo cs_html_input('picture','','file');
    echo cs_html_br(2);
    $matches[1] = $cs_lang['pic_infos'];
    $return_types = '';
    foreach($img_filetypes AS $add)
    {
      $return_types .= empty($return_types) ? $add : ', ' . $add;
    }
    $matches[2] = $cs_lang['max_width'] . $cs_option['width'] . ' px' . cs_html_br(1);
    $matches[2] .= $cs_lang['max_height'] . $cs_option['height'] . ' px' . cs_html_br(1);
    $matches[2] .= $cs_lang['max_size'] . cs_filesize($cs_option['size']) . cs_html_br(1);
    $matches[2] .= $cs_lang['filetypes'] . $return_types;
    echo cs_abcode_clip($matches);
  }
  elseif ($file_up == 1)
  {
    echo cs_html_vote('file_up','1','hidden');
    echo cs_html_vote('gallery_name',$cs_gallery['gallery_name'],'hidden');
    echo cs_html_img('mods/gallery/image.php?picname=' . $cs_gallery['gallery_name']);
  }
  echo cs_html_roco(0);

##############################--- NO GD ---Thumbs --- START ----####################################
  if(!extension_loaded('gd'))
  {
    echo cs_html_roco(1,'leftc');
    echo cs_icon('download') . $cs_lang['upload_thumb'] . ' *';
    echo cs_html_roco(2,'leftb',0,2);
    echo cs_html_input('picture_thumb','','file');

    echo cs_html_br(2);
    $matches[1] = $cs_lang['pic_infos'];
    $return_types = '';
    foreach($img_filetypes AS $add => $value)
    {
      $return_types .= empty($return_types) ? $add : ', ' . $add;
    }
    $matches[2] = $cs_lang['max_width'] . $cs_option['thumbs'] . ' px' . cs_html_br(1);
    $matches[2] .= $cs_lang['max_height'] . $cs_option['thumbs'] . ' px' . cs_html_br(1);
    $matches[2] .= $cs_lang['max_size'] . cs_filesize('10240') . cs_html_br(1);
    $matches[2] .= $cs_lang['filetypes'] . $return_types;
    echo cs_abcode_clip($matches);
    echo cs_html_roco(0);
  }
##############################--- NO GD --- Thumbs --- ENDE ----####################################

  echo cs_html_roco(1,'leftc');
  echo cs_icon('kedit') . $cs_lang['titel'] . ' *';
  echo cs_html_roco(2,'leftb',0,2);
  echo cs_html_input('gallery_titel',$cs_gallery['gallery_titel'],'text',200,42);
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('folder_yellow') . $cs_lang['category'] . ' *';
  echo cs_html_roco(2,'leftb',0,2);
//  echo cs_categories_dropdown('gallery',$cs_gallery['categories_id']);
  echo make_folders_select('folders_id',$cs_gallery['folders_id'],'0','gallery');
  echo cs_html_roco(0);

  if($advance == '1')
  {
    echo cs_html_roco(1,'leftc');
    echo cs_icon('access') . $cs_lang['access'];
    echo cs_html_roco(2,'leftb',0,2);
    echo cs_html_select(1,'gallery_access');
    $levels = 0;
    while($levels < 6)
    {
      $cs_gallery['gallery_access'] == $levels ? $sel = 1 : $sel = 0;
      echo cs_html_option($levels . ' - ' . $cs_lang['lev_' . $levels],$levels,$sel);
      $levels++;
    }
    echo cs_html_select(0);
    echo cs_html_roco(0);

    echo cs_html_roco(1,'leftc');
    echo cs_icon('xpaint') . $cs_lang['show'];
    echo cs_html_roco(2,'leftb',0,2);
    echo cs_html_select(1,'gallery_status');
    $levels = 0;
    while($levels < 2)
    {
      $cs_gallery['gallery_status'] == $levels ? $sel = 1 : $sel = 0;
      echo cs_html_option($cs_lang['show_' . $levels],$levels,$sel);
      $levels++;
    }
    echo cs_html_select(0);
    echo cs_html_roco(0);

    if(extension_loaded('gd'))
    {
      echo cs_html_roco(1,'leftc',2);
      echo cs_icon('xpaint') . $cs_lang['watermark'];
      echo cs_html_roco(2,'leftb',0,2);
      $no_watermark = $cs_lang['no_watermark'];
      $no_cat_data_watermark = array('0' => array('categories_id' => '', 'categories_mod' => 'gallery-watermark', 'categories_name' => $no_watermark, 'categories_picture' => ''));
      $cat_data_watermark_1 = cs_sql_select(__FILE__,'categories','*',"categories_mod = 'gallery-watermark'",'categories_name',0,0);
      if(empty($cat_data_watermark_1))
      {
        $cat_data_watermark = $no_cat_data_watermark;
      }
      else
      {
        $cat_data_watermark = array_merge ($no_cat_data_watermark, $cat_data_watermark_1);
      }
      $search_value = $cs_gallery['gallery_watermark'];
      if(!empty($search_value))
      {
        foreach ($cat_data_watermark as $key => $row)
        {
          foreach($row as $cell)
          {
            if (strpos($cell, $search_value) !== FALSE)
            {
              $watermark_id = $key;
            }
          }
        }
      }
      $el_id = 'watermark_1';
      $onc = "document.getElementById('" . $el_id . "').src='" . $cs_main['php_self']['dirname'] . "uploads/categories/' + this.form.";
      $onc .= "gallery_watermark.options[this.form.gallery_watermark.selectedIndex].value";
      echo cs_html_select(1,'gallery_watermark',"onchange=\"" . $onc . "\"");
      foreach ($cat_data_watermark as $data)
      {
        $data['categories_picture'] == $cs_gallery['gallery_watermark'] ? $sel = 1 : $sel = 0;
        echo cs_html_option($data['categories_name'],$data['categories_picture'],$sel);
      }
      echo cs_html_select(0) . ' ';
      if(!empty($watermark_id))
      {
        $url = 'uploads/categories/' . $cs_gallery['gallery_watermark'];
      }
      else
      {
        $url = 'symbols/gallery/nowatermark.png';
      }
      echo cs_html_img($url,'','','id="' . $el_id . '"');
      echo cs_html_roco(0);
      echo cs_html_roco(1,'leftb');
      echo cs_html_select(1,'watermark_pos');
      $levels = 1;
      while($levels < 10)
      {
        $watermark_pos == $levels ? $sel = 1 : $sel = 0;
        echo cs_html_option($cs_lang['watermark_' . $levels],$levels,$sel);
        $levels++;
      }
      echo cs_html_select(0);
      echo cs_html_roco(2,'leftb');
      echo $cs_lang['wm_trans'];
      echo cs_html_input('gallery_watermark_trans',$gallery_watermark_trans,'text',2,2);
      echo '%';
      echo cs_html_roco(0);
    }
  }
  echo cs_html_roco(1,'leftc');
  echo cs_icon('kate') . $cs_lang['comment'] . ' *';
  echo cs_html_br(2);
  echo cs_abcode_smileys('gallery_description');
  echo cs_html_roco(2,'leftb',0,2);
  echo cs_abcode_features('gallery_description');
  echo cs_html_textarea('gallery_description',$cs_gallery['gallery_description'],'50','5');
  echo cs_html_roco(0);

  if($advance == '1')
  {
    echo cs_html_roco(1,'leftc');
    echo cs_icon('configure') . $cs_lang['more'];
    echo cs_html_roco(2,'leftb',0,2);
    echo cs_html_vote('gallery_vote','1','checkbox',$cs_gallery['gallery_vote']);
    echo $cs_lang['vote_endi'];
    echo cs_html_br(1);
    echo cs_html_vote('download','1','checkbox',$download);
    echo $cs_lang['download_endi'];
    if(extension_loaded('gd'))
    {
      echo cs_html_br(1);
      echo cs_html_vote('gray','1','checkbox',$gray);
      echo $cs_lang['gray'];
    }
    echo cs_html_br(1);
    echo cs_html_vote('download_original','1','checkbox',$download_original);
    echo $cs_lang['download_original'];
    echo cs_html_br(1);
    echo cs_html_vote('gallery_close','1','checkbox',$cs_gallery['gallery_close']);
    echo $cs_lang['gallery_close'];
    echo cs_html_roco(0);
  }
  echo cs_html_roco(1,'leftc');
  echo cs_icon('ksysguard') . $cs_lang['options'];
  echo cs_html_roco(2,'leftb',0,2);
  if($advance == '0')
  {
    echo cs_html_vote('advance','0','hidden');
    echo cs_html_vote('advance+',$cs_lang['advance+'],'submit');
  }
  if($advance == '1')
  {
    echo cs_html_vote('advance','1','hidden');
    echo cs_html_vote('advance-',$cs_lang['advance-'],'submit');
  }
  echo cs_html_vote('submit',$cs_lang['submit'],'submit');
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_form (0);
}
echo cs_subtemplate(__FILE__,$data,'gallery','picture_create');
?>