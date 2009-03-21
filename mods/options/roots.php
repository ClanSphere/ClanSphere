<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('options');

$msg = cs_getmsg();
if (!empty($msg)) echo $msg;

$head = array('mod' => $cs_lang['options'], 'action' => $cs_lang['head_roots'], 'topline' => $cs_lang['body_roots']);

require_once('mods/clansphere/functions.php');
echo cs_manage('options', 'roots', 'clansphere', 'options', 0, $head);

?>