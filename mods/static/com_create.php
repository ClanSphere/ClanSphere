<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('static');

$cs_post = cs_post('fid');
$cs_get = cs_get('id');

$fid = empty($cs_post['fid']) ? 0 : $cs_post['fid'];
$quote_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

$cs_static = cs_sql_select(__FILE__,'static','static_comments',"static_id = '" . $fid . "'");
$close = empty($cs_static['static_comments']) ? 1 : 0;

require_once('mods/comments/functions.php');
cs_commments_create($fid,'static','view',$quote_id,$cs_lang['mod_name'],$close);