<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$languages = cs_checkdirs('lang');

foreach($languages as $lang) {
  $img = cs_html_img('symbols/countries/' . $lang['symbol'] . '.png',0,0,' title="' . $lang['name'] . '"');
  $lnk = cs_link($img,$cs_main['def_mod'],$cs_main['def_action'],'lang=' . $lang['name']);
  $out = $lang['name'] == $account['users_lang'] ? $img : $lnk;
  echo $out . ' ';
}