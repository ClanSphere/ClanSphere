<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$where = "users_id_to = '" . $account['users_id'] . "' AND messages_show_receiver = '1' AND messages_view = '0'";
$count = cs_sql_count(__FILE__,'messages',$where);

echo $count;