<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('shoutbox');
$cs_get = cs_get('id');

if(isset($cs_get['confirm'])) {
  cs_sql_delete(__FILE__,'shoutbox',$cs_get['id']);
  cs_redirect($cs_lang['del_true'], 'shoutbox');
}

if(isset($cs_get['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'shoutbox');
}

$shoutbox = cs_sql_select(__FILE__,'shoutbox','shoutbox_name','shoutbox_id = ' . $cs_get['id'],0,0,1);
if(!empty($shoutbox)) {
  $data = array();
  $data['content']['head'] = sprintf($cs_lang['remove_entry'],$cs_lang['mod_name'],$shoutbox['shoutbox_name']);
  $data['content']['bottom']  = cs_link($cs_lang['confirm'],'shoutbox','remove','id='.$cs_get['id'].'&amp;confirm');
  $data['content']['bottom'] .= ' - ';
  $data['content']['bottom'] .= cs_link($cs_lang['cancel'],'shoutbox','remove','id='.$cs_get['id'].'&amp;cancel');
  echo cs_subtemplate(__FILE__,$data,'shoutbox','remove');
}
else {
  cs_redirect('','shoutbox');
}