<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$tmonth = cs_datereal('n');
$tyear = cs_datereal('Y');
$var = mktime(0,0,0,$tmonth,1,$tyear);
$var = $var - $account['users_timezone'];
$monthstart = empty($account['users_dstime']) ?	$var : $var - 3600;

$where = 'count_time > \'' . $monthstart . '\'';
echo number_format(cs_sql_count(__FILE__,'count',$where),0,',','.');

?>