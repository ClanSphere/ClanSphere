<?PHP
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');
require_once('mods/gallery/functions.php');

$cs_gallery['gallery_read'] = '0';
$cs_gallery['gallery_zip_read'] = '0';
$cs_gallery['gallery_del'] = '0';
$cs_gallery['gallery_access'] = '0';
$cs_gallery['gallery_status'] = '0';
$watermark_pos = 0;
$zip_file = '0';

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo cs_link($cs_lang['mod'],'gallery','manage') . ' - ' . $cs_lang['head'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo $cs_lang['head'];
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

if(isset($_POST['submit']))
{
  if(isset($_POST['read']) OR isset($_POST['del'])OR isset($_POST['read_zip']))
  {
    if(isset($_POST['read_zip']))
    {
      if(!isset($_POST['submit_zipfile']))
      {
        echo cs_html_form (1,'create','gallery','advanced',1);
        echo cs_html_table(1,'forum',1);
        echo cs_html_roco(1,'headb',0,2);
        echo $cs_lang['read_zip'];
        echo cs_html_roco(0);
        echo cs_html_roco(1,'leftc');
        echo cs_icon('download') . $cs_lang['zipfile'];
        echo cs_html_roco(2,'leftb');
        echo cs_html_input('zipfile','','file');
        echo cs_html_roco(0);
        echo cs_html_roco(1,'leftc');
        echo cs_icon('ksysguard') . $cs_lang['options'];
        echo cs_html_roco(2,'leftb',0,2);
        echo cs_html_vote('submit','1','hidden');
        echo cs_html_vote('read_zip','1','hidden');
        echo cs_html_vote('submit_zipfile',$cs_lang['continue'],'submit');
        echo cs_html_roco(0);
        echo cs_html_table(0);
        echo cs_html_form (0);
      }
      if(isset($_POST['submit_zipfile']))
      {
        $file = $_FILES['zipfile']['tmp_name'];
        $file_type = $_FILES['zipfile']['type'];
        echo $file_type;
        if ($file_type !== 'application/zip') // PHP 4 'application/zip' PHP 5 'application/x-zip-compressed'
        {
          echo cs_html_table(1,'forum',1);
          echo cs_html_roco(1,'headb',0,2);
          echo $cs_lang['read_zip'];
          echo cs_html_roco(0);
          echo cs_html_roco(1,'leftc');
          echo $cs_lang['error_zip'];
          echo cs_html_roco(0);
          echo cs_html_table(0);

        }
        else
        {
          $pointer = zip_open($file);
          while ($zipped = zip_read($pointer))
          {
            if (zip_entry_open($pointer,$zipped,'r'))
            {
              $filename = zip_entry_name($zipped);
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
      if ($filename != "." && $filename != ".." && $filename != ".keep" && $filename != ".svn" && $filename != "Thumbs.db" && $filename != "index.html")
      {
        $picnamesArray[] = $filename;
      }
    }
    while($filename = readdir($dirHandleThumbs))
    {
      if ($filename != "." && $filename != ".." && $filename != ".keep" && $filename != ".svn" && $filename != "Thumbs.db" && $filename != "index.html")
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
        echo cs_html_form (1,'create','gallery','advanced',1);
      echo cs_html_table(1,'forum',1);
      echo cs_html_roco(1,'headb',0,4);
      echo $cs_lang['newpic'];
      echo cs_html_roco(0);

      echo cs_html_roco(1,'leftc');
      echo cs_icon('folder_yellow') . $cs_lang['category'];
      echo cs_html_roco(2,'leftb',0,3);
      echo make_folders_select('folders_id','0','0','gallery');
      echo cs_html_roco(0);

      echo cs_html_roco(1,'leftc');
      echo cs_icon('access') . $cs_lang['access'];
      echo cs_html_roco(2,'leftb',0,3);
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
      echo cs_html_roco(2,'leftb',0,3);
      echo cs_html_select(1,'gallery_status');
      $levels = 0;
      while($levels < 2)
      {
        $cs_gallery['gallery_status'] == $levels ? $sel = 1 : $sel = 0;
        echo cs_html_option($levels . ' - ' . $cs_lang['show_' . $levels],$levels,$sel);
        $levels++;
      }
      echo cs_html_select(0);
      echo cs_html_roco(0);
      $cs_gallery['gallery_watermark'] = '';
      $gallery_watermark_trans = '20';
      if(extension_loaded('gd'))
      {
        echo cs_html_roco(1,'leftc',2);
        echo cs_icon('xpaint') . $cs_lang['watermark'];
        echo cs_html_roco(2,'leftb',0,3);
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
        $onc .= "gallery_watermark.advanced[this.form.gallery_watermark.selectedIndex].value";
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
        echo cs_html_roco(2,'leftb');
        echo cs_html_select(1,'watermark_pos');
        $levels = 1;
        while($levels < 10)
        {
          $watermark_pos == $levels ? $sel = 1 : $sel = 0;
          echo cs_html_option($levels . ' - ' . $cs_lang['watermark_' . $levels],$levels,$sel);
          $levels++;
        }
        echo cs_html_select(0);
        echo cs_html_roco(3,'leftb',0,2);
        echo $cs_lang['wm_trans'];
        echo cs_html_input('gallery_watermark_trans',$gallery_watermark_trans,'text',2,2);
        echo '%';
        echo cs_html_select(0);
        echo cs_html_roco(0);
      }
      $run = '0';
      foreach ($diff as $pic)
      {
          $run++;
          echo cs_html_roco(1,'leftb',3);
        echo cs_html_vote('status_' . $run,'1','checkbox','1');
        echo cs_html_vote('name_' . $run,$pic,'hidden');
          echo cs_html_roco(2,'leftb',3);
        $img_size = getimagesize("uploads/gallery/pics/$pic");
        $img_filesize = filesize("uploads/gallery/pics/$pic");
        $img_width = $img_size[0];
        $img_height = $img_size[1];
        $img_w_h = $img_width / $img_height;
        $img_new_height = 40;
        $img_new_width = $img_new_height * $img_w_h;
        echo cs_html_img('mods/gallery/image.php?picname=' . $pic);
        echo cs_html_roco(3,'leftc');
        echo $cs_lang['name'];
        echo cs_html_roco(4,'leftc');
        echo $pic;
        echo cs_html_roco(0);
        echo cs_html_roco(3,'leftb');
        echo $cs_lang['size'];
        echo cs_html_roco(4,'leftb');
        echo $img_width . 'x' . $img_height;
        echo cs_html_roco(0);
        echo cs_html_roco(3,'leftc');
        echo $cs_lang['filesize'];
        echo cs_html_roco(4,'leftc');
        echo cs_filesize($img_filesize);
        echo cs_html_roco(0);
      }
      echo cs_html_roco(1,'leftc');
      echo cs_icon('ksysguard') . $cs_lang['options'];
      echo cs_html_roco(2,'leftb',0,3);
      echo cs_html_vote('submit_1',$cs_lang['continue'],'submit');
      echo cs_html_roco(0);
      echo cs_html_table(0);
      echo cs_html_form (0);
      echo cs_html_br(1);
    }
    elseif(empty($checkDiff) AND !empty($_POST['read']) OR empty($checkDiff) AND $zip_file == 1)
    {
      echo cs_html_table(1,'forum',1);
      echo cs_html_roco(1,'leftc');
      echo $cs_lang['nopic'];
      echo cs_html_roco(0);
      echo cs_html_table(0);
      echo cs_html_br(1);
      
    }
    if(!empty($checkDiff2) AND !empty($_POST['del']))
    {
      echo cs_html_table(1,'forum',1);
      echo cs_html_roco(1,'headb',0,2);
      echo $cs_lang['delthumb'];
      echo cs_html_roco(0);
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
          echo cs_html_roco(1,'leftc');
          echo 'Thumb_' . $thumb;
          echo cs_html_roco(2,'leftb');
          echo $cs_lang['deltrue'];
          echo cs_html_roco(0);
        }
        else
        {
          echo cs_html_roco(1,'leftc');
          echo 'Thumb_' . $thumb;
          echo cs_html_roco(2,'leftb');
          echo $cs_lang['delfalse'];
          echo cs_html_roco(0);
        }
      }

      echo cs_html_table(0);
    }
    elseif(!empty($_POST['del']))
    {
      echo cs_html_table(1,'forum',1);
      echo cs_html_roco(1,'leftc');
      echo $cs_lang['nothumb'];
      echo cs_html_roco(0);
      echo cs_html_table(0);
      echo cs_html_br(1);
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
  $run_1 = '0';
  echo cs_html_table(1,'forum',1);
  for($run = 1; $run<$post_count; $run++)
  {
    if(!empty($_POST['status_' . $run]))
    {
        $name = $_POST['name_' . $run];
        if (!extension_loaded('gd')) die('Error: GD extension not installed.');
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
              $cs_gallery_pic['gallery_download'] = '1|--@--|1';
          $gallery_cells = array_keys($cs_gallery_pic);
          $gallery_save = array_values($cs_gallery_pic);
          cs_sql_insert(__FILE__,'gallery',$gallery_cells,$gallery_save);
        }
        echo cs_html_roco(1,'leftb',2);
        echo cs_html_img('mods/gallery/image.php?picname=' . $name);
        echo cs_html_roco(2,'leftc');
        echo $cs_lang['name'];
        echo cs_html_roco(3,'leftb');
        echo $name;
        echo cs_html_roco(0);
        echo cs_html_roco(2,'leftc',0,2);
        echo $cs_lang['thumb_true'];
        echo cs_html_roco(0);
      }
        $run_1++;
    }
  }
  echo cs_html_table(0);
}
if(!isset($_POST['submit_1']))
{
  if(!isset($_POST['submit']) OR !empty($error))
  {
    echo cs_html_form (1,'gallery','gallery','advanced',1);
    echo cs_html_table(1,'forum',1);
    echo cs_html_roco(1,'leftc');
    echo cs_icon('configure') . $cs_lang['head'];
    echo cs_html_roco(2,'leftb');
    echo cs_html_vote('read','1','checkbox',$cs_gallery['gallery_read']);
    echo $cs_lang['read'];
    echo cs_html_br(1);
    echo cs_html_vote('read_zip','1','checkbox',$cs_gallery['gallery_zip_read']);
    echo $cs_lang['read_zip'];
    echo cs_html_br(2);
    echo cs_html_vote('del','1','checkbox',$cs_gallery['gallery_del']);
    echo $cs_lang['del'];
    echo cs_html_roco(0);

    echo cs_html_roco(1,'leftc');
    echo cs_icon('ksysguard') . $cs_lang['options'];
    echo cs_html_roco(2,'leftb');
    echo cs_html_vote('submit',$cs_lang['continue'],'submit');
    echo cs_html_roco(0);
    echo cs_html_table(0);
    echo cs_html_form (0);
  }
}
?>