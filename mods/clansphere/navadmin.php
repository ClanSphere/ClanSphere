<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$admin = cs_checkdirs('mods','clansphere/admin');

foreach($admin as $mod) {
  $acc_dir = 'access_' . $mod['dir'];
  
  if(array_key_exists($acc_dir,$account) AND $account[$acc_dir] >= $mod['show']['clansphere/admin']) {
    echo cs_icon($mod['icon']);
    echo cs_link($mod['name'],$mod['dir'],'manage');
    echo cs_html_br(1);
  }
}