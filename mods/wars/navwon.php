<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

echo cs_sql_count(__FILE__,'wars','wars_score1 > wars_score2 AND wars_status = \'played\'');

?>