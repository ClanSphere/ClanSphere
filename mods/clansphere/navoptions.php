<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$admin = cs_checkdirs('mods','options/roots');

foreach($admin as $mod) {
  $acc_dir = 'access_' . $mod['dir'];
  
  if(array_key_exists($acc_dir,$account) AND $account[$acc_dir] >= $mod['show']['options/roots']) {
    echo cs_icon($mod['icon']);
    echo cs_link($mod['name'],$mod['dir'],'options');
    echo cs_html_br(1);
  }
}
