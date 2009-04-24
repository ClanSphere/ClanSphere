<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$tmonth = cs_datereal('n');
$tyear = cs_datereal('Y');
$monthstart = mktime(0,0,0,$tmonth,1,$tyear);
$monthstart = cs_timediff($monthstart, 1);

$where = 'count_time > \'' . $monthstart . '\'';
$count = cs_sql_count(__FILE__,'count',$where) + cs_sql_count(__FILE__, 'count_archive', 'count_mode = "1"');
echo number_format($count,0,',','.');