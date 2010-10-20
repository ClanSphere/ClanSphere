<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('games');
$form = 1;
$cs_get = cs_get('id');
$games_id = $cs_get['id'];

if(isset($_GET['agree'])) {
  $form = 0;
  cs_sql_delete(__FILE__,'games',$games_id);

  if (file_exists('uploads/games/' . $games_id . '.gif'))
  cs_unlink('games', $games_id . '.gif');

  cs_redirect($cs_lang['del_true'], 'games');
}

if(isset($_GET['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'games');
}

if(!empty($form)) {
  $game = cs_sql_select(__FILE__,'games','games_name','games_id = ' . $games_id,0,0,1);
  if(!empty($game)) {
    $data['lang']['body'] = sprintf($cs_lang['remove_entry'],$cs_lang['mod_remove'],$game['games_name']);
    $data['lang']['content'] = cs_link($cs_lang['confirm'],'games','remove','id=' . $games_id . '&amp;agree');
    $data['lang']['content'] .= ' - ';
    $data['lang']['content'] .= cs_link($cs_lang['cancel'],'games','remove','id=' . $games_id . '&amp;cancel');
    echo cs_subtemplate(__FILE__,$data,'games','remove');
  }
  else {
    cs_redirect('','games');
  }
}
