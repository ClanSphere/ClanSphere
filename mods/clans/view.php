<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clans');

$op_clans = cs_sql_option(__FILE__,'clans');
$op_squads = cs_sql_option(__FILE__,'squads');
$op_members = cs_sql_option(__FILE__,'members');

$cs_clans_id = $_GET['id'];
settype($cs_clans_id,'integer');

$where = "clans_id='" . $cs_clans_id . "'";  
$cs_clan = cs_sql_select(__FILE__,'clans','*',$where);

$data['lang']['mod_name'] = $cs_lang[$op_clans['label']];
$data['clans']['name'] = cs_secure($cs_clan['clans_name']);

if(empty($cs_clan['clans_picture'])) {
  $data['clans']['img'] = $cs_lang['nopic'];
}
else {
  $place = 'uploads/clans/' . $cs_clan['clans_picture'];
  $size = getimagesize($cs_main['def_path'] . '/' . $place);
  $data['clans']['img'] = cs_html_img($place,$size[1],$size[0]);
}

$data['clans']['short'] = cs_secure($cs_clan['clans_short']);

if(!empty($cs_clan['clans_country'])) {
  include_once('lang/' . $account['users_lang'] . '/countries.php');
  $data['clans']['country'] = cs_html_img('symbols/countries/' . $cs_clan['clans_country'] . '.png',11,16) . ' ' . $cs_country[$cs_clan['clans_country']];
} else {
  $data['clans']['country'] = '-';
}

if(!empty($cs_clan['clans_url'])) {
  $data['clans']['url'] = cs_html_link('http://' . $cs_clan['clans_url'],cs_secure($cs_clan['clans_url']));
}
else {
  $data['clans']['url'] = '';
}

if(!empty($cs_clan['clans_since'])) {
  $content = cs_date('date',$cs_clan['clans_since']);
  $birth = explode('-', $cs_clan['clans_since']);
  $age = cs_datereal('Y') - $birth[0];
  if(cs_datereal('m')<=$birth[1]) {
    $age--;
  }
  
  if(cs_datereal('d')>=$birth[2] AND cs_datereal('m')==$birth[1]) {
    $age++;
  }
  
  $content .= ' (' . $age . ')';
  $data['clans']['since'] = $content;
}
else {
  $data['clans']['since'] = '-';
}

$select = 'squads_name, games_id, squads_id';
$where = "clans_id = '" . $cs_clans_id . "'";  
$cs_squads = cs_sql_select(__FILE__,'squads',$select,$where,'squads_order, squads_name',0,0);
$squads_loop = count($cs_squads);

$data['lang']['game'] = $cs_lang['game'];
$data['lang']['squads'] = $cs_lang[$op_squads['label']];
$data['lang']['members'] = $cs_lang[$op_members['label']];

if(empty($squads_loop)) {
  $data['squads'] = '';
}

for($run=0; $run<$squads_loop; $run++) {
  if(!empty($cs_squads[$run]['games_id'])) {
    $data['squads'][$run]['game'] = cs_html_img('uploads/games/' . $cs_squads[$run]['games_id'] . '.gif');
  }
  else {
  $data['squads'][$run]['game'] = '';
  }
  
  $data['squads'][$run]['squads'] = cs_link(cs_secure($cs_squads[$run]['squads_name']),'squads','view','id=' . $cs_squads[$run]['squads_id']);
  $where = "squads_id='" . $cs_squads[$run]['squads_id'] . "'";  
  $data['squads'][$run]['members'] = cs_sql_count(__FILE__,'members',$where);
}

echo cs_subtemplate(__FILE__,$data,'clans','view');