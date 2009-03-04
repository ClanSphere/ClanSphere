<?php

$cs_lang = cs_translate('servers');

// Head
echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_create'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');


// Submit Post
if(isset($_POST['submit'])) {

  $servers_error = 0; 
  $errormsg = $cs_lang['error_occurred'] . cs_html_br(1);;

  $cs_servers['servers_name'] = $_POST['servers_name'];
  $cs_servers['servers_ip'] = $_POST['servers_ip'];
  $cs_servers['servers_port'] = $_POST['servers_port'];
  $cs_servers['games_id'] = $_POST['games_id'];
  $cs_servers['servers_info'] = $_POST['servers_info'];
  $cs_servers['servers_slots'] = $_POST['servers_slots'];
  $cs_servers['servers_type'] = $_POST['servers_type'];
  $cs_servers['servers_stats'] = $_POST['servers_stats'];
  $cs_servers['servers_class'] = $_POST['servers_class'];
  $cs_servers['servers_query'] = $_POST['servers_query'];
  $cs_servers['servers_order'] = $_POST['servers_order'];

  if(empty($cs_servers['servers_name'])) {
    $servers_error++;
    $errormsg .= $cs_lang['no_name'] . cs_html_br(1);
  }
  if(empty($cs_servers['servers_ip'])) {
    $servers_error++;
    $errormsg .= $cs_lang['no_ip'] . cs_html_br(1);
  }
  if(empty($cs_servers['servers_port'])) {
    $servers_error++;
    $errormsg .= $cs_lang['no_port'] . cs_html_br(1);
  }
  if(empty($cs_servers['games_id'])) {
    $servers_error++;
    $errormsg .= $cs_lang['no_game'] . cs_html_br(1);
  }
  if(empty($cs_servers['servers_type'])) {
    $servers_error++;
    $errormsg .= $cs_lang['no_type'] . cs_html_br(1);
  }
  if(empty($cs_servers['servers_stats'])) {
    $servers_error++;
    $errormsg .= $cs_lang['no_stats'] . cs_html_br(1);
  }
  if(empty($cs_servers['servers_class'])) {
    $servers_error++;
    $errormsg .= $cs_lang['no_class'] . cs_html_br(1);
  }
  if(empty($cs_servers['servers_query'])) {
    $servers_error++;
    $errormsg .= $cs_lang['no_query'] . cs_html_br(1);
  }

// Create new Entry
} else {
  $cs_servers['servers_name'] = '';
  $cs_servers['servers_ip'] = '';
  $cs_servers['servers_port'] = '';
  $cs_servers['games_id'] = '';
  $cs_servers['servers_info'] = $cs_lang['server_infos_no_stats'];
  $cs_servers['servers_slots'] = '';
  $cs_servers['servers_stats'] = '';
  $cs_servers['servers_type'] = '';
  $cs_servers['servers_class'] = '';
  $cs_servers['servers_query'] = '';
  $cs_servers['servers_order'] = '';

}
if(!isset($_POST['submit'])) {
  echo $cs_lang['body_create'];
}
elseif(!empty($servers_error)) {
  echo $errormsg;
}


if(!empty($servers_error) OR !isset($_POST['submit'])) {

echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

  // Start Form
  echo cs_html_form (1,'servers_create','servers','create');
  echo cs_html_table(1,'forum',1);

  // Server-Name
  echo cs_html_roco(1,'leftc');
  echo cs_icon('kedit') . $cs_lang['servername']. ' *';
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('servers_name',$cs_servers['servers_name'],'text',200,50);
  echo cs_html_roco(0);

  // Server-IP
  echo cs_html_roco(1,'leftc');
  echo cs_icon('kedit') . $cs_lang['serverip']. ' *';
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('servers_ip',$cs_servers['servers_ip'],'text',200,50);
  echo cs_html_roco(0);

  // Server-Port
  echo cs_html_roco(1,'leftc');
  echo cs_icon('kedit') . $cs_lang['serverport']. ' *';
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('servers_port',$cs_servers['servers_port'],'text',200,10);
  echo cs_html_roco(0);

  // Server Game
  echo cs_html_roco(1,'leftc');
  echo cs_icon('kedit') . $cs_lang['serverspiel']. ' *';
  echo cs_html_roco(2,'leftb');
  $games = cs_sql_select(__FILE__,'games','games_name, games_id',0,1,1,0);
  echo cs_html_select(1,'games_id','onchange="cs_gamechoose(this.form)"');
  echo cs_html_option('----',0,1);
  if (!empty($games))
    foreach ($games AS $game)
      echo cs_html_option($game['games_name'],$game['games_id']);
  echo cs_html_select(0);
  #echo cs_dropdown('games_id','games_name',$games,$cs_servers['games_id'].'" onchange="cs_gamechoose(this.form)');
  echo cs_html_img('uploads/games/0.gif',0,0,'id="game_1"');
  echo cs_html_roco(0);
  
  // Zusatz
  echo cs_html_roco(1,'headb',1,2);
  echo $cs_lang['Erweiterter'] . ' - ' . $cs_lang['Serverstatus'];
  echo cs_html_roco(0);

  // Live Status on/off
  echo cs_html_roco(1,'leftc');
  echo cs_icon('kate') . $cs_lang['Serverstatus']. ' *';
  echo cs_html_roco(2,'leftb');
  $stats[0]['servers_stats'] = '2';
  $stats[0]['name'] = $cs_lang['no'];
  $stats[1]['servers_stats'] = '1';
  $stats[1]['name'] = $cs_lang['yes'];
  echo cs_dropdown('servers_stats','name',$stats,$cs_servers['servers_stats']);

  // Protokoll        
  echo cs_html_roco(0);
  echo cs_html_roco(1,'leftc');
  echo cs_icon('kate') . $cs_lang['proto']. ' *';
  echo cs_html_roco(2,'leftb');

  $server_array = array(
    array('name' => '(kein)', 'servers_class' => '1'),
    array('name' => 'Americans Army', 'servers_class' => 'aa'),
    array('name' => 'Armagetronad', 'servers_class' => 'atron'),
    array('name' => 'Battlefield', 'servers_class' => 'bf'),  
    array('name' => 'Battlefield 2', 'servers_class' => 'bf2'),  
    array('name' => 'Battlefield 2142', 'servers_class' => 'bf2142'),  
    array('name' => 'Battlefield Vietnam', 'servers_class' => 'bfv'),
    array('name' => 'C&C Renegade', 'servers_class' => 'renegade'),  
    array('name' => 'Call of Duty', 'servers_class' => 'cod'),  
    array('name' => 'Call of Duty 2', 'servers_class' => 'cod2'),  
    array('name' => 'Call of Duty 4', 'servers_class' => 'cod4'),      
    array('name' => 'Doom 3', 'servers_class' => 'd3'),   
    array('name' => 'Descent 3', 'servers_class' => 'descent3'),   
    array('name' => 'Descent 3 Gamespy', 'servers_class' => 'des3gs'), 
    array('name' => 'Enemy Territory', 'servers_class' => 'et'),   
    array('name' => 'Enemy Territory Quake Wars', 'servers_class' => 'etqw'), 
    array('name' => 'Fear', 'servers_class' => 'fear'),
    array('name' => 'Halo', 'servers_class' => 'halo'),   
    array('name' => 'Hiddem & Dangerous 2', 'servers_class' => 'hd2'),
    array('name' => 'Half-Life & Mods / Half-Life 2', 'servers_class' => 'hl'),
    array('name' => 'Half-Life Old', 'servers_class' => 'hl_old'),
    array('name' => 'Jedi Knight: Jedi Academy / Jedi Knight 2', 'servers_class' => 'jedi'),  
    array('name' => 'Medal of Honor', 'servers_class' => 'mohaa'),
    array('name' => 'No One Lives Forever', 'servers_class' => 'nolf'),
    array('name' => 'Painkiller', 'servers_class' => 'pk'),
    array('name' => 'Quake 1 / Quakeworld', 'servers_class' => 'q1'),
    array('name' => 'Quake 2', 'servers_class' => 'q2'),
    array('name' => 'Quake 3 Arena', 'servers_class' => 'q3a'),  
    array('name' => 'Quake 4', 'servers_class' => 'q4'),
    array('name' => 'Return to Castle Wolfenstein', 'servers_class' => 'rtcw'),  
    array('name' => 'Rune', 'servers_class' => 'rune'),
    array('name' => 'Soldier of Fortune 2', 'servers_class' => 'sof2'),
    array('name' => 'S.W.A.T.', 'servers_class' => 'swat'),
    array('name' => 'TeamSpeak 2', 'servers_class' => 'ts'),
    array('name' => 'Unreal Tournament', 'servers_class' => 'ut'),
    array('name' => 'Unreal Tournament 2003 & 2004 / Red Orchestra', 'servers_class' => 'ut2004'),  
    array('name' => 'Unreal Tournament 3', 'servers_class' => 'ut3'),      
    array('name' => 'Warsor', 'servers_class' => 'warsow')
  );

  echo cs_html_select(1,'servers_class');
  foreach($server_array AS $class) {
    $select = $class['servers_class'] == $cs_servers['servers_class'] ? $select = 1 : $select = 0;
    echo cs_html_option($class['name'],$class['servers_class'],$select);
  }
  echo cs_html_select(0);
    
  // Server Query Port
  echo cs_html_roco(0);
  echo cs_html_roco(1,'leftc');
  echo cs_icon('kate') . $cs_lang['serverquerry']. ' *';
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('servers_query',$cs_servers['servers_query'],'text',200,10);
  echo cs_html_roco(0);

  // Server Sort Order
  echo cs_html_roco(1,'headb',1,2);
  echo $cs_lang['Erweiterter'] . ' - ' . $cs_lang['order']. ' *';
  echo cs_html_roco(0);
  echo cs_html_roco(0);
  echo cs_html_roco(1,'leftc');
  echo cs_icon('kate') . $cs_lang['serverorder'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('servers_order',$cs_servers['servers_order'],'text',3,3);
  echo cs_html_roco(0);

  // Zusatz wenn Live off
  echo cs_html_roco(1,'headb',1,2);
  echo $cs_lang['Erweiterter'] . ' - ' . $cs_lang['liveoff'];

  // Serverstype
  echo cs_html_roco(1,'leftc');
  echo cs_icon('kate') . $cs_lang['type']. ' *';
  echo cs_html_roco(2,'leftb');
  $type[0]['servers_type'] = '3';
  $type[0]['gtype'] = $cs_lang['voiceserver'];
  $type[1]['servers_type'] = '2';
  $type[1]['gtype'] = $cs_lang['pubserver'];
  $type[2]['servers_type'] = '1';
  $type[2]['gtype'] = $cs_lang['clanserver'];
  echo cs_dropdown('servers_type','gtype',$type,$cs_servers['servers_type']);

  // Server Info
  echo cs_html_roco(1,'leftc');
  echo cs_icon('kedit') . $cs_lang['serverinfo'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_textarea('servers_info',$cs_servers['servers_info'],'75','5');
  echo cs_html_roco(0);

  // Server Slots
  echo cs_html_roco(1,'leftc');
  echo cs_icon('kedit') . $cs_lang['slots'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('servers_slots',$cs_servers['servers_slots'],'text','4','5');
  echo cs_html_roco(0);


  // Options  
  echo cs_html_roco(1,'leftc');
  echo cs_icon('ksysguard') . $cs_lang['options'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_vote('submit',$cs_lang['create'],'submit');
  echo cs_html_vote('reset',$cs_lang['reset'],'reset');
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_form (0);

} else {

  // Insert SQL Data
  $servers_cells = array_keys($cs_servers);
  $servers_save = array_values($cs_servers);
  cs_sql_insert(__FILE__,'servers',$servers_cells,$servers_save);
  
  // Include RSS Feed
  include_once('mods/servers/rss.php');

  // Create Finish    
  cs_redirect($cs_lang['create_done'],'servers');
}

?>
