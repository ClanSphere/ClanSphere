<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('install');
$data = array();

$languages = cs_checkdirs('lang');

$i = 0;
foreach($languages as $lang) {
  $data['languages'][$i]['name'] = $lang['name'];
  $data['languages'][$i]['symbol'] = $lang['symbol'];
  $data['languages'][$i]['link'] = cs_url('install','compatible','lang='.$lang['name']);
  $i++;
}

echo cs_subtemplate(__FILE__,$data,'install');