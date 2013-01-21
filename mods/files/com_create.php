<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('files');
$cs_post = cs_post('fid');
$cs_get = cs_get('id');

$fid = empty($cs_post['fid']) ? 0 : $cs_post['fid'];
$quote_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

$cs_files = cs_sql_select(__FILE__,'files','files_close',"files_id = '" . $fid . "'");

require_once('mods/comments/functions.php');
cs_commments_create($fid,'files','view',$quote_id,$cs_lang['mod_name'],$cs_files['files_close']);