<?php
// ClanSphere 2009 - www.clansphere.net
// Id: com_create.php (Tue Nov 18 10:50:34 CET 2008) fAY-pA!N

$cs_lang = cs_translate('gallery, 1');
$cs_post = cs_post('fid');
$cs_get = cs_get('id');

$fid = empty($cs_post['fid']) ? 0 : $cs_post['fid'];
$quote_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

$cs_gallery = cs_sql_select(__FILE__,'usersgallery','usersgallery_close,folders_id,users_id',"usersgallery_id = '" . $fid . "'");
$more = 'cat_id=' . $gallery['folders_id'] . '&amp;start=' . $start . '&more=1&id='. $gallery['users_id'] . '#com' . ++$count_com;

require_once('mods/comments/functions.php');
cs_commments_create($fid,'usersgallery','com_view',$quote_id,$cs_lang['mod_name'],$gallery['usersgallery_close'],$more);

?>