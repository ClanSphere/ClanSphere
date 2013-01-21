<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clans');
$cs_get = cs_get('id,agree,cancel');
$op_clans = cs_sql_option(__FILE__,'clans');

if($cs_get['id'] == 1) {
  cs_redirect($cs_lang['del_false'], 'clans');
}

if(isset($cs_get['agree'])) {
  $where = "clans_id = '" . $cs_get['id'] . "'";
  $getpic = cs_sql_select(__FILE__,'clans','clans_picture',$where);

  if(!empty($getpic['clans_picture'])) {
    cs_unlink('clans', $getpic['clans_picture']);
  }

  $where = "clans_id = '" . $cs_get['id'] . "'";
  $cs_squads = cs_sql_select(__FILE__,'squads','squads_id',$where,0,0,0);
  if(is_array($cs_squads)) {
    foreach($cs_squads AS $key => $squads_id) {
      cs_sql_delete(__FILE__,'members',$squads_id,'squads_id');

      $where = 'squads_id = ' . $squads_id;
      $getpic = cs_sql_select(__FILE__,'squads','squads_picture, squads_name',$where);
      if(!empty($getpic['squads_picture'])) {
        cs_unlink('squads', $getpic['squads_picture']);
      }
    }
  }

  cs_sql_delete(__FILE__,'squads',$cs_get['id'],'clans_id');
  cs_sql_delete(__FILE__,'clans',$cs_get['id']);

  cs_redirect($cs_lang['del_true'], 'clans');
}

if(isset($cs_get['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'clans');
}

$clan = cs_sql_select(__FILE__,'clans','clans_name','clans_id = ' . $cs_get['id'],0,0,1);
if(!empty($clan)) {
  $data['lang']['mod_name'] = $cs_lang[$op_clans['label']];
  $data['lang']['body'] = sprintf($cs_lang['remove_entry'],$data['lang']['mod_name'],$clan['clans_name']);
  $data['lang']['content'] = cs_link($cs_lang['confirm'],'clans','remove','id=' . $cs_get['id'] . '&amp;agree');
  $data['lang']['content'] .= ' - ';
  $data['lang']['content'] .= cs_link($cs_lang['cancel'],'clans','remove','id=' . $cs_get['id'] . '&amp;cancel');
  echo cs_subtemplate(__FILE__,$data,'clans','remove');
}
else {
  cs_redirect('','clans');
}
