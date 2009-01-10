<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

function cs_captcha($hash) {

	$gd_info = gd_info();
	$chars = strlen($hash);
	$height = $chars == 3 ? 18 : 40;
	$charsize = $chars * 20;
	$img = ImageCreateTrueColor($charsize,$height);
	$bgc = ImageColorAllocate($img,rand(0,80),rand(0,80),rand(0,80));
	ImageFill($img,0,0,$bgc);

	for($i=1;$i<$chars;$i++) {
		$linecolor = ImageColorAllocate($img,rand(0,150),rand(0,150),rand(0,150));
		ImageLine($img, $i * 20, 0, $i * 20, $height, $linecolor);
	}
	$linecolor = ImageColorAllocate($img,rand(0,150),rand(0,150),rand(0,150));
	ImageLine($img, 0, $height / 3, $charsize, $height / 3, $linecolor);
	$linecolor = ImageColorAllocate($img,rand(0,150),rand(0,150),rand(0,150));
	ImageLine($img, 0, $height / 3 * 2, $charsize, $height / 3 * 2, $linecolor);

	$linecolor = ImageColorAllocate($img,0,0,0);
	ImageLine($img, 0, 0, $charsize, 0, $linecolor);
	ImageLine($img, 0, $height - 1, $charsize, $height - 1, $linecolor);
	ImageLine($img, 0, 0, 0, $height - 1, $linecolor);
	ImageLine($img, $charsize - 1, 0, $charsize - 1, $height - 1, $linecolor);

	for($i=0;$i<$chars;$i++) {
		$textcolor = ImageColorAllocate($img,rand(100,250),rand(100,250),rand(100,250));
		ImageString($img,rand(3,5),rand(($i * 20 + 2),($i * 20 + 8)),rand(2,$height - 20),$hash{$i},$textcolor);
	}

	/* no image Caching */
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
	
	if($gd_info["PNG Support"] == TRUE) {
		header("Content-type:image/png");
	  ImagePNG($img);
	}
	elseif($gd_info["JPG Support"] == TRUE) {
		header("Content-type:image/jpg");
	  ImageJPEG($img);
	}
	elseif($gd_info["GIF Create Support"] == TRUE) {
		header("Content-type:image/gif");
	  ImageGIF($img);
	}
	else {
		cs_error(__FILE__,'Could not create image file using GD');
	}
}

function cs_resample($image, $target, $max_width, $max_height) {

  $gd_info = gd_info();
  $im_info = getimagesize($image);

  if($im_info[2] == 1 AND $gd_info["GIF Read Support"] == TRUE) {
    $src = ImageCreateFromGIF($image);
  }
  elseif($im_info[2] == 2 AND $gd_info["JPG Support"] == TRUE) {
    $src = ImageCreateFromJPEG($image);
  }
  elseif($im_info[2] == 3 AND $gd_info["PNG Support"] == TRUE) {
    $src = ImageCreateFromPNG($image);
  }
  else {
    cs_error(__FILE__,'Failed to open existing image file');
    return 0;
  }

  $factor = max($im_info[1] / $max_height, $im_info[0] / $max_width);
  $im_new[0] = floor($im_info[0] / $factor);
  $im_new[1] = floor($im_info[1] / $factor);
  $dst = ImageCreateTrueColor($im_new[0],$im_new[1]);

  ImageCopyResampled($dst,$src,0,0,0,0,$im_new[0],$im_new[1],$im_info[0],$im_info[1]);

  if($im_info[2] == 1 AND $gd_info["GIF Create Support"] == TRUE) {
    $return = ImageGIF($dst,$target) ? 1 : 0;
  }
  elseif($im_info[2] == 2 AND $gd_info["JPG Support"] == TRUE) {
    $return = ImageJPEG($dst,$target,100) ? 1 : 0;
  }
  elseif($im_info[2] == 3 AND $gd_info["PNG Support"] == TRUE) {
    $return = ImagePNG($dst,$target) ? 1 : 0;
  }
  else {
    cs_error(__FILE__,'Failed to write resampled image file');
    return 0;
  }
  return $return;
}

?>