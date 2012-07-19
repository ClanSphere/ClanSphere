<?php 
// ClanSphere 2010 - www.clansphere.net
// $Id$

$counte_archiv = cs_sql_select(__FILE__,'count_archiv','count_num',0,0,0,0);
$archiv = 0;
if(!empty($counte_archiv))
{
  foreach($counte_archiv AS $value)
  {
    $archiv += $value['count_num'];
  }
}              
echo number_format(cs_sql_count(__FILE__,'count') + $archiv,0,',','.');