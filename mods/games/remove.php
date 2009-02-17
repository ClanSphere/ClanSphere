<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('games');

$games_form = 1;
$games_id = $_REQUEST['id'];

if(isset($_GET['agree'])) {
  $games_form = 0;
  cs_sql_delete(__FILE__,'games',$games_id);
  
  cs_unlink('games', $games_id . '.gif');
  
    cs_redirect($cs_lang['del_true'], 'games');
}

if(isset($_GET['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'games');
}

if(!empty($games_form)) {
 
  $data['lang']['body'] = sprintf($cs_lang['del_rly'],$games_id);
  
  $data['lang']['content'] = cs_link($cs_lang['confirm'],'games','remove','id=' . $games_id . '&amp;agree');
  $data['lang']['content'] .= ' - ';
  $data['lang']['content'] .= cs_link($cs_lang['cancel'],'games','remove','id=' . $games_id . '&amp;cancel');
  
  echo cs_subtemplate(__FILE__,$data,'games','remove');
}
?>
