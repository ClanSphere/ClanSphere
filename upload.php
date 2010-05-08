<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

# Overwrite global settings by using the following array
$cs_main = array('init_sql' => true, 'init_tpl' => false, 'def_mod' => 'ajax', 'def_action' => 'upload');

require_once 'system/core/functions.php';

cs_init($cs_main);

$protect = 1;

require_once 'mods/ajax/upload.php';