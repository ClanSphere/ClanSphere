<?php 
// ClanSphere 2008 - www.clansphere.net
// $Id$

$tday = cs_datereal('d');
$tmonth = cs_datereal('n');
$tyear = cs_datereal('Y');
$var = mktime(0,0,0,$tmonth,$tday,$tyear);
$var = $var - $account['users_timezone'];
$daystart = empty($account['users_dstime']) ?	$var : $var - 3600;

$yes_start = $daystart - 86400;
$yes_stop = $daystart - 1;

$where = 'count_time > \'' . $yes_start . '\' AND count_time < \'' . $yes_stop . '\'';
echo cs_sql_count(__FILE__,'count',$where);

?>