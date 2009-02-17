<?php
// ClanSphere 2008 - www.clansphere.net

$cs_lang = cs_translate('servers');

// Test if fsockopen active
if (fsockopen("udp://127.0.0.1", 1)) {
  $check['php'] = phpversion();
  if (4.3 <= substr($check['php'], 0, 3)) {
  
    // Get Server SQL-Data
    if(!empty($_GET['sid'])) {
      $where = "servers_id = '" . $_GET['sid'] . "'";
    } else {
      $where = 0;
    }
    $select = 'servers_name, servers_ip, servers_port, servers_info, servers_query, servers_class, servers_stats, servers_order';
    $order = 'servers_order DESC';
    $cs_servers = cs_sql_select(__FILE__,'servers',$select,$where,$order,0,0);
    $cs_servers_count = count($cs_servers);
  
    // Create Gameserver Variable
    $gameserver = array();
    for($gs = 0; $gs < $cs_servers_count; $gs++) {
      $gameserver[] = $cs_servers[$gs]['servers_class'] . ':' . $cs_servers[$gs]['servers_ip'] . ':' . 
      $cs_servers[$gs]['servers_port'] . ':' . $cs_servers[$gs]['servers_query'] . ':' . $cs_servers[$gs]['servers_stats'];
    }
 
    // Settings
    $use_file = '?mod=servers&action=list';    
    $use_bind = '&';   
  
    if (!defined('PHGDIR')) { define ('PHGDIR', 'mods/servers/'); }
    $country = array('Germany'); 
    include_once(PHGDIR . 'classes/phgstats.class.php');  
    $phgdir = PHGDIR;
  
  $index = count($gameserver);
  while($index) {
      $index--;
      list($game[$index], $host[$index], $port[$index], $queryport[$index], $stats[$index]) = split(':', $gameserver[$index]);
    }
  
  //if ($host[$HTTP_GET_VARS["sh_srv"]])
    $sh_srv = 0;

    // gameserver data
    for($run=0; $run<count($gameserver); $run++) {
      $sh_srv = $run;
      $srv_rules_navlist = info_navlist($phgdir, $sh_srv, $game, $host, $port, $queryport, $country, $stats);  
      srv_info_navlist($sh_srv, $srv_rules_navlist, $use_file, $use_bind, 0, 0);
    }

  } else {
  //Old PHP Version
  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'leftb');
  echo $cs_lang['php'];
  echo cs_html_roco(0);
  echo cs_html_table(0);
  }
}
?>