<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clans');

$op_clans = cs_sql_option(__FILE__,'clans');

$clans_form = 1;
$cs_get = cs_get('id');
$cs_post = cs_post('id');
$clans_id = empty($cs_get['id']) ? $cs_post['id'] : $cs_get['id'];

if(isset($_GET['agree']) AND $clans_id != 1) {
  $clans_form = 0;

  $where = "clans_id = '" . $clans_id . "'";
  $getpic = cs_sql_select(__FILE__,'clans','clans_picture',$where);

  if(!empty($getpic['clans_picture'])) {
    cs_unlink('clans', $getpic['clans_picture']);
  }

  $where = "clans_id = '" . $clans_id . "'";
  $cs_squads = cs_sql_select(__FILE__,'squads','squads_id',$where,0,0,0);

  if(is_array($cs_squads)) {
    foreach($cs_squads AS $key => $squads_id) {
      cs_sql_delete(__FILE__,'members',$squads_id,'squads_id');

      $where = 'squads_id = ' . $squads_id;
      $getpic = cs_sql_select(__FILE__,'squads','squads_picture, squads_name',$where);
      if(!empty($getpic['squads_picture'])) {
        cs_unlink('squads', $getpic['squads_picture']);
      }
      $where = 'squads_id = ' . $squads_id;
      cs_sql_update(__FILE__, 'cupsquads', array('squads_name'), array($getpic['squads_name']), 0, $where);
    }
  }

  cs_sql_delete(__FILE__,'squads',$clans_id,'clans_id');
  cs_sql_delete(__FILE__,'clans',$clans_id);

  cs_redirect($cs_lang['del_true'], 'clans');
}

if(isset($_GET['cancel']) OR $clans_id == 1)
cs_redirect($cs_lang['del_false'], 'clans');

if(!empty($clans_form)) {
  $clan = cs_sql_select(__FILE__,'clans','clans_name','clans_id = ' . $clans_id,0,0,1);
  if(!empty($clan)) {
    $data['lang']['mod_name'] = $cs_lang[$op_clans['label']];
    $data['lang']['body'] = sprintf($cs_lang['remove_entry'],$data['lang']['mod_name'],$clan['clans_name']);
    $data['lang']['content'] = cs_link($cs_lang['confirm'],'clans','remove','id=' . $clans_id . '&amp;agree');
    $data['lang']['content'] .= ' - ';
    $data['lang']['content'] .= cs_link($cs_lang['cancel'],'clans','remove','id=' . $clans_id . '&amp;cancel');
    echo cs_subtemplate(__FILE__,$data,'clans','remove');
  }
  else {
    cs_redirect('','clans');
  }
}