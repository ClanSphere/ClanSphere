<?php
// ClanSphere 2009 - www.clansphere.net
// Id: com_create.php (Tue Nov 18 10:59:37 CET 2008) fAY-pA!N

$cs_lang = cs_translate('votes');
$cs_post = cs_post('fid');
$cs_get = cs_get('id');

$fid = empty($cs_post['fid']) ? 0 : $cs_post['fid'];
$quote_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

$cs_votes = cs_sql_select(__FILE__,'votes','votes_close',"votes_id = '" . $fid . "'");

require_once('mods/comments/functions.php');
cs_commments_create($fid,'votes','view',$quote_id,$cs_lang['mod_name'],$cs_votes['votes_close']);