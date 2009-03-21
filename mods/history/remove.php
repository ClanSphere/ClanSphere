<?php
// ClanSphere 2009 - www.clansphere.net 
// $Id$

$cs_lang = cs_translate('history');

$history_id = $_GET['id'];

if(isset($_GET['agree'])) {
  cs_sql_delete(__FILE__,'history',$history_id);
  cs_redirect($cs_lang['del_true'], 'history');
}
elseif(isset($_GET['cancel'])) 
  cs_redirect($cs_lang['del_false'], 'history');
else {

  $data['head']['topline'] = sprintf($cs_lang['del_rly'],$history_id);
  $data['history']['content'] = cs_link($cs_lang['confirm'],'history','remove','id=' . $history_id . '&amp;agree');
  $data['history']['content'] .= ' - ';
  $data['history']['content'] .= cs_link($cs_lang['cancel'],'history','remove','id=' . $history_id . '&amp;cancel');
}

echo cs_subtemplate(__FILE__,$data,'history','remove');

?>
