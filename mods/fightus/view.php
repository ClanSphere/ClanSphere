<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('fightus');
$cs_get = cs_get('id');
$data = array();

include_once('lang/' . $account['users_lang'] . '/countries.php');

$fightus_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

$data['fightus']['url_convert_clan'] = cs_url('clans','create','fightus=' . $fightus_id);
$data['fightus']['url_convert_war'] = cs_url('wars','create','fightus=' . $fightus_id);

$select = 'fightus_since, fightus_nick, fightus_email, fightus_icq, fightus_jabber, games_id, squads_id, ';
$select .= 'fightus_clan, fightus_short, fightus_country, fightus_url, fightus_date, fightus_more';
$cs_fightus = cs_sql_select(__FILE__,'fightus',$select,"fightus_id = '" . $fightus_id . "'");


$data['fightus']['since'] = cs_date('unix',$cs_fightus['fightus_since'],1);
$data['fightus']['nick'] = cs_secure($cs_fightus['fightus_nick']);
$data['fightus']['email'] = cs_html_mail($cs_fightus['fightus_email'],$cs_fightus['fightus_email']);

if(!empty($cs_fightus['fightus_icq'])) { 
  $data['fightus']['icq'] = cs_html_link('http://www.icq.com/people/' . $cs_fightus['fightus_icq'],$cs_fightus['fightus_icq']);
} else {
  $data['fightus']['icq'] = '-'; 
}

if(!empty($cs_fightus['fightus_jabber'])) { 
  $data['fightus']['jabber'] = cs_html_jabbermail($cs_fightus['fightus_jabber']);
} else {
  $data['fightus']['jabber'] = '-'; 
}

if(!empty($cs_fightus['games_id'])) {
  $data['fightus']['game'] = cs_html_img('uploads/games/' . $cs_fightus['games_id'] . '.gif');
  $where = "games_id = '" . $cs_fightus['games_id'] . "'";
  $cs_game = cs_sql_select(__FILE__,'games','games_name, games_id',$where);
  $data['fightus']['game'] .= cs_link($cs_game['games_name'],'games','view','id=' . $cs_game['games_id']);
}
else {
  $data['fightus']['game'] = '-';
}

if(!empty($cs_fightus['squads_id'])) {
  $where = "squads_id = '" . $cs_fightus['squads_id'] . "'";
  $cs_squad = cs_sql_select(__FILE__,'squads','squads_name, squads_id',$where);
  $data['fightus']['squad'] = cs_link($cs_squad['squads_name'],'squads','view','id=' . $cs_squad['squads_id']);
} else {
  $data['fightus']['squad'] = '-';
}

$data['fightus']['clan'] = cs_secure($cs_fightus['fightus_clan']);
$data['fightus']['short'] = cs_secure($cs_fightus['fightus_short']);

$url = 'symbols/countries/' . $cs_fightus['fightus_country'] . '.png';
$country = $cs_fightus['fightus_country'];
$data['fightus']['country'] = cs_html_img($url,11,16) . ' ' . $cs_country[$country];

if(!empty($cs_fightus['fightus_url'])) {
  $cs_fightus['fightus_url'] = cs_secure($cs_fightus['fightus_url']);
  $data['fightus']['url'] = cs_html_link('http://' . $cs_fightus['fightus_url'],$cs_fightus['fightus_url']);
} else {
  $data['fightus']['url'] = '-';
}

$data['fightus']['date'] = cs_date('unix',$cs_fightus['fightus_date'],1);
$data['fightus']['more'] = cs_secure($cs_fightus['fightus_more'],1,1);


echo cs_subtemplate(__FILE__,$data,'fightus','view');