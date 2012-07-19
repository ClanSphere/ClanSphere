<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

# Overwrite global settings by using the following array
$cs_main = array('init_sql' => true, 'init_tpl' => true, 'tpl_file' => 'admin.htm', 'def_mod' => 'clansphere', 'def_action' => 'admin');

require_once 'system/core/functions.php';

cs_init($cs_main);