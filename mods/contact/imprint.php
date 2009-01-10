<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('contact');

$filename = 'uploads/imprint/imprint.txt';

if (file_exists($filename)) {
  $fp = fopen ($filename, "r");
  $content = fread ($fp, filesize($filename));
  $imprint = explode("{laststandbreak}", $content);
  fclose ($fp);
}

$data['if']['date'] = file_exists($filename) ? TRUE : FALSE;
if(file_exists($filename)) {
  $data['imprint']['content'] = cs_secure($imprint[1],1,1);
  $stand = '[b]' .$cs_lang['stand'] .' '. cs_date('unix',$imprint[0]) .'[/b]';
  $data['imprint']['date'] = cs_secure($stand,1,1);
} else {
  $data['imprint']['content'] = cs_secure ('-');

}

echo cs_subtemplate(__FILE__,$data,'contact','imprint');

?>
