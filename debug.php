<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

# Overwrite global settings by using the following array
$cs_main = array('init_sql' => true, 'init_tpl' => true, 'tpl_file' => 'debug.htm', 'debug' => true, 'themebar' => true);

require_once 'system/core/functions.php';

cs_init($cs_main);

?>