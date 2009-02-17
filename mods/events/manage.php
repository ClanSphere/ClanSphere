<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');

$categories_id = empty($_REQUEST['where']) ? 0 : $_REQUEST['where'];
settype($categories_id,'integer');
$where = empty($categories_id) ? 0 : "categories_id = '" . $categories_id . "'";

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'events_name DESC';
$cs_sort[2] = 'events_name ASC';
$cs_sort[3] = 'events_time DESC';
$cs_sort[4] = 'events_time ASC';
$sort = empty($_REQUEST['sort']) ? 3 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$events_count = cs_sql_count(__FILE__,'events',$where);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,3);
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_manage'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo cs_icon('editpaste') . cs_link($cs_lang['new_event'],'events','create');
echo cs_html_roco(2,'leftb');
echo cs_icon('contents') . $cs_lang['all'] . $events_count;
echo cs_html_roco(2,'rightb');
echo cs_pages('events','manage',$events_count,$start,$categories_id,$sort);
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb',0,3);
echo $cs_lang['category'];
echo cs_html_form(1,'events_manage','events','manage');
$eventsmod = "categories_mod = 'events'";
$categories_data = cs_sql_select(__FILE__,'categories','*',$eventsmod,'categories_name',0,0);
echo cs_dropdown('where','categories_name',$categories_data,$categories_id,'categories_id');
echo cs_html_vote('submit',$cs_lang['show'],'submit');
echo cs_html_form(0);
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

echo cs_getmsg();

$select = 'events_name, events_time, events_id';
$cs_events = cs_sql_select(__FILE__,'events',$select,$where,$order,$start,$account['users_limit']);
$events_loop = count($cs_events);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo cs_sort('events','manage',$start,$categories_id,1,$sort);
echo $cs_lang['name'];
echo cs_html_roco(2,'headb');
echo cs_sort('events','manage',$start,$categories_id,3,$sort);
echo $cs_lang['date'];
echo cs_html_roco(3,'headb',0,2);
echo $cs_lang['options'];
echo cs_html_roco(0);

for($run=0; $run<$events_loop; $run++) {

  echo cs_html_roco(1,'leftc');
  $events_view = cs_secure($cs_events[$run]['events_name']);
  echo cs_link($events_view,'events','view','id=' . $cs_events[$run]['events_id']);
  echo cs_html_roco(2,'leftc');
  echo cs_date('unix',$cs_events[$run]['events_time']);
  echo cs_html_roco(3,'leftc');
  $img_edit = cs_icon('edit',16,$cs_lang['edit']);
  echo cs_link($img_edit,'events','edit','id=' . $cs_events[$run]['events_id'],0,$cs_lang['edit']);
  echo cs_html_roco(4,'leftc');
  $img_del = cs_icon('editdelete',16,$cs_lang['remove']);
  echo cs_link($img_del,'events','remove','id=' . $cs_events[$run]['events_id'],0,$cs_lang['remove']);
  echo cs_html_roco(0);
}

echo cs_html_table(0);

?>
