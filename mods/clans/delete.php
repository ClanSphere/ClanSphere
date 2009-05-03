<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clans');

$op_clans = cs_sql_option(__FILE__,'clans');

$clans_form = 1;
$clans_id = $_REQUEST['id'];
settype($clans_id,'integer');

if(isset($_GET['agree']) AND $clans_id != 1) {
  $clans_form = 0;
  
  $where = "clans_id = '" . $clans_id . "'";
  $where .= $account['access_clansphere'] == 5 ? '' : "AND users_id = '" .  $account['users_id'] . "'"; 
  $search = cs_sql_count(__FILE__,'clans',$where);

  if(empty($search)) {
    $msg = $cs_lang['not_own'];
  }
  else {
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
      }
    }
    cs_sql_delete(__FILE__,'squads',$clans_id,'clans_id');
    cs_sql_delete(__FILE__,'clans',$clans_id);
    $msg = sprintf($cs_lang['del_true_clan'],$cs_lang[$op_clans['label']]);
  }
  
  cs_redirect($msg,'clans','center');
}

if(isset($_GET['cancel']) OR $clans_id == 1) {
  $clans_form = 0;
  
  cs_redirect($cs_lang['del_false'],'clans','center');
}

if(!empty($clans_form)) {
  $data['lang']['body'] = sprintf($cs_lang['del_rly'],$clans_id);
  
  $data['lang']['content'] = cs_link($cs_lang['confirm'],'clans','delete','id=' . $clans_id . '&amp;agree');
  $data['lang']['content'] .= ' - ';
  $data['lang']['content'] .= cs_link($cs_lang['cancel'],'clans','delete','id=' . $clans_id . '&amp;cancel');
  
  echo cs_subtemplate(__FILE__,$data,'clans','remove');
}
