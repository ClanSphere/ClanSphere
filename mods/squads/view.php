<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('squads');

$data = array();
$op_squads = cs_sql_option(__FILE__,'squads');
$op_members = cs_sql_option(__FILE__,'members');

include_once 'lang/' . $account['users_lang'] . '/countries.php';

$squads_id = $_GET['id'];
settype($squads_id,'integer');

$data['lang']['mod'] = $cs_lang[$op_squads['label'].'s'];

$select = 'sqd.games_id AS games_id, sqd.squads_name AS squads_name, cln.clans_name AS ';
$select .= 'clans_name, cln.clans_tag AS clans_tag, cln.clans_tagpos AS clans_tagpos, ';
$select .= 'cln.clans_id AS clans_id, sqd.squads_picture AS squads_picture';
$from = 'squads sqd INNER JOIN {pre}_clans cln ON sqd.clans_id = cln.clans_id ';
$where = "sqd.squads_id = '" . $squads_id . "'";
$data['squad'] = cs_sql_select(__FILE__,$from,$select,$where);

$data['lang']['members'] = $cs_lang[$op_members['label']];

$clans_name = cs_secure($data['squad']['clans_name']);
$clan_link = cs_link($clans_name,'clans','view','id=' . $data['squad']['clans_id']);
$data['lang']['part_of'] = sprintf($cs_lang['body_list'], $clan_link);

$icon = 'uploads/games/' . $data['squad']['games_id'] . '.gif';
$data['game']['icon'] = !file_exists($icon) ? '' : cs_html_img($icon);

$data['squad']['squads_name'] = cs_secure($data['squad']['squads_name']);

$select = 'mem.members_admin AS members_admin, mem.members_task AS members_task, mem.members_since AS members_since, ';
$select .= 'mem.users_id AS users_id, usr.users_nick AS users_nick, usr.users_country AS users_country, ';
$select .= 'usr.users_laston AS users_laston, usr.users_invisible AS users_invisible';
$from = 'members mem INNER JOIN {pre}_users usr ON mem.users_id = usr.users_id ';
$where = "mem.squads_id='" . $squads_id . "'";
$order = 'mem.members_order ASC, usr.users_nick ASC';
$data['members'] = cs_sql_select(__FILE__,$from,$select,$where,$order,0,0,0);
$data['squad']['members'] = count($data['members']);


for($run = 0; $run < $data['squad']['members']; $run++) {
  $data['members'][$run]['countrypath'] = 'symbols/countries/' . $data['members'][$run]['users_country'] . '.png';
  $data['members'][$run]['country'] = $cs_country[$data['members'][$run]['users_country']];
  $data['members'][$run]['members_since'] = empty($data['members'][$run]['members_since']) ?
    '-' : cs_date('date',$data['members'][$run]['members_since']);
  $data['members'][$run]['page'] = cs_userstatus($data['members'][$run]['users_laston'],$data['members'][$run]['users_invisible']);

  $users_nick = empty($data['members'][$run]['members_admin']) ? cs_secure($data['members'][$run]['users_nick']) :
    cs_html_big(1) . cs_secure($data['members'][$run]['users_nick']) . cs_html_big(0);
	$nick = $data['squad']['clans_tagpos'] == 1 ? $data['squad']['clans_tag'] . ' ' . $users_nick :
    $users_nick . ' ' . $data['squad']['clans_tag'];

  $data['members'][$run]['users_nick_tag'] = $nick;
}

echo cs_subtemplate(__FILE__,$data,'squads','view');

?>
