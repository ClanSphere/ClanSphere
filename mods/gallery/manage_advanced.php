<?PHP
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');

$files_gl = cs_files();

require_once('mods/gallery/functions.php');

$cs_gallery['gallery_read'] = '0';
$cs_gallery['gallery_zip_read'] = '0';
$cs_gallery['gallery_del'] = '0';
$cs_gallery['gallery_access'] = '0';
$cs_gallery['gallery_status'] = '0';
$watermark_pos = 0;
$zip_file = '0';

$data = array();
$data['if']['start'] = FALSE;
$data['if']['no_thumb'] = FALSE;
$data['if']['nopic'] = FALSE;
$data['if']['error_zip'] = FALSE;
$data['if']['zipfile'] = FALSE;
$data['if']['pictures_found'] = FALSE;
$data['if']['pictures_done'] = FALSE;
$data['if']['thumb'] = FALSE;

$data['manage']['head'] = cs_subtemplate(__FILE__,$data,'gallery','manage_head');

if(isset($_POST['submit']))
{
  if(isset($_POST['read']) OR isset($_POST['del'])OR isset($_POST['read_zip']))
  {
    if(isset($_POST['read_zip']))
    {
      if(!isset($_POST['submit_zipfile']))
      {
        $data['if']['zipfile'] = TRUE;
      }
      else
      {
        $file = $files_gl['zipfile']['tmp_name'];
        $file_type = $files_gl['zipfile']['type'];
        // PHP 4 'application/zip' PHP 5 'application/x-zip-compressed'
        if ($file_type !== 'application/zip' AND $file_type !== 'application/x-zip-compressed')
        {
          $data['if']['error_zip'] = TRUE;
          $data['zip']['filetype'] = $file_type;
        }
        else
        {
          $pointer = zip_open($file);
          while ($zipped = zip_read($pointer))
          {
            if (zip_entry_open($pointer,$zipped,'r'))
            {
              $filename = zip_entry_name($zipped);
              if ($filename == '__MACOSX') continue; //mac os fix
              if(!file_exists('uploads/gallery/pics/' . $filename)) {
                $file = fopen('uploads/gallery/pics/' . $filename,'w');
                fwrite($file,zip_entry_read($zipped,zip_entry_filesize($zipped)));
                fclose($file);
                zip_entry_close($zipped);
              } else {
                $ext = substr($filename,strlen($filename)+1-strlen(strrchr($filename,'.')));
                $count = '0';
                while($count < '1')
                {
                  $hash = '';
                  $pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
                  for($i=0;$i<10;$i++)
                  {
                    $hash .= $pattern{rand(0,35)};
                  }
                  $filename = $hash . '.' . $ext;
                  if(!file_exists($filename))
                  {
                    $count++;
                  }
                }
                $file = fopen('uploads/gallery/pics/' . $filename,'w');
                fwrite($file,zip_entry_read($zipped,zip_entry_filesize($zipped)));
                fclose($file);
                zip_entry_close($zipped);
              }
              $target = $cs_main['def_path'] . '/uploads/gallery/pics/' . $filename;
              $filename = $cs_main['def_path'] . '' . $filename;
              $aa = strrchr($filename,'.');
              $bb = strlen($filename);
              $ab = strlen($aa);
              $bb = substr($filename,$bb - $ab + 1);
              if($bb == 'jpg' OR $bb == 'jpeg' OR $bb == 'gif' OR $bb == 'png' OR $bb == 'JPG' OR $bb == 'JPEG' OR $bb == 'GIF' OR $bb == 'PNG')
              {
                if(getimagesize($target))
                {
                  $img_size = getimagesize($target);
                }
                else
                {
                  $img_size[2] = '0';
                }
              }
              else
              {
                $img_size[2] = '0';
              }
            }
          }
          zip_close($pointer);
          $zip_file = '1';
        }
      }
    }

    $picnamesArray = array();
    $thumbnamesArray = array();
    $dirHandlePics = opendir("uploads/gallery/pics");
    $dirHandleThumbs = opendir("uploads/gallery/thumbs");
    while($filename = readdir($dirHandlePics))
    {
      if ($filename != "." && $filename != ".." && $filename != ".keep" && $filename != ".git" && $filename != "Thumbs.db" && $filename != "index.html")
      {
        $picnamesArray[] = $filename;
      }
    }
    while($filename = readdir($dirHandleThumbs))
    {
      if ($filename != "." && $filename != ".." && $filename != ".keep" && $filename != ".git" && $filename != "Thumbs.db" && $filename != "index.html")
      {
        $name = strlen($filename);
        $filename = substr($filename,'6',$name);
        $thumbnamesArray[] = $filename;
      }
    }
    $diff = array_diff($picnamesArray, $thumbnamesArray);
    $diff2 = array_diff($thumbnamesArray, $picnamesArray);
    $checkDiff = count($diff);
    $checkDiff2 = count($diff2);
    if(!empty($checkDiff) AND !empty($_POST['read']) OR !empty($checkDiff) AND $zip_file == 1)
    {
      $data['if']['pictures_found'] = TRUE;

      $data['folders']['select'] = make_folders_select('folders_id','0','0','gallery');

      $levels = 0;
      $data['access']['options'] = '';
      while($levels < 6)
      {
        $cs_gallery['gallery_access'] == $levels ? $sel = 1 : $sel = 0;
        $data['access']['options'] .= cs_html_option($levels . ' - ' . $cs_lang['lev_' . $levels],$levels,$sel);
        $levels++;
      }

      $levels = 0;
      $data['show']['options'] = '';
      while($levels < 2)
      {
        $cs_gallery['gallery_status'] == $levels ? $sel = 1 : $sel = 0;
        $data['show']['options'] .= cs_html_option($levels . ' - ' . $cs_lang['show_' . $levels],$levels,$sel);
        $levels++;
      }

      $cs_gallery['gallery_watermark'] = '';
      $gallery_watermark_trans = '20';
      if(extension_loaded('gd'))
      {
        $no_watermark = $cs_lang['no_watermark'];
        $no_cat_data_watermark = array('0' => array('categories_id' => '', 'categories_mod' => 'gallery-watermark', 'categories_name' => $no_watermark, 'categories_picture' => ''));
        $cat_data_watermark_1 = cs_sql_select(__FILE__,'categories','*',"categories_mod = 'gallery-watermark'",'categories_name',0,0);
        if(empty($cat_data_watermark_1)) {
          $cat_data_watermark = $no_cat_data_watermark;
        } else {
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
        $onc .= "gallery_watermark.advanced[this.form.gallery_watermark.selectedIndex].value";
        $data['watermark']['onchange'] = $onc;

        $data['watermark']['options'] = '';
        foreach ($cat_data_watermark as $data2)
        {
          $data2['categories_picture'] == $cs_gallery['gallery_watermark'] ? $sel = 1 : $sel = 0;
          $data['watermark']['options'] .= cs_html_option($data2['categories_name'],$data2['categories_picture'],$sel);
        }

        if(!empty($watermark_id)) {
          $url = 'uploads/categories/' . $cs_gallery['gallery_watermark'];
        } else {
          $url = 'symbols/gallery/nowatermark.png';
        }
        $data['watermark']['img'] = cs_html_img($url,'','','id="' . $el_id . '"');

        $levels = 1;
        $data['watermark']['pos_options'] = '';
        while($levels < 10)
        {
          $watermark_pos == $levels ? $sel = 1 : $sel = 0;
          $data['watermark']['pos_options'] .= cs_html_option($levels . ' - ' . $cs_lang['watermark_' . $levels],$levels,$sel);
          $levels++;
        }
        $data['watermark']['trans'] = $gallery_watermark_trans;

      }
      $run = 0;
      $count = 0;
      foreach ($diff as $pic)
      {
        $count++;
        $data['pictures'][$run]['run'] = $count;
        $data['pictures'][$run]['name'] = $pic;

        $img_size = getimagesize("uploads/gallery/pics/$pic");
        $img_filesize = filesize("uploads/gallery/pics/$pic");
        $img_width = $img_size[0];
        $img_height = $img_size[1];
        $img_w_h = $img_width / $img_height;
        $img_new_height = 40;
        $img_new_width = $img_new_height * $img_w_h;
        $data['pictures'][$run]['img'] = cs_html_img('mods/gallery/image.php?picname=' . $pic);
        $data['pictures'][$run]['size'] = $img_width . 'x' . $img_height;
        $data['pictures'][$run]['filesize'] = cs_filesize($img_filesize);

        $run++;
      }

    }
    elseif(empty($checkDiff) AND !empty($_POST['read']) OR empty($checkDiff) AND $zip_file == 1)
    {
      $data['if']['nopic'] = TRUE;
    }
    if(!empty($checkDiff2) AND !empty($_POST['del']))
    {
      $data['if']['thumb'] = TRUE;

      $run = 0;
      foreach ($diff2 as $thumb)
      {
        if(cs_unlink('gallery', 'Thumb_' . $thumb, 'thumbs') == true)
        {
          $where = "gallery_name = '" . $thumb . "'";
          $search = cs_sql_count(__FILE__,'gallery',$where);
          if(!empty($search))
          {
            $query = "DELETE FROM {pre}_gallery WHERE gallery_name='$thumb'";
            cs_sql_query(__FILE__,$query);
          }
          $msg = $cs_lang['deltrue'];
        }
        else
        {
          $msg = $cs_lang['delfalse'];
        }
        $data['thumbs'][$run]['msg'] = $msg;
        $data['thumbs'][$run]['name'] = 'Thumb_' . $thumb;
        $run++;
      }

    }
    elseif(!empty($_POST['del'])) {
      $data['if']['no_thumb'] = TRUE;
    }
  }
}
if(isset($_POST['submit_1']))
{
  $post_count = count($_POST);
  $post_count = $post_count - '1';
  $cs_gallery_pic['folders_id'] = empty($_POST['folders_name']) ? $_POST['folders_id'] :
  make_folders_create('gallery',$_POST['folders_name']);
  $cs_gallery_option = cs_sql_option(__FILE__,'gallery');
  $img_max['thumbs'] = $cs_gallery_option['thumbs'];

  for($run = 0; $run<$post_count; $run++)
  {
    if(!empty($_POST['status_' . $run]))
    {
      $name = $_POST['name_' . $run];
      if(!extension_loaded('gd')) die(cs_error_internal(0, 'GD extension not installed.'));
      if(cs_resample('uploads/gallery/pics/' . $name, 'uploads/gallery/thumbs/' . 'Thumb_' . $name, $img_max['thumbs'], $img_max['thumbs']))
      {
        $where = "gallery_name = '" . cs_sql_escape($name) . "'";
        $search = cs_sql_count(__FILE__,'gallery',$where);
        if(empty($search))
        {
          $cs_gallery_pic['users_id'] = $account['users_id'];
          $cs_gallery_pic['gallery_name'] = $name;
          $cs_gallery_pic['gallery_status'] =  isset($_POST['gallery_status']) ? $_POST['gallery_status'] : 0;
          $cs_gallery_pic['gallery_access'] =  isset($_POST['gallery_access']) ? $_POST['gallery_access'] : 0;
          $cs_gallery_pic['gallery_watermark'] = $_POST['gallery_watermark'];
          if(!empty($_POST['gallery_watermark']))
          {
            $watermark_pos = $_POST['watermark_pos'];
            $watermark_trans = $_POST['gallery_watermark_trans'];
            $cs_gallery_pic['gallery_watermark_pos'] = $watermark_pos . '|--@--|' . $watermark_trans;
          }
          $extension = strlen(strrchr($name,"."));
          $file = strlen($name);
          $filename = substr($name,0,$file-$extension);
          $cs_gallery_pic['gallery_titel'] = $filename;
          $cs_gallery_pic['gallery_time'] = cs_time();
          $gallery_cells = array_keys($cs_gallery_pic);
          $gallery_save = array_values($cs_gallery_pic);
          cs_sql_insert(__FILE__,'gallery',$gallery_cells,$gallery_save);
        }
        $data['pics'][$run]['img'] = cs_html_img('mods/gallery/image.php?picname=' . $name);
        $data['pics'][$run]['name'] = $name;
      }
    }
  }
  cs_redirect($cs_lang['create_done'],'gallery');
}
if(!isset($_POST['submit_1'])) {
  if(!isset($_POST['submit']) OR !empty($error)) {
    $data['if']['start'] = TRUE;
  }
}

echo cs_subtemplate(__FILE__,$data,'gallery','manage_advanced');