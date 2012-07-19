<?php
$width = $_GET['width'];
Header( "Content-type: image/gif");
    if($width > 100)
      $width = 100;
    
    $im = imagecreate(101,6);
    $white = ImageColorAllocate($im,255,255,255);
    $green = ImageColorAllocate($im, 12,246,0);
    $grey = ImageColorAllocate($im, 192,192,192);
    
    ImageRectangle($im,0,0,100,5,$grey);
    ImageFilledRectangle($im,1,1,$width-1,4,$green);
  
  ImageGif($im);
  ImageDestroy($im);
  