<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

# Overwrite global settings by using the following array
$cs_main = array('init_sql' => true, 'init_tpl' => false, 'init_mod' => true);

chdir('../../');

require_once 'system/core/functions.php';

cs_init($cs_main);

chdir('mods/gallery/');

global $cs_main, $account;

if(!empty($_REQUEST['pic']) OR !empty($_REQUEST['thumb']))
{
  $options = cs_sql_option(__FILE__, 'gallery');
  
  if(!empty($_REQUEST['pic'])) {
    $where = $_REQUEST['pic'];
  }
  elseif(!empty($_REQUEST['thumb']))
  {
    $where = $_REQUEST['thumb'];
  }
  $from = 'gallery';
  $select  = 'gallery_watermark, gallery_watermark_pos, gallery_name, gallery_time, ';
  $select .= 'gallery_count, gallery_count_downloads, gallery_access';
  $where = "gallery_id = '" . cs_sql_escape($where) . "'";
  $cs_gallery = cs_sql_select(__FILE__,$from,$select,$where);
  $gallery_loop = count($cs_gallery);
  
  if ($account['access_gallery'] < $cs_gallery['gallery_access']) {
    die(cs_error_internal(0, 'Access denied'));
  }

  $position = $cs_gallery['gallery_watermark_pos'];
  $temp_pos = empty($position) ? array(0,1) : explode("|--@--|", $position);
  $position = $temp_pos[0];
  $transparenz = $temp_pos[1];
  $name = $cs_gallery['gallery_name'];
  $gallery_time = $cs_gallery['gallery_time'];
  $gallery_count = $cs_gallery['gallery_count'];
  $gallery_count_downloads = $cs_gallery['gallery_count_downloads'];

  if(!empty($_REQUEST['pic']))
  {
    $gallery_count = $gallery_count + 1;
    $gallery_cells = array('gallery_count');
    $gallery_save = array($gallery_count);
    cs_sql_update(__FILE__,'gallery',$gallery_cells,$gallery_save,$_REQUEST['pic']);
  }
}
if(!empty($_REQUEST['usersthumb'])) {
  $where = $_REQUEST['usersthumb'];
  $from = 'usersgallery';
  $select = 'usersgallery_name, usersgallery_time, usersgallery_count, usersgallery_count_downloads';
  $where = "usersgallery_id = '" . cs_sql_escape($where) . "'";
  $cs_gallery = cs_sql_select(__FILE__,$from,$select,$where);
  $gallery_loop = count($cs_gallery);

  $name = $cs_gallery['usersgallery_name'];
  $gallery_time = $cs_gallery['usersgallery_time'];
  $gallery_count = $cs_gallery['usersgallery_count'];
  $gallery_count_downloads = $cs_gallery['usersgallery_count_downloads'];
}

if(!empty($_REQUEST['userspic'])) {
  $where = $_REQUEST['userspic'];
  $from = 'usersgallery';
  $select = 'usersgallery_name, usersgallery_time, usersgallery_count, usersgallery_count_downloads';
  $where = "usersgallery_id = '" . cs_sql_escape($where) . "'";
  $cs_gallery = cs_sql_select(__FILE__,$from,$select,$where);
  $gallery_loop = count($cs_gallery);

  $name = $cs_gallery['usersgallery_name'];
  $gallery_time = $cs_gallery['usersgallery_time'];
  $gallery_count = $cs_gallery['usersgallery_count'];
  $gallery_count_downloads = $cs_gallery['usersgallery_count_downloads'];

  $gallery_count = $gallery_count + 1;
  $gallery_cells = array('usersgallery_count');
  $gallery_save = array($gallery_count);
  cs_sql_update(__FILE__,'usersgallery',$gallery_cells,$gallery_save,$_REQUEST['userspic']);
}

class PictureEngine
{
  var $image;
  var $width;
  var $height;
  var $Transformation;

  function PictureEngine(&$image)
  {
    $this->data($image);
    $this->Transformation = new Transformation($this->image);
  }

  function data(&$image)
  {
    $this->image = &$image;
    $this->width = imagesx($this->image);
    $this->height = imagesy($this->image);
  }

  function Dump()
  {
    header("Content-type: image/jpeg");
    Imagejpeg($this->image,null,100);
  }

  function Dump_down($count)
  {
    $gallery_count_downloads = $count + 1;
    $gallery_cells = array('gallery_count_downloads');
    $gallery_save = array($gallery_count_downloads);
    cs_sql_update(__FILE__,'gallery',$gallery_cells,$gallery_save,$_REQUEST['pic']);

    # disable browser / proxy caching
    header("Cache-Control: max-age=0, no-cache, no-store, must-revalidate");
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

    header('Content-Transfer-Encoding: none');
    header("Accept-Ranges: bytes");
    header("Content-type: image/jpg");
    header("Content-Disposition: attachment; filename=image.jpg");
    echo @readfile(Imagejpeg($this->image,null,100),"r");
    exit;
  }
}

class Transformation extends PictureEngine
{

  function Transformation (&$image)
  {
    $this->data($image);
  }

  function Scale($maxwidth = 500, $maxheight = 10000)
  {
    $this->data($this->image);
    $xFactor = $this->width / $maxwidth;
    $yFactor = $this->height / $maxheight;

    if ($xFactor > $yFactor)
    {
      $newwidth = $maxwidth;
      $newheight = $this->height / $xFactor;
    }
    else
    {
      $newwidth = $this->width / $yFactor;
      $newheight = $maxheight;
    }

    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $this->image, 0, 0, 0, 0, $newwidth, $newheight, $this->width, $this->height);
    imagedestroy($this->image);
    $this->image = $dst;
    $this->data($this->image);
  }

  function watermark($watermark,$transparenz = 20,$filename,$position)
  {
    $this->data($this->image);
    $transparenz = 100 - $transparenz;
    if($position < 1 || $position > 9)
        return FALSE;

    $info_watermark = getimagesize($watermark);
    $dst = imagecreatetruecolor($this->width, $this->height);
    switch($info_watermark[2])
    {
      case 1:
      $watermark = imagecreatefromgif($watermark);
      break;
      case 2:
      $watermark = imagecreatefromjpeg($watermark);
      break;
      case 3:
      $watermark = imagecreatefrompng($watermark);
      break;
      }
    switch (($position-1)%3)
    {
      case 0:
      $pos_x = 0;
      break;
      case 1:
      $pos_x = round(($this->width - $info_watermark[0])/2, 0);
      break;
      case 2:
      $pos_x = $this->width - $info_watermark[0];
      break;
    }
    switch (floor(($position-1)/3))
    {
      case 0:
      $pos_y = 0;
      break;
      case 1:
      $pos_y = round(($this->height - $info_watermark[1])/2, 0);
      break;
      case 2:
      $pos_y = $this->height - $info_watermark[1];
      break;
    }

    imagecolortransparent($watermark, imagecolorat($watermark, 0, 0));
    imagecopymerge($dst, $this->image, 0, 0, 0, 0, $this->width, $this->height,100);
    imagecopymerge($dst, $watermark, $pos_x, $pos_y, 0, 0,$info_watermark[0],$info_watermark[1],$transparenz);
    imagedestroy($this->image);
    $this->image = $dst;
    $this->data($this->image);
  }
  function rotate($degrees=0)
  {
    $this->data($this->image);
    $rotate = imagerotate($this->image, $degrees, 0);
    imagecopyresampled($rotate, $this->image, 0, 0, 0, 0, 0, 0, $this->width, $this->height);
    imagedestroy($this->image);
    $this->image = $rotate;
    $this->data($this->image);
  }
}

if(extension_loaded('gd') AND isset($_REQUEST['pic']))
{
  $pic = "../../uploads/gallery/pics/" . $name;
  $img_size = getimagesize($pic);
  switch($img_size[2])
  {
    case 1:
    $pic_created = imagecreatefromgif($pic);
    break;
    case 2:
    $pic_created = imagecreatefromjpeg($pic);
    break;
    case 3:
    $pic_created = imagecreatefrompng($pic);
    break;
    }
    $im = new PictureEngine($pic_created);

  if(!empty($cs_gallery['gallery_watermark']))
  {
    $im->Transformation->watermark('../../uploads/categories/' . $cs_gallery['gallery_watermark'],$transparenz,$cs_gallery['gallery_watermark'],$position);
  }
  if(isset($_REQUEST['size']))
  {
    $size = $_REQUEST['size'];
    $im->Transformation->Scale($size);
  }
  if(isset($_REQUEST['rotate']))
  {
    $rotate=$_REQUEST['rotate'];
    $im->Transformation->rotate($rotate);
  }
  if(isset($_REQUEST['down']))
  {
    $im->dump_down($gallery_count_downloads);
  }
  else
  {
    $im->dump();
  }
}

if(extension_loaded('gd') AND isset($_REQUEST['userspic']))
{
  $pic = "../../uploads/usersgallery/pics/" . $name;
  $img_size = getimagesize($pic);
  switch($img_size[2])
  {
    case 1:
    $im = new PictureEngine(imagecreatefromgif($pic));
    break;
    case 2:
    $im = new PictureEngine(imagecreatefromjpeg($pic));
    break;
    case 3:
    $im = new PictureEngine(imagecreatefrompng($pic));
    break;
    }

  if(!empty($cs_gallery['gallery_watermark']))
  {
    $im->Transformation->watermark('../../uploads/categories/' . $cs_gallery['gallery_watermark'],$transparenz,$cs_gallery['gallery_watermark'],$position);
  }
  if(isset($_REQUEST['size']))
  {
    $size = $_REQUEST['size'];
    $im->Transformation->Scale($size);
  }
  if(isset($_REQUEST['rotate']))
  {
    $rotate=$_REQUEST['rotate'];
    $im->Transformation->rotate($rotate);
  }
  if(isset($_REQUEST['down']))
  {
    $im->dump_down($gallery_count_downloads);
  }
  else
  {
    $im->dump();
  }
}

if(!extension_loaded('gd') AND isset($_REQUEST['pic']))
{
  $pic = "../../uploads/gallery/pics/" . $name;
  $data = fopen($pic,'r');
  echo fread($data, filesize($pic));
}

if(extension_loaded('gd') AND isset($_REQUEST['thumb']))
{
  $thumb_file = $name;
  $thumb = "../../uploads/gallery/thumbs/Thumb_" . $thumb_file;
  $img_size = getimagesize($thumb);
  switch($img_size[2])
  {
    case 1:
    $im = new PictureEngine(imagecreatefromgif($thumb));
    break;
    case 2:
    $im = new PictureEngine(imagecreatefromjpeg($thumb));
    break;
    case 3:
    $im = new PictureEngine(imagecreatefrompng($thumb));
    break;
    }
  $time = cs_time();
  $time = $time - (60 * 60 * 24);
  if($gallery_time >= $time) {
    $im->Transformation->watermark('../../symbols/gallery/new.png','40','new.png','1');
  }
  $im->Transformation->Scale($options['thumbs'],'100');
  $im->dump();
}

if(!extension_loaded('gd') AND isset($_REQUEST['thumb']))
{
  $thumb_file = $name;
  $thumb = "../../uploads/gallery/thumbs/Thumb_" . $thumb_file;
  $data = fopen($thumb,'r');
  echo fread($data, filesize($thumb));
}

if(extension_loaded('gd') AND isset($_REQUEST['picname']))
{
    $pic_name = $_REQUEST['picname'];
  $pic = "../../uploads/gallery/pics/" . $pic_name;
  $img_size = getimagesize($pic);
  switch($img_size[2])
  {
    case 1:
    $im = new PictureEngine(imagecreatefromgif($pic));
    break;
    case 2:
    $im = new PictureEngine(imagecreatefromjpeg($pic));
    break;
    case 3:
    $im = new PictureEngine(imagecreatefrompng($pic));
    break;
    }
  if($im == true)
  {
    $size = '80';
    $im->Transformation->Scale($size,$size);
    $im->dump();
  }
}
if(extension_loaded('gd') AND isset($_REQUEST['boardpic']))
{
    $pic_name = $_REQUEST['boardpic'];
  $pic = "../../uploads/board/files/" . $pic_name;
  $img_size = getimagesize($pic);
  switch($img_size[2])
  {
    case 1:
    $im = new PictureEngine(imagecreatefromgif($pic));
    break;
    case 2:
    $im = new PictureEngine(imagecreatefromjpeg($pic));
    break;
    case 3:
    $im = new PictureEngine(imagecreatefrompng($pic));
    break;
    }
  if($im == true)
  {
    if(isset($_REQUEST['boardthumb']))
    {
      $size = '80';
      $im->Transformation->Scale($size,$size);
    }
    $im->dump();
  }
}

if(extension_loaded('gd') AND isset($_REQUEST['usersthumb']))
{
  $thumb_file = $name;
  $thumb = "../../uploads/usersgallery/thumbs/Thumb_" . $thumb_file;
  $img_size = getimagesize($thumb);
  switch($img_size[2])
  {
    case 1:
    $im = new PictureEngine(imagecreatefromgif($thumb));
    break;
    case 2:
    $im = new PictureEngine(imagecreatefromjpeg($thumb));
    break;
    case 3:
    $im = new PictureEngine(imagecreatefrompng($thumb));
    break;
    }
  $time = cs_time();
  $time = $time - (60 * 60 * 24);
  if($gallery_time >= $time)
  {
    $im->Transformation->watermark('../../symbols/gallery/new.png','40','new.png','1');
  }
  $im->Transformation->Scale('100','100');
  $im->dump();
}