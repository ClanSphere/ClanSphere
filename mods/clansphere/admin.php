<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$
$cs_lang = cs_translate('clansphere');

require_once 'mods/clansphere/functions.php';

$head = array('mod' => 'ClanSphere', 'action' => $cs_lang['manage'], 'topline' => $cs_lang['modules_list']);

if($account['access_clansphere'] == 5) {
  $id = empty($_GET['sec_news']) ? 0 : (int) $_GET['sec_news'];
  echo cs_cspnews($id);
}

echo cs_manage('clansphere', 'admin', 'clansphere', 'manage', 0, $head);
?>