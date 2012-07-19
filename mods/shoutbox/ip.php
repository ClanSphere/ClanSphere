<?php
// ClanSphere 2010 - www.clansphere.net 
// $Id$

$cs_lang = cs_translate('shoutbox');
$data = array();

$shoutbox_id = (int) $_GET['id'];

$cells = 'shoutbox_name, shoutbox_ip';
$cs_shoutbox = cs_sql_select(__FILE__,'shoutbox',$cells, 'shoutbox_id = \''.$shoutbox_id.'\'');

$data['text']['ip'] = sprintf($cs_lang['ip_is'],$cs_shoutbox['shoutbox_name'],$cs_shoutbox['shoutbox_ip']);
$data['url']['continue'] = cs_url('shoutbox','manage');

echo cs_subtemplate(__FILE__,$data,'shoutbox','ip');