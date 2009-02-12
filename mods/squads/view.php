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
$select .= 'cln.clans_id AS clans_id, sqd.squads_picture AS squads_picture, sqd.squads_text AS squads_text ';
$from = 'squads sqd INNER JOIN {pre}_clans cln ON sqd.clans_id = cln.clans_id ';
$where = "sqd.squads_id = '" . $squads_id . "'";
$data['squad'] = cs_sql_select(__FILE__,$from,$select,$where);

$data['lang']['members'] = $cs_lang[$op_members['label']];

$clans_name = cs_secure($data['squad']['clans_name']);
$clan_link = cs_link($clans_name,'clans','view','id=' . $data['squad']['clans_id']);
$data['lang']['part_of'] = sprintf($cs_lang['body_list'], $clan_link);

$icon = 'uploads/games/' . $data['squad']['games_id'] . '.gif';
$data['game']['icon'] = !file_exists($icon) ? '' : cs_html_img($icon);

if(!empty($data['squad']['games_id'])) {  		
	  $where = "games_id = '" . $data['squad']['games_id'] . "'";
    $cs_game = cs_sql_select(__FILE__,'games','games_name, games_id',$where);
    $id_game = 'id=' . $cs_game['games_id'];
    $data['squad']['game'] = ' ' . cs_link($cs_game['games_name'],'games','view',$id_game);
  }
  else {
  $data['squad']['game'] = ' - ';
  }

$data['squad']['squads_name'] = cs_secure($data['squad']['squads_name']);

$data['squad']['squads_text'] = cs_secure($data['squad']['squads_text'],1,1);

if(empty($data['squad']['squads_picture'])) {
    $data['squad']['squads_pic'] = $cs_lang['nopic'];
  }
  else {
    $place = 'uploads/squads/' . $data['squad']['squads_picture'];
    $size = getimagesize($cs_main['def_path'] . '/' . $place);
  	$data['squad']['squads_pic'] = cs_html_img($place,$size[1],$size[0]);
  }

$select = 'mem.members_admin AS members_admin, mem.members_task AS members_task, mem.members_since AS members_since, ';
$select .= 'mem.users_id AS users_id, usr.users_nick AS users_nick, usr.users_country AS users_country, ';
$select .= 'usr.users_name AS users_name, usr.users_surname AS users_surname, usr.users_sex AS users_sex, ';
$select .= 'usr.users_picture AS users_picture, usr.users_active AS users_active, usr.users_hidden AS users_hidden, ';
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

$cells = 'ranks_id, ranks_name, ranks_url, ranks_img, ranks_code';
$data['ranks'] = cs_sql_select(__FILE__,'ranks',$cells, "squads_id = '" . $squads_id . "'", 'ranks_name', 0, 5);
$ranks_loop = count($data['ranks']);

for($run=0; $run<$ranks_loop; $run++) {

 	$data['ranks'][$run]['name'] = cs_secure($data['ranks'][$run]['ranks_name']);

	$data['ranks'][$run]['picture'] = '';
	if(!empty($data['ranks'][$run]['ranks_url']) AND ($data['ranks'][$run]['ranks_img'] != 'http://')) {
		$picture = cs_html_img($data['ranks'][$run]['ranks_img']);
		$data['ranks'][$run]['picture'] = cs_html_link('http://' . $data['ranks'][$run]['ranks_url'],$picture);
	}
	else {
		$data['ranks'][$run]['picture'] = $data['ranks'][$run]['ranks_code'];
	}
}

$data['awards'] = array();

$from = 'awards aws INNER JOIN {pre}_games gms ON aws.games_id = gms.games_id';
$select = 'aws.awards_id AS awards_id, aws.awards_time AS awards_time, aws.awards_event AS awards_event, aws.awards_event_url AS awards_event_url, aws.awards_rank AS awards_rank';

$data['awards'] = cs_sql_select(__FILE__,$from,$select,"squads_id = '" . $squads_id . "'",'awards_time',0,5);
$awards_loop = count($data['awards']);

$medals = array(1 => 'gold', 2 => 'silber', 3 => 'bronze');


for($run=0; $run < $awards_loop; $run++) {

	$data['awards'][$run]['awards_id'] = $data['awards'][$run]['awards_id'];
	$data['awards'][$run]['awards_time'] = cs_date('date',$data['awards'][$run]['awards_time']);
	$data['awards'][$run]['awards_event'] = cs_secure($data['awards'][$run]['awards_event']);
	$data['awards'][$run]['awards_event_url'] = $data['awards'][$run]['awards_event_url'];	
	$data['awards'][$run]['awards_place'] = $data['awards'][$run]['awards_rank'] < 4 ? cs_html_img("symbols/awards/pokal_" . $medals[$data['awards'][$run]['awards_rank']] . ".png" : cs_secure($data['awards'][$run]['awards_rank']);
	
}/*
$data['awards'] = $cs_awards;*/

$data['wars'] = array();

$select = 'war.games_id AS games_id, war.wars_date AS wars_date, war.clans_id AS clans_id, cln.clans_short AS clans_short, cat.categories_name AS categories_name, war.categories_id AS categories_id, war.wars_score1 AS wars_score1, war.wars_score2 AS wars_score2, war.wars_id AS wars_id';
$from = 'wars war INNER JOIN {pre}_categories cat ON war.categories_id = cat.categories_id ';
$from .= 'INNER JOIN {pre}_clans cln ON war.clans_id = cln.clans_id ';
$cs_wars = cs_sql_select(__FILE__,$from,$select,"squads_id = '" . $squads_id . "'",'wars_date',0,5);

$data['wars'] = '';
$count_wars = count($cs_wars);

for ($run = 0; $run < $count_wars; $run++) {
  $data['wars'][$run]['gameicon'] = cs_html_img('uploads/games/' . $cs_wars[$run]['games_id'] . '.gif');
  $data['wars'][$run]['date'] = cs_date('unix',$cs_wars[$run]['wars_date']);
  $data['wars'][$run]['enemyurl'] = cs_url('clans','view','id=' . $cs_wars[$run]['clans_id']);
  $data['wars'][$run]['enemy'] = cs_secure($cs_wars[$run]['clans_short']);
  $data['wars'][$run]['caturl'] = cs_url('categories','view','id=' . $cs_wars[$run]['categories_id']);
  $data['wars'][$run]['category'] = cs_secure($cs_wars[$run]['categories_name']);
  $data['wars'][$run]['url'] = cs_url('wars','view','id=' . $cs_wars[$run]['wars_id']);
  $data['wars'][$run]['result'] = $cs_wars[$run]['wars_score1'] . ' : ' . $cs_wars[$run]['wars_score2'];
  $result = $cs_wars[$run]['wars_score1'] - $cs_wars[$run]['wars_score2'];
  $icon = $result >= 1 ? 'green' : 'red';
  $icon = !empty($result) ? $icon : 'grey';
  $data['wars'][$run]['resulticon'] = cs_html_img('symbols/clansphere/' . $icon . '.gif');

}

echo cs_subtemplate(__FILE__,$data,'squads','view');

?>
