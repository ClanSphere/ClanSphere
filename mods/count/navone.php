<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$where = 'count_time > \'' . (cs_time() - 300) . '\'';
echo number_format(cs_sql_count(__FILE__,'count',$where),0,',','.');