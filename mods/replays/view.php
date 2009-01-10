<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('replays');

$cs_replays_id = empty($_REQUEST['where']) ? $_GET['id'] : $_REQUEST['where'];
settype($cs_replays_id,'integer');

$cs_replays = cs_sql_select(__FILE__,'replays','*',"replays_id = '" . $cs_replays_id . "'");

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['details'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo $cs_lang['body_view'];
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'leftc',0,0,'140px');
echo cs_icon('personal') . $cs_lang['user'];
echo cs_html_roco(2,'leftb');
$who = "users_id = '" . $cs_replays['users_id'] . "'";
$cs_users = cs_sql_select(__FILE__,'users','users_nick, users_active',$who);
$cs_users_nick = cs_secure($cs_users['users_nick']);
echo cs_user($cs_replays['users_id'],$cs_users['users_nick'], $cs_users['users_active']);
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('history_clear') . $cs_lang['since'];
echo cs_html_roco(2,'leftb');
echo cs_date('unix',$cs_replays['replays_since'],1);
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'leftc');
echo cs_icon('folder_yellow') . $cs_lang['category'];
echo cs_html_roco(2,'leftb');
$where = "categories_id = '" . $cs_replays['categories_id'] . "'";
$cs_cat = cs_sql_select(__FILE__,'categories','categories_name, categories_id',$where);
echo cs_link($cs_cat['categories_name'],'categories','view','id=' . $cs_cat['categories_id']);
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('package_games') . $cs_lang['game'];
echo cs_html_roco(2,'leftb');
if(!empty($cs_replays['games_id'])) {
	echo cs_html_img('uploads/games/' . $cs_replays['games_id'] . '.gif') . ' ';
	$where = "games_id = '" . $cs_replays['games_id'] . "'";
	$cs_game = cs_sql_select(__FILE__,'games','games_name, games_id',$where);
	echo cs_link($cs_game['games_name'],'games','view','id=' . $cs_game['games_id']);
}
else {
	echo ' - ';
}
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('kate') . $cs_lang['version'];
echo cs_html_roco(2,'leftb');
echo cs_secure($cs_replays['replays_version']);
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('kdmconfig') . $cs_lang['team1'];
echo cs_html_roco(2,'leftb');
echo cs_secure($cs_replays['replays_team1']);
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('yast_group_add') . $cs_lang['team2'];
echo cs_html_roco(2,'leftb');
echo cs_secure($cs_replays['replays_team2']);
echo cs_html_roco(0);	

echo cs_html_roco(1,'leftc');
echo cs_icon('1day') . $cs_lang['date'];
echo cs_html_roco(2,'leftb');
echo cs_date('date',$cs_replays['replays_date']);
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('openterm') . $cs_lang['map'];
echo cs_html_roco(2,'leftb',0,2);
echo cs_secure($cs_replays['replays_map']);
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('download') . $cs_lang['mirrors'];
echo cs_html_roco(2,'leftb');
if(empty($cs_replays['replays_mirrors'])) {
	echo ' - ';
}
else {
	$mirror = explode("\n", $cs_replays['replays_mirrors']); 
	foreach($mirror AS $load) {
		echo cs_html_link($load,$load);
		echo cs_html_br(1);
	}
}
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('documentinfo') . $cs_lang['info'];
echo cs_html_roco(2,'leftb');
echo cs_secure($cs_replays['replays_info'],1,1);
echo cs_html_roco(0);
echo cs_html_table(0);

$where_com = "comments_mod = 'replays' AND comments_fid = '" . $cs_replays['replays_id'] . "'";
$count_com = cs_sql_count(__FILE__,'comments',$where_com);
include_once('mods/comments/functions.php');

if(!empty($count_com)) {
	echo cs_html_br(1);
	echo cs_comments_view($cs_replays_id,'replays','view',$count_com);
}

echo cs_comments_add($cs_replays_id,'replays',$cs_replays['replays_close']);


?>