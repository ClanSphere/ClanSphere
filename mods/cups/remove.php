<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cups');
$cs_get = cs_get('id');
$cs_post = cs_post('id');
$cups_id = empty($cs_get['id']) ? $cs_post['id'] : $cs_get['id'];

if(isset($_POST['submit'])) {
  cs_sql_delete(__FILE__,'cupmatches',$cups_id,'cups_id');
  cs_sql_delete(__FILE__,'cupsquads',$cups_id,'cups_id');
  cs_sql_delete(__FILE__,'cups',$cups_id);
  cs_redirect($cs_lang['del_true'], 'cups');
}

if (isset($_POST['cancel'])) {
  cs_redirect($cs_lang['canceled'], 'cups');
}

if(!isset($_POST['submit'])) {
  $cup = cs_sql_select(__FILE__,'cups','cups_name','cups_id = ' . $cups_id,0,0,1);
  if(!empty($cup)) {
    $data = array();
    $data['lang']['del_rly'] = sprintf($cs_lang['remove_entry'],$cs_lang['cup'],$cup['cups_name']);
    $data['cup']['id'] = $cups_id;
    echo cs_subtemplate(__FILE__, $data, 'cups', 'remove');
  } else {
    cs_redirec('','cups');
  }

}