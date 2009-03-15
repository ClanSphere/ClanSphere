<?php
     
/*
 * get data of server
 */ 
function info($phgdir, $sh_srv, $game, $host, $port, $queryport, $country, $stats) {


  if ($server === true) {
  }
  else {
    /* default values if no response */
    $tables = 'servers ser INNER JOIN {pre}_games gam on ser.games_id = gam.games_id';
         $select = 'ser.servers_name AS servers_name, ser.servers_ip AS servers_ip, ser.servers_port AS servers_port';
       $select .= ', ser.servers_info AS servers_info, gam.games_name AS games_name';
      $where = "ser.servers_ip = '" . $host[$sh_srv] . "' AND ser.servers_port = '" . $port[$sh_srv] . "'";
         $order = 'ser.servers_order DESC';
         $cs_servers = cs_sql_select(__FILE__,$tables,$select,$where,0,0,0);
    
      $srv_detail = "";
    
    $srv_rules['playerlist'] = '';
    $srv_rules['hostname']    = $cs_servers[0]['servers_name'];
    $srv_rules['gamename']    = $cs_servers[0]['games_name'];
       $srv_rules['map']         = $phgdir . 'maps/no_response.jpg';
       $srv_rules['mapname']     = '';
       $srv_rules['sets']        = '';
       $srv_rules['htmlinfo']    = cs_html_br(1) . cs_html_div(1,'text-align:center;') . $cs_servers[0]['servers_info'] . cs_html_div(0);
       $srv_rules['htmldetail']  = cs_html_roco(1,'leftb',0,2) . cs_html_br(1) . cs_html_div(1,'text-align:center;');
      $srv_rules['htmldetail'] .= $cs_servers[0]['servers_info'] . cs_html_div(0) . cs_html_roco(0);
  }
  /* get server day time */
    $srv_rules['time']= cs_date(1,cs_time(),1);
      
  /* get server country / location */
  $srv_rules['country'] = $country[$sh_srv];

  /* get server adress */
  $srv_rules['adress'] = $host[$sh_srv] . ':' . $port[$sh_srv];
    
  return $srv_rules;
}  

function dns($host) {
	return gethostbyname($host); 
}      
?>