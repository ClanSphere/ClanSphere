<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_datacontrol($data_id, $div = 0, $style = '',$more = '') {

  global $cs_main, $cs_lang, $account;
  $content = '';
  $mod = $cs_main['mod'];
  $get_axx = 'mods/' . $mod . '/access.php';
  $axx_file = array();

  include($get_axx);

  if(!empty($div)) {
  $content .= '<div style="' . $style . '" ' . $more . '>';
  }
  if($account['access_' .$mod] >= $axx_file['edit']) {
    $img_edit = cs_icon('edit',16,$cs_lang['edit']);
    $content  .= cs_link($img_edit,$mod,'edit','id=' .$data_id,0,$cs_lang['edit']);
  }
  if($account['access_' .$mod] >= $axx_file['remove']) {
    $img_del = cs_icon('editdelete',16,$cs_lang['remove']);
    $content .= cs_link($img_del,$mod,'remove','id=' .$data_id,0,$cs_lang['remove']);
  }
  if(!empty($div)) {
        $content .= '</div>';
  }
  return $content;
}