<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

# Overwrite global settings by using the following array
$cs_main = array('init_sql' => true, 'init_tpl' => false, 'def_mod' => 'ajax', 'def_action' => 'upload', 'xsrf_protection' => false);

require_once 'system/core/functions.php';

cs_init($cs_main);

define('UPLOAD_PROTECTED', 1);

require_once 'mods/ajax/upload.php';