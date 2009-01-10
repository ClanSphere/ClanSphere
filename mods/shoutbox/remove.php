<?php
// ClanSphere 2008 - www.clansphere.net 
// $Id$

$cs_lang = cs_translate('shoutbox');

$data = array();
$shoutbox_id = (int) $_GET['id'];

if (isset($_GET['confirm'])) {
  cs_sql_delete(__FILE__,'shoutbox',$shoutbox_id);
  cs_redirect($cs_lang['del_true'], 'shoutbox');
}
elseif (isset($_GET['cancel'])) 
  cs_redirect($cs_lang['del_false'], 'shoutbox');
else {
  $data['content']['head'] = sprintf($cs_lang['really'],$shoutbox_id);
  $data['content']['bottom']  = cs_link($cs_lang['confirm'],'shoutbox','remove','id='.$shoutbox_id.'&amp;confirm');
  $data['content']['bottom'] .= ' - ';
  $data['content']['bottom'] .= cs_link($cs_lang['cancel'],'shoutbox','remove','id='.$shoutbox_id.'&amp;cancel');
}

echo cs_subtemplate(__FILE__,$data,'shoutbox','remove');
?>