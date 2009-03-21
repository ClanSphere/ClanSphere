<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$languages = cs_checkdirs('lang');

foreach($languages as $lang) {
  $img = cs_html_img('symbols/countries/' . $lang['symbol'] . '.png');
  $lnk = cs_link($lang['name'],$cs_main['def_mod'],$cs_main['def_action'],'lang=' . $lang['name']);
  $out = $lang['name'] == $account['users_lang'] ? $lang['name'] : $lnk;
  echo $img . ' ' . $out;
  echo cs_html_br(2);
}

?>