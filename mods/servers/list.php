<?php
$cs_lang = cs_translate('servers');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo $cs_lang['mod_list'];
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

/* Test if fsockopen active */
if (fsockopen("udp://127.0.0.1", 1)) {
    if (4.3 <= substr(phpversion(), 0, 3)) {
      include('functions.php');

    /* Get Server SQL-Data */
      $select = 'servers_name, servers_ip, servers_port, servers_info, servers_query, servers_class, servers_stats, servers_order';
      $order = 'servers_order DESC';
      $cs_servers = cs_sql_select(__FILE__,'servers',$select,0,$order,0,0);
      $cs_servers_count = count($cs_servers);
  
    /* if Server in SQL */
      if(!empty($cs_servers_count)) {
      $gameserver = array();

      /* Create Gameserver Variable */
        for($gs = 0; $gs < $cs_servers_count; $gs++) {
          $gameserver[] = $cs_servers[$gs]['servers_class'] . ':' . $cs_servers[$gs]['servers_ip'] . ':' . $cs_servers[$gs]['servers_port'] . ':' . $cs_servers[$gs]['servers_query'] . ':' . $cs_servers[$gs]['servers_stats'];
        }

      /* Settings */
        define ('PHGDIR', 'mods/servers/');
        $use_file = '?mod=servers&action=list';    
        $use_bind = '&';   

        function dns($host){ $address = gethostbyname($host); return $address; }
        $country = array('Germany','Germany','Germany','Germany','Germany','Germany','Germany','Germany','Germany','Germany','Germany','Germany','Germany','Germany','Germany','Germany','Germany'); 
        include_once(PHGDIR . 'classes/phgstats.class.php');  
        $phgdir = PHGDIR;
      
      /* how much server have to be scanned */
      $index = count($gameserver);

      while($index) {
          $index--;
          list($game[$index], $host[$index], $port[$index], $queryport[$index], $stats[$index]) = split(':', $gameserver[$index]);
      }

      /* if ($host[$HTTP_GET_VARS["sh_srv"]]) */
      if ( IsSet($_GET['sh_srv'])) {   
          $sh_srv = $_GET["sh_srv"];

          /* gameserver data */
          $srv_rules = info($phgdir, $sh_srv, $game, $host, $port, $queryport, $country, $stats);    
          srv_info($sh_srv, $srv_rules, $use_file, $use_bind, 0, 0);
      }
      else {
          $sh_srv = count($host);
        
          if ($sh_srv > 1) {
            global $cs_lang;
            /* html: open table to show more server */
              echo cs_html_table(1,'forum',1);
              echo cs_html_roco(1,'leftb',0,3);
              echo cs_html_div(1,'text-align:center');
              echo cs_link($cs_lang['refresh'],'servers','list');
              echo cs_html_div(0);
              echo cs_html_roco(0);
              echo cs_html_table(0);
              echo cs_html_br(1);
  
            /* html: titles (game, hostname, players, map) */
          echo cs_html_table(1,'forum',1);
                echo cs_html_roco(1,'leftb');
                echo cs_html_div(1,'text-align:center');
                echo $cs_lang['server'];
              echo cs_html_div(0);
                echo cs_html_roco(2,'leftb');
              echo cs_html_div(1,'text-align:center');
              echo $cs_lang['info'];
              echo cs_html_div(0);
              echo cs_html_roco(3,'leftb');
              echo cs_html_div(1,'text-align:center');
              echo $cs_lang['map'];
              echo cs_html_div(0);
              echo cs_html_roco(0);

          /* html: gameserver list data */
          while ($sh_srv) {
              $sh_srv--;
              $srv_rules = info($phgdir, $sh_srv, $game, $host, $port, $queryport, $country, $stats);
              srv_list($sh_srv, $srv_rules, $use_file, $use_bind);
              flush();
          }
            echo cs_html_table(0);
        }
        else {
              $sh_srv--;
  
          /* gameserver data */
          $srv_rules = info($phgdir, $sh_srv, $game, $host, $port, $queryport, $country, $stats);
              srv_info($sh_srv, $srv_rules, $use_file, $use_bind, 1);
          }
      }

      /* html: our copyright, dont remove ! */
        echo cs_html_br(1);
        echo cs_html_table(1,'forum',1);
        echo cs_html_roco(1,'rightb');
        echo cs_html_link('http://phgstats.sourceforge.net/','based on phgstats','_blank');
        echo cs_html_roco(0);
        echo cs_html_table(0);
    }
    else {
      /* No Server in SQL */
        echo cs_html_table(1,'forum',1);
        echo cs_html_roco(1,'leftb');
        echo $cs_lang['no_server'];
        echo cs_html_roco(0);
        echo cs_html_table(0);
    }
  }
  else {
    /* Old PHP Version */
      echo cs_html_table(1,'forum',1);
      echo cs_html_roco(1,'leftb');
      echo $cs_lang['php'];
      echo cs_html_roco(0);
      echo cs_html_table(0);
  } 
}
else {  
  /* if fsockopen deactive, list servers */
    $tables = 'servers srv INNER JOIN {pre}_games gam ON srv.games_id = gam.games_id';
    $select = 'srv.servers_name AS servers_name, srv.servers_ip AS servers_ip, srv.servers_port AS servers_port';
    $select .= ', srv.servers_info AS servers_info, srv.servers_slots AS servers_slots, srv.servers_type AS servers_type';
    $select .= ', gam.games_name AS games_name, gam.games_id AS games_id';
    $order = 'srv.servers_order';
    $cs_servers = cs_sql_select(__FILE__,$tables,$select,0,$order,0,0);
    $cs_servers_count = count($cs_servers);

  for($serv=0; $serv < $cs_servers_count; $serv++) {
   
      /* Table Start */
      echo cs_html_table(1,'forum',1);

      /* Head Servername */
      echo cs_html_roco(1,'headb',0,2);
      echo $cs_servers[$serv]['servers_name'];
      echo cs_html_roco(0);

      /* Server-IP:Port */
      echo cs_html_roco(1,'leftc');
      echo $cs_lang['ip'];
      echo cs_html_roco(2,'leftb');
      $url = $cs_servers[$serv]['servers_ip'] . ':' . $cs_servers[$serv]['servers_port'];
      echo cs_html_link('HLSW://' . $url,$url,'_blank');
      echo cs_html_roco(0);

      /* Type */
      echo cs_html_roco(1,'leftc');
      echo $cs_lang['type'];
      echo cs_html_roco(2,'leftb');
    switch ($cs_servers[$serv]['servers_type']) {
         case 1:
            echo $cs_lang['clanserver'];
            break;
         case 2:
            echo $cs_lang['pubserver'];
            break;
         case 3:
            echo $cs_lang['voiceserver'];
          break;
      }
    echo cs_html_roco(0);

      /* Slots */
      echo cs_html_roco(1,'leftc');
      echo $cs_lang['slots'] . ':';
      echo cs_html_roco(2,'leftb');
      echo $cs_lang['max'] . $cs_servers[$serv]['servers_slots'] . $cs_lang['slots'];
      echo cs_html_roco(0);

      /* Game */
      echo cs_html_roco(1,'leftc');
      echo $cs_lang['type'];
      echo cs_html_roco(2,'leftb');
      $img = 'uploads/games/' . $cs_servers[$serv]['games_id'] . '.gif';
      echo cs_html_img($img,0,0) . ' ' . $cs_servers[$serv]['games_name'];
      echo cs_html_roco(0);
 
      /* Table End */
      echo cs_html_table(0);
      echo cs_html_br(1);
  }
}
?>