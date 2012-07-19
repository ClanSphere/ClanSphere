<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

//$cs_lang = cs_translate('gallery');
echo '<SCRIPT LANGUAGE="JavaScript"><!-- if (window.print) { window.print(); setTimeout(\'self.close()\',5000); } //--></SCRIPT>';

if(!empty($_REQUEST['pic'])) {

  $pic = htmlentities($_REQUEST['pic'], ENT_QUOTES);
  $size = empty($_REQUEST['size']) ? 0 : htmlentities($_REQUEST['size'], ENT_QUOTES);
  
  echo "<img src=\"image.php?pic=" . $pic . "&size=" . $size . " class=\"mediumimage\" border=\"0\" alt=\"\">";
}
else {

  echo '<SCRIPT LANGUAGE="JavaScript"><!-- setTimeout(\'self.close()\',2000); //--></SCRIPT>';

  echo 'bye bye';
}