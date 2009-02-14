<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_view'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo $cs_lang['body_view'];
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

$events_id = empty($_REQUEST['where']) ? $_GET['id'] : $_REQUEST['where'];
settype($events_id,'integer');
$cs_events = cs_sql_select(__FILE__,'events','*',"events_id = '" . $events_id . "'");

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'leftc');
echo cs_icon('cal') . $cs_lang['name'];
echo cs_html_roco(2,'leftb',0,2);
echo cs_secure($cs_events['events_name']);
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('folder_yellow') . $cs_lang['category'];
echo cs_html_roco(2,'leftb');
$where = "categories_id = '" . $cs_events['categories_id'] . "'";
$cs_cat = cs_sql_select(__FILE__,'categories','categories_name, categories_id',$where);
echo cs_link($cs_cat['categories_name'],'categories','view','id=' . $cs_cat['categories_id']);
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('1day') . $cs_lang['date'];
echo cs_html_roco(2,'leftb');
echo cs_date('unix',$cs_events['events_time'],1);
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('gohome') . $cs_lang['url'];
echo cs_html_roco(2,'leftb',0,2);
$events_url = cs_secure($cs_events['events_url']);
echo cs_html_link('http://' . $events_url,$events_url);
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('kate') . $cs_lang['more'];
echo cs_html_roco(2,'leftb');
echo cs_secure($cs_events['events_more'],1,1,1,1);
echo cs_html_roco(0);
echo cs_html_table(0);

$where_com = "comments_mod = 'events' AND comments_fid = '" . $events_id . "'";
$count_com = cs_sql_count(__FILE__,'comments',$where_com);
include_once('mods/comments/functions.php');

if(!empty($count_com)) {
	echo cs_html_br(1);
	echo cs_comments_view($events_id,'events','view',$count_com);
}

echo cs_comments_add($events_id,'events',$cs_events['events_close']);

?>