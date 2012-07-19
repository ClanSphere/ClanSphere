<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery', 1);
$cs_post = cs_post('fid');
$cs_get = cs_get('id');

$fid = empty($cs_post['fid']) ? 0 : $cs_post['fid'];
$quote_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

$cs_gallery = cs_sql_select(__FILE__,'usersgallery','usersgallery_close,folders_id,users_id',"usersgallery_id = '" . $fid . "'");
$more = 'cat_id=' . $cs_gallery['folders_id'] . '&amp;more=1&amp;id=' . $cs_gallery['users_id'] . '&amp;pic_id';

require_once('mods/comments/functions.php');
cs_commments_create($fid,'usersgallery','com_view',$quote_id,$cs_lang['mod_name'],$cs_gallery['usersgallery_close'],$more);