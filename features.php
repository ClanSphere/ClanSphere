<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

# Overwrite global settings by using the following array
$cs_main = array('init_sql' => false, 'init_tpl' => true, 'tpl_file' => 'features.htm', 'def_width' => '100%');

require_once 'system/core/functions.php';

cs_init($cs_main);

?>