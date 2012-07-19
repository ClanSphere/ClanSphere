<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery', 1);
$cs_post = cs_post('id');
$cs_get = cs_get('id');

$com_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $com_id = $cs_post['id'];

$cs_com = cs_sql_select(__FILE__,'comments','comments_fid',"comments_id = '" . $com_id . "'");
$fid = $cs_com['comments_fid'];
$cs_gallery = cs_sql_select(__FILE__,'usersgallery','usersgallery_close,folders_id,users_id',"usersgallery_id = '" . $fid . "'");
$more = 'cat_id=' . $cs_gallery['folders_id'] . '&amp;more=1&amp;id=' . $cs_gallery['users_id'] . '&amp;pic_id';

require_once('mods/comments/functions.php');
cs_comments_remove('usersgallery','com_view',$com_id,$cs_lang['mod_name'],$more);