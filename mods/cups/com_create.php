<?php
// ClanSphere 2008 - www.clansphere.net
// Id: com_create.php (Tue Nov 18 10:11:09 CET 2008) fAY-pA!N

$cs_lang = cs_translate('cups');
$cs_post = cs_post('fid');
$cs_get = cs_get('id');

$fid = empty($cs_post['fid']) ? 0 : $cs_post['fid'];
$quote_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

require_once('mods/comments/functions.php');
cs_commments_create($fid,'cups','match',$quote_id,$cs_lang['mod']);

?>