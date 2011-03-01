<?php
function dns($host) {
  return gethostbyname($host);
}

function returnClassbyID($id) {
  $server_class = array(0 => 'aa3',1 => 'ase',2 => 'breed',3 => 'cry',4 => 'cs2d',5 => 'cube',6 => 'doom3',7 => 'ffow',
  8 => 'freelancer',9 => 'gamespy',10 => 'gamespy2',11 => 'gamespy3',12 => 'ghostrecon',13 => 'halflife',
  14 => 'hexen2',15 => 'openttd',16 => 'quake2',17 => 'quake3',18 => 'quakewars',19 => 'quakeworld',
  20 => 'redfaction',21 => 'rfactor',22 => 'samp',23 => 'sauerbraten',24 => 'savage2',25 => 'ship',
  26 => 'silverback',27 => 'source',28 => 'teeworlds',29 => 'tribes',30 => 'tribes2',31 => 'ts2',
  32 => 'ts3',33 => 'u2e',34 => 'unreal2',35 => 'ut3',36 => 'ventrilo',37 => 'warsow'
  );
  return $server_class[$id];
}

