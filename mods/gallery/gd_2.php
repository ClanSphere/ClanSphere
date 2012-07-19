<?PHP
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_gray($imgfile)
{
  $info = getimagesize($imgfile);
  switch($info[2])
  {
    case 1:
      $cs_lang = cs_translate('gallery');
      $message = $cs_lang['gray_error'] . cs_html_br(1);
      $g_error = 1;
    break;
    case 2:
      $sourceImage = imagecreatefromjpeg($imgfile);
    break;
    case 3:
      $sourceImage = imagecreatefrompng($imgfile);
    break;
    }
  if(empty($g_error))
  {
    $img_width  = imagesx($sourceImage);
    $img_height = imagesy($sourceImage);

    for ($y = 0; $y <$img_height; $y++)
    {
      for ($x = 0; $x <$img_width; $x++)
      {
        $rgb = imagecolorat($sourceImage, $x, $y);
        $red  = ($rgb >> 16) & 0xFF;
        $green = ($rgb >> 8)  & 0xFF;
        $blue  = $rgb & 0xFF;

        $gray = round(.299*$red + .587*$green + .114*$blue);
        $grayR = $gray << 16;  // R: red
        $grayG = $gray << 8;  // G: green
        $grayB = $gray;      // B: blue

        $grayColor = $grayR | $grayG | $grayB;
        imagesetpixel ($sourceImage, $x, $y, $grayColor);
        imagecolorallocate ($sourceImage, $gray, $gray, $gray);
      }
    }

    $destinationImage = imagecreatetruecolor($img_width, $img_height);
    imagecopy($destinationImage, $sourceImage, 0, 0, 0, 0, $img_width, $img_height);

    switch($info[2])
    {
      case 2:
        return imagejpeg($destinationImage, $imgfile);
      break;
      case 3:
        return imagepng($destinationImage, $imgfile);
      break;
      }
    imagedestroy($destinationImage);
    imagedestroy($sourceImage);
  }
}