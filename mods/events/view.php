<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');

$events_id = empty($_REQUEST['where']) ? $_GET['id'] : $_REQUEST['where'];
settype($events_id,'integer');
$cs_events = cs_sql_select(__FILE__,'events','*',"events_id = '" . $events_id . "'");

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_view'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo $cs_lang['body_view'];
echo cs_html_roco(0);
echo cs_html_roco(1,'centerc');
echo $cs_lang['signed'] . ': ';
$where = "events_id = '" . $events_id . "' AND users_id = '" . $account['users_id'] . "'";
$status = cs_sql_select(__FILE__,'eventguests','eventguests_id, eventguests_since',$where);

if(empty($status['eventguests_since'])) {
  echo $cs_lang['no'] . ' -> ';
  echo cs_link($cs_lang['signin'],'events','signin','id=' . $events_id);
}
else {
  echo $cs_lang['yes'] . ' -> ';
  echo cs_link($cs_lang['signout'],'events','signout','id=' . $events_id);
}

echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

if(!empty($cs_events['events_cancel'])) {

  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'centerc');
  echo $cs_lang['canceled'];
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_br(1);
}

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'leftc');
echo cs_icon('cal') . $cs_lang['name'];
echo cs_html_roco(2,'leftb');
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
echo cs_icon('starthere') . $cs_lang['venue'];
echo cs_html_roco(2,'leftb');
echo cs_secure($cs_events['events_venue']);
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('kdmconfig') . $cs_lang['guests'];
echo cs_html_roco(2,'leftb');
echo $cs_lang['min'] . ': ';
echo !empty($cs_events['events_guestsmin']) ? $cs_events['events_guestsmin'] : '-';
echo cs_html_br(1);
echo $cs_lang['max'] . ': ';
echo !empty($cs_events['events_guestsmax']) ? $cs_events['events_guestsmax'] : '-';
echo cs_html_br(1);
echo $cs_lang['needage'] . ': ';
echo !empty($cs_events['events_needage']) ? $cs_events['events_needage'] : '-';
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('gohome') . $cs_lang['url'];
echo cs_html_roco(2,'leftb');
$events_url = cs_secure($cs_events['events_url']);
echo cs_html_link('http://' . $events_url,$events_url);
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('images') . $cs_lang['pictures'];
echo cs_html_roco(2,'leftb');

if(empty($cs_events['events_pictures'])) {
    echo '-';
  } else {
    $events_pics = explode("\n",$cs_events['events_pictures']);
    foreach($events_pics AS $pic) {
      $link = cs_html_img('uploads/events/thumb-' . $pic);
      $path = empty($cs_main['mod_rewrite']) ? '' : 'http://' . $_SERVER['HTTP_HOST'] . str_replace('index.php','',$_SERVER['PHP_SELF']);
      echo cs_html_link($path . 'uploads/events/picture-' . $pic,$link) . ' ';
    }
}

echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('kate') . $cs_lang['more'];
echo cs_html_roco(2,'leftb');
echo cs_secure($cs_events['events_more'],1,1,1,1);
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

$where_com = "comments_mod = 'events' AND comments_fid = '" . $events_id . "'";
$count_com = cs_sql_count(__FILE__,'comments',$where_com);
include_once('mods/comments/functions.php');

if(!empty($count_com)) {
  echo cs_html_br(1);
  echo cs_comments_view($events_id,'events','view',$count_com);
}

echo cs_comments_add($events_id,'events',$cs_events['events_close']);

?>