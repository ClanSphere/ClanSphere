<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$tmonth = cs_datereal('n');
$tyear = cs_datereal('Y');
$monthstart = mktime(0,0,0,$tmonth,1,$tyear);
$monthstart = cs_timediff($monthstart, 1);

$where = 'count_time > \'' . $monthstart . '\'';
echo number_format(cs_sql_count(__FILE__,'count',$where),0,',','.');