<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$month = cs_sql_select(__FILE__, 'count_archiv', 'SUM(count_num) AS count', 'count_mode = 1', 0, 0, 0);
$count_month = $month[0]['count'];

$count = cs_sql_count(__FILE__,'count') + $count_month;

echo number_format($count,0,',','.');