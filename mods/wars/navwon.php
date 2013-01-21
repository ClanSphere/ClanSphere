<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_get = cs_get('catid');
$where = 'wars_score1 > wars_score2 AND wars_status = \'played\'';
if(!empty($cs_get['catid'])) {
  $where .= ' AND categories_id = ' . $cs_get['catid'];
}
echo cs_sql_count(__FILE__,'wars',$where);