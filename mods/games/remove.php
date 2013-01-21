<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('games');
$cs_get = cs_get('id,agree,cancel');

if(isset($cs_get['agree'])) {
  cs_sql_delete(__FILE__,'games',$cs_get['id']);

  if (file_exists('uploads/games/' . $cs_get['id'] . '.gif')) {
    cs_unlink('games', $cs_get['id'] . '.gif');
  }

  cs_redirect($cs_lang['del_true'], 'games');
}

if(isset($cs_get['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'games');
}

$game = cs_sql_select(__FILE__,'games','games_name','games_id = ' . $cs_get['id'],0,0,1);
if(!empty($game)) {
  $data = array();
  $data['lang']['body'] = sprintf($cs_lang['remove_entry'],$cs_lang['mod_remove'],$game['games_name']);
  $data['lang']['content'] = cs_link($cs_lang['confirm'],'games','remove','id=' . $cs_get['id'] . '&amp;agree');
  $data['lang']['content'] .= ' - ';
  $data['lang']['content'] .= cs_link($cs_lang['cancel'],'games','remove','id=' . $cs_get['id'] . '&amp;cancel');
  echo cs_subtemplate(__FILE__,$data,'games','remove');
}
else {
  cs_redirect('','games');
}