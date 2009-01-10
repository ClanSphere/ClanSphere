<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cups');

$cups_id = (int) $_GET['where'];
$start = empty($_GET['start']) ? 0 : (int) $_GET['start'];

$cs_sort[1] = 'squads_name ASC';
$cs_sort[2] = 'squads_name DESC';
$cs_sort[3] = 'cupsquads_time ASC';
$cs_sort[4] = 'cupsquads_time DESC';

$sort = empty($_GET['sort']) ? 3 : (int) $_GET['sort'];
$order = $cs_sort[$sort];

$participants_count = cs_sql_count(__FILE__,'cupsquads','cups_id = \''.$cups_id.'\'');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,3);
echo $cs_lang['mod'] . ' - ' . $cs_lang['teams'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc');
echo cs_link($cs_lang['back'],'cups','manage');
echo cs_html_roco(2,'leftc');
echo cs_icon('contents') . $cs_lang['total'] . ': ' . $participants_count;
echo cs_html_roco(3,'leftc');
echo cs_pages('cups','teams',$participants_count,$start,$cups_id,$sort);
echo cs_html_roco(0);
echo cs_html_table(0);

echo cs_html_br(1);
echo cs_getmsg();
$cs_cup = cs_sql_select(__FILE__,'cups','cups_system','cups_id = \''.$cups_id.'\'');

$cells  = 'cs.cupsquads_id AS cupsquads_id, cs.cupsquads_time AS cupsquads_time, cs.squads_id AS squads_id, ';
$tables = 'cupsquads cs INNER JOIN {pre}_';

if ($cs_cup['cups_system'] == 'users') {
  $tables .= 'users usr ON cs.squads_id = usr.users_id';
  $cells  .= 'usr.users_nick AS squads_name';
  $mod     = 'users';
} else {
  $tables .= 'squads sq ON cs.squads_id = sq.squads_id';
  $cells  .= 'sq.squads_name AS squads_name';
  $mod     = 'squads';
}

$cs_cupsquads = cs_sql_select(__FILE__,$tables,$cells,'cups_id = \''.$cups_id.'\'',$order,$start,$account['users_limit']);
$count_squads = count($cs_cupsquads);
$img_del = cs_icon('editdelete');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo cs_sort('cups','teams',$start,$cups_id,1,$sort);
echo $cs_lang['name'];
echo cs_html_roco(2,'headb');
echo cs_sort('cups','teams',$start,$cups_id,3,$sort);
echo $cs_lang['join'];
echo cs_html_roco(3,'headb');
echo $cs_lang['options'];
echo cs_html_roco(0);

for ($run = 0; $run < $count_squads; $run++) {
  echo cs_html_roco(1,'leftb');
  echo cs_link($cs_cupsquads[$run]['squads_name'],$mod,'view','id='.$cs_cupsquads[$run]['squads_id']);
  echo cs_html_roco(2,'leftb');
  echo cs_date('unix',$cs_cupsquads[$run]['cupsquads_time'],1);
  echo cs_html_roco(3,'leftb');
  echo cs_link($img_del,'cups','teamremove','id='.$cs_cupsquads[$run]['cupsquads_id'],'',$cs_lang['remove']);
  echo cs_html_roco(0);
}

echo cs_html_table(0);

?>