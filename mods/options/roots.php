<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('options');

$head = array('mod' => $cs_lang['options'], 'action' => $cs_lang['head_roots'], 'topline' => $cs_lang['body_roots'], 'message' => cs_getmsg());

require_once('mods/clansphere/functions.php');
echo cs_manage('options', 'roots', 'clansphere', 'options', 0, $head);