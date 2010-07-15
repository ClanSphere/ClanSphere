<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

# Overwrite global settings by using the following array
$cs_main = array('init_sql' => true, 'init_tpl' => true, 'tpl_file' => 'features.htm', 'def_width' => '100%', 'def_mod' => 'abcode', 'def_action' => 'listimg', 'ajax' => 0);

require_once 'system/core/functions.php';

cs_init($cs_main);