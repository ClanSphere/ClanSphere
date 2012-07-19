<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clansphere');

require_once 'mods/clansphere/functions.php';

$head = array('mod' => 'ClanSphere', 'action' => $cs_lang['manage'], 'topline' => $cs_lang['modules_list']);
echo cs_manage('clansphere', 'admin', 'clansphere', 'manage', 0, $head);