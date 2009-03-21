<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('awards');

$awards_id = $_GET['id'];
$data['head']['mod'] = $cs_lang['mod'];
$data['head']['action'] = $cs_lang['remove'];

if(isset($_GET['agree'])) {

  cs_sql_delete(__FILE__,'awards',$awards_id);

  cs_redirect($cs_lang['del_true'], 'awards');
}
elseif(isset($_GET['cancel'])) 
  cs_redirect($cs_lang['del_false'], 'awards');
else {

  $data['head']['topline'] = sprintf($cs_lang['remove_rly'],$awards_id);
  $data['awards']['content'] = cs_link($cs_lang['confirm'],'awards','remove','id=' . $awards_id . '&amp;agree');
  $data['awards']['content'] .= ' - ';
  $data['awards']['content'] .= cs_link($cs_lang['cancel'],'awards','remove','id=' . $awards_id . '&amp;cancel');
}

echo cs_subtemplate(__FILE__,$data,'awards','remove');

?>