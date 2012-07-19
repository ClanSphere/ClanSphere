<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');

$data = array();

$events_id = empty($_REQUEST['where']) ? $_GET['id'] : $_REQUEST['where'];
settype($events_id,'integer');
$cs_events = cs_sql_select(__FILE__,'events','*',"events_id = '" . $events_id . "'");

$data['head']['getmsg'] = cs_getmsg();

$data['if']['topinfo'] = 0;
$data['if']['statusinfo'] = 0;

if(empty($cs_events['events_cancel']) AND !empty($cs_events['events_guestsmax']) AND cs_time() < $cs_events['events_time']) {

  $data['if']['topinfo'] = 1;
  $data['if']['statusinfo'] = 1;
  $data['head']['status'] = $cs_lang['status'] . ': ';

  if(empty($account['users_id']))
    $status = array('eventguests_id' => 0, 'eventguests_since' => 0, 'eventguests_status' => 0);
  else {
    $where = "events_id = '" . $events_id . "' AND users_id = '" . $account['users_id'] . "'";
    $status = cs_sql_select(__FILE__,'eventguests','eventguests_id, eventguests_since, eventguests_status',$where);
  }

  if(empty($status['eventguests_since']))
    $data['head']['status'] .= cs_link($cs_lang['signin'],'events','signin','id=' . $events_id);
  else {
    if($status['eventguests_status'] > 3)
      $data['if']['statusinfo'] = 0;

    $data['head']['status'] .= $cs_lang['status_' . $status['eventguests_status']] . ' -> ';
    $data['head']['status'] .= cs_link($cs_lang['signout'],'events','signout','id=' . $status['eventguests_id']);
  }
}
elseif(!empty($cs_events['events_cancel'])) {

  $data['if']['topinfo'] = 1;
  $data['head']['status'] = $cs_lang['canceled'];
}

$data['data']['events_id'] = $events_id;

$data['data']['events_name'] = cs_secure($cs_events['events_name']);

$where = "categories_id = '" . $cs_events['categories_id'] . "'";
$cs_cat = cs_sql_select(__FILE__,'categories','categories_name, categories_id',$where);
$data['data']['category'] = cs_link($cs_cat['categories_name'],'categories','view','id=' . $cs_cat['categories_id']);

$data['data']['time'] = cs_date('unix',$cs_events['events_time'],1);

$data['data']['events_venue'] = cs_secure($cs_events['events_venue']);

$data['data']['signed'] = cs_sql_count(__FILE__, 'eventguests', "events_id = '" . $events_id . "'");

$data['data']['events_guestsmin'] = !empty($cs_events['events_guestsmin']) ? $cs_events['events_guestsmin'] : '-';

$data['data']['events_guestsmax'] = !empty($cs_events['events_guestsmax']) ? $cs_events['events_guestsmax'] : '-';

$data['data']['events_needage'] = !empty($cs_events['events_needage']) ? $cs_events['events_needage'] : '-';

$events_url = cs_secure($cs_events['events_url']);
$data['data']['events_url'] = cs_html_link('http://' . $events_url,$events_url);


if(empty($cs_events['events_pictures'])) {

  $data['data']['pictures'] =  '-';
}
else {

  $data['data']['pictures'] = '';
  $events_pics = explode("\n",$cs_events['events_pictures']);

  foreach($events_pics AS $pic) {
    $link = cs_html_img('uploads/events/thumb-' . $pic);
    $path = empty($cs_main['mod_rewrite']) ? '' : $cs_main['php_self']['website'] . str_replace('index.php','',$_SERVER['PHP_SELF']);
    $data['data']['pictures'] .= cs_html_link($path . 'uploads/events/picture-' . $pic,$link) . ' ';
  }
}

$data['data']['events_more'] = cs_secure($cs_events['events_more'],1,1,1,1);

echo cs_subtemplate(__FILE__,$data,'events','view');

$where_com = "comments_mod = 'events' AND comments_fid = '" . $events_id . "'";
$count_com = cs_sql_count(__FILE__,'comments',$where_com);
include_once('mods/comments/functions.php');

if(!empty($count_com)) {
  echo cs_html_br(1);
  echo cs_comments_view($events_id,'events','view',$count_com);
}

echo cs_comments_add($events_id,'events',$cs_events['events_close']);