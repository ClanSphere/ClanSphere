<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('contact');

$filename = 'uploads/imprint/imprint.txt';

$exists = file_exists($filename) ? TRUE : FALSE;

if ($exists) {
  $fp = fopen ($filename, "r");
  $content = fread ($fp, filesize($filename));
  $imprint = explode("{laststandbreak}", $content);
  fclose ($fp);
}

$data['if']['date'] = $exists;
if(!empty($data['if']['date'])) {
  $data['imprint']['content'] = cs_secure($imprint[1],1,1,1,1);
  $stand = '[b]' .$cs_lang['stand'] .' '. cs_date('unix',$imprint[0]) .'[/b]';
  $data['imprint']['date'] = cs_secure($stand,1,1);
} else {
  $data['imprint']['content'] = '-';

}

echo cs_subtemplate(__FILE__,$data,'contact','imprint');
