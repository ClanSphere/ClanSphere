<?php
// ClanSphere 2009 - www.clansphere.net
// Id: com_remove.php (Tue Nov 18 10:13:32 CET 2008) fAY-pA!N

$cs_lang = cs_translate('cups');
$cs_post = cs_post('id');
$cs_get = cs_get('id');

$com_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $com_id = $cs_post['id'];

require_once('mods/comments/functions.php');
cs_comments_remove('cups','match',$com_id,$cs_lang['mod']);

?>
