<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');
$cs_post = cs_post('fid');
$cs_get = cs_get('id');

$fid = empty($cs_post['fid']) ? 0 : $cs_post['fid'];
$quote_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

$gallery = cs_sql_select(__FILE__,'gallery','folders_id',"gallery_id = '" . $fid . "'");
$where = "folders_mod = 'gallery' AND folders_id = '" . $gallery['folders_id'] . "'";
$cs_folders = cs_sql_select(__FILE__,'folders','folders_advanced',$where);

$advanced = empty($cs_folders['folders_advanced']) ? '0,0,0,0' : $cs_folders['folders_advanced'];
$advanced = explode(",",$advanced);

require_once('mods/comments/functions.php');
cs_commments_create($fid,'gallery','com_view',$quote_id,$cs_lang['mod_name'],$advanced[1],'where');