<?php
// ClanSphere 2010 - www.clansphere.net
// Id: com_create.php (Tue Nov 18 10:24:58 CET 2008) fAY-pA!N

$cs_lang = cs_translate('gallery');
$cs_post = cs_post('fid');
$cs_get = cs_get('id');

$fid = empty($cs_post['fid']) ? 0 : $cs_post['fid'];
$quote_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

$gallery = cs_sql_select(__FILE__,'gallery','gallery_close',"gallery_id = '" . $fid . "'");

require_once('mods/comments/functions.php');
cs_commments_create($fid,'gallery','com_view',$quote_id,$cs_lang['mod_name'],$gallery['gallery_close'],'where');