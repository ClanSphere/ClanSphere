<?php 
// ClanSphere 2010 - www.clansphere.net
// $Id$

$tday = cs_datereal('d');
$tmonth = cs_datereal('n');
$tyear = cs_datereal('Y');
$daystart = mktime(0,0,0,$tmonth,$tday,$tyear);
$daystart = cs_timediff($daystart, 1);

$yes_start = $daystart - 86400;
$yes_stop = $daystart - 1;

$where = 'count_time > \'' . $yes_start . '\' AND count_time < \'' . $yes_stop . '\'';
echo cs_sql_count(__FILE__,'count',$where);