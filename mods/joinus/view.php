<?php
// ClanSphere 2010 - www.clansphere.net
// Id: view.php (Tue Nov 25 11:32:52 CET 2008) fAY-pA!N

$cs_lang = cs_translate('joinus');
$cs_get = cs_get('id');

$joinus_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

$cs_joinus = cs_sql_select(__FILE__,'joinus','*',"joinus_id = '" . $joinus_id . "'");

$data['link']['convert'] = cs_link($cs_lang['convert'],'joinus','convert','id=' . $joinus_id);

$data['join']['since'] = cs_date('unix',$cs_joinus['joinus_since'],1);
$data['join']['nick'] = cs_secure($cs_joinus['joinus_nick']);
$data['join']['name'] = empty($cs_joinus['joinus_name']) ? '-' : cs_secure($cs_joinus['joinus_name']);
$data['join']['surname'] = empty($cs_joinus['joinus_surname']) ? '-' : cs_secure($cs_joinus['joinus_surname']);

if (empty($cs_joinus['joinus_age'])) { $data['join']['age'] = '-'; } 
else {
   $content = cs_date('date',$cs_joinus['joinus_age']);
  $birth = explode ('-', $cs_joinus['joinus_age']);
  $age = cs_datereal('Y') - $birth[0];
  if(cs_datereal('m')<=$birth[1]) { $age--; }
  if(cs_datereal('d')>=$birth[2] AND cs_datereal('m')==$birth[1]) { $age++; }
  $data['join']['age'] = $content . ' (' . $age . ')';
}

$data['join']['place'] = empty($cs_joinus['joinus_place']) ? '-' : cs_secure($cs_joinus['joinus_place']);

if(empty($cs_joinus['joinus_country'])) { $data['join']['country'] = '-'; }
else {
  $url = 'symbols/countries/' . $cs_joinus['joinus_country'] . '.png';
  $flag = cs_html_img($url,11,16);
  include_once('lang/' . $account['users_lang'] . '/countries.php');
  $country = $cs_joinus['joinus_country'];
  $data['join']['country'] = $flag . ' ' . $cs_country[$country];
}


$data['join']['email'] = empty($cs_joinus['joinus_email']) ? '-' : cs_html_mail($cs_joinus['joinus_email'],$cs_joinus['joinus_email']);

if(empty($cs_joinus['joinus_icq'])) { $data['join']['icq'] = '-'; } 
else { 
  $cs_icqstart = 'http://web.icq.com/whitepages/online?icq=';
  $flower = cs_html_img($cs_icqstart . $cs_joinus['joinus_icq'] . '&amp;img=21','16','15');
  $num = cs_html_link('http://www.icq.com/' . $cs_joinus['joinus_icq'],$cs_joinus['joinus_icq']);
  $data['join']['icq'] = $flower . ' ' . $num;
}

if(empty($cs_joinus['joinus_msn'])) { $data['join']['msn'] = '-'; } 
else { 
  $cs_joinus['joinus_msn'] = cs_secure($cs_joinus['joinus_msn']);
  $data['join']['msn'] = cs_html_link('http://members.msn.com/' . $cs_joinus['joinus_msn'],$cs_joinus['joinus_msn']);
}

if(empty($cs_joinus['games_id'])) { $data['join']['game'] = '-'; }
else {
  $img = cs_html_img('uploads/games/' . $cs_joinus['games_id'] . '.gif');
  $where = "games_id = '" . $cs_joinus['games_id'] . "'";
  $cs_game = cs_sql_select(__FILE__,'games','games_name, games_id',$where);
  $link = cs_link($cs_game['games_name'],'games','view','id=' . $cs_game['games_id']);
  $data['join']['game'] = $img . ' ' . $link;
}

if(empty($cs_joinus['squads_id'])) { $data['join']['squad'] = '-'; }
else {
  $where = "squads_id = '" . $cs_joinus['squads_id'] . "'";
  $cs_squad = cs_sql_select(__FILE__,'squads','squads_name, squads_id',$where);
  $data['join']['squad'] = cs_link($cs_squad['squads_name'],'squads','view','id=' . $cs_squad['squads_id']);
}

$data['join']['webcon'] = empty($cs_joinus['joinus_webcon']) ? '-' : cs_secure($cs_joinus['joinus_webcon']);
$data['join']['lanact'] = empty($cs_joinus['joinus_lanact']) ? '-' : cs_secure($cs_joinus['joinus_lanact']);
$data['join']['date'] = cs_date('date',$cs_joinus['joinus_date']);
$data['join']['more'] = empty($cs_joinus['joinus_more']) ? '-' : cs_secure($cs_joinus['joinus_more'],1,1);


echo cs_subtemplate(__FILE__,$data,'joinus','view');