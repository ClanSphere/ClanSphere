<?php
// ClanSphere 2008 - www.clansphere.net
// Id: com_create.php (Tue Nov 18 11:03:43 CET 2008) fAY-pA!N

$cs_lang = cs_translate('events');
$cs_post = cs_post('fid');
$cs_get = cs_get('id');

$fid = empty($cs_post['fid']) ? 0 : $cs_post['fid'];
$quote_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

$cs_events = cs_sql_select(__FILE__,'events','events_close',"events_id = '" . $fid . "'");

require_once('mods/comments/functions.php');
cs_commments_create($fid,'events','view',$quote_id,$cs_lang['mod'],$cs_events['events_close']);

?>