<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('replays');
$cs_get = cs_get('id');

if(isset($cs_get['agree'])) {
  $replays = cs_sql_select(__FILE__,'replays','replays_mirror_urls',"replays_id = '" . $cs_get['id'] . "'");
  $replays_string = $replays['replays_mirror_urls'];
  $replays_pics = empty($replays_string) ? array() : explode("\n",$replays_string);
  foreach($replays_pics AS $pics) {
    cs_unlink('replays',$pics);
  }

  cs_sql_delete(__FILE__,'replays',$cs_get['id']);
  cs_redirect($cs_lang['del_true'], 'replays');
}
if(isset($cs_get['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'replays');
}

$replay = cs_sql_select(__FILE__,'replays','replays_id','replays_id = ' . $cs_get['id'],0,0,1);
if(!empty($replay)) {
  $data = array();
  $data['head']['topline'] = sprintf($cs_lang['del_rly'],$cs_get['id']);
  $data['replays']['content'] = cs_link($cs_lang['confirm'],'replays','remove','id=' . $cs_get['id'] . '&amp;agree');
  $data['replays']['content'] .= ' - ';
  $data['replays']['content'] .= cs_link($cs_lang['cancel'],'replays','remove','id=' . $cs_get['id'] . '&amp;cancel');
  echo cs_subtemplate(__FILE__,$data,'replays','remove');
}
else {
  cs_redirect('','replays');
}
