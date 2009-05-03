<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cups');

$cups_id = empty($_POST['cups_id']) ? $_GET['id'] : $_POST['cups_id'];
settype($cups_id,'integer');

$cs_cup = cs_sql_select(__FILE__,'cups','cups_start, cups_system, cups_teams',"cups_id = '" . $cups_id . "'");
$started = cs_sql_count(__FILE__,'cupmatches','cups_id = \''.$cups_id.'\'');
$joined = cs_sql_count(__FILE__,'cupsquads','cups_id = \''.$cups_id.'\'');

$form = 1;
$full = $joined >= $cs_cup['cups_teams'] ? 1 : 0;

if ($cs_cup['cups_system'] == 'teams' && empty($full)) {
  $membership = cs_sql_count(__FILE__,'members',"users_id = '" . $account['users_id'] . "' AND members_admin = '1'");
  
  if(!empty($membership)) {
    $tables = 'cupsquads cs INNER JOIN {pre}_members mem ON cs.squads_id = mem.squads_id';
    $where = "mem.users_id = '" . $account['users_id'] . "' AND cs.cups_id = '" . $cups_id . "'";
    $participant = cs_sql_count(__FILE__,$tables,$where);
  }
} elseif(empty($full)) {
  $membership = 1;
  $participant = cs_sql_count(__FILE__,'cupsquads','cups_id = \''.$cups_id.'\' AND squads_id = \''.$account['users_id'].'\'');
}

if($account['access_cups'] >= 2 && cs_time() < $cs_cup['cups_start'] && empty($started) && empty($full)) {
  if(!empty($participant)) {
    cs_redirect($cs_lang['join_done'], 'cups', 'view', 'id=' . $cups_id);
  }
  elseif(empty($membership)) {
    cs_redirect(cs_link($cs_lang['need_squad'],'squads','center'), 'cups', 'view', 'id=' . $cups_id);
  }
  elseif(empty($_POST['submit'])) {
    
    if ($cs_cup['cups_system'] == 'teams') {
      
      $data = array();
      
      $tables = 'members mm INNER JOIN {pre}_squads sq ON mm.squads_id = sq.squads_id';
      $cells = 'mm.squads_id AS squads_id, sq.squads_name AS squads_name';
      $where = 'mm.members_admin = \'1\' AND mm.users_id = \'' . $account['users_id'] . '\'';
      $data['squads'] = cs_sql_select(__FILE__,$tables,$cells,$where,'sq.squads_name',0,0);

      $data['cup']['id'] = $cups_id;
      
      echo cs_subtemplate(__FILE__, $data, 'cups', 'join_squad');
        
    } else {
      
      $data = array();
      $data['cup']['id'] = $cups_id;
      
      echo cs_subtemplate(__FILE__, $data, 'cups', 'join_user');
      
    }
    
  } else {
    
    $cs_cups['cupsquads_time'] = cs_time();
    
    if ($_POST['system'] == 'teams') {
      
      $cs_cups['squads_id'] = (int) $_POST['squads_id'];
      
      $cond = 'squads_id = \''.$cs_cups['squads_id'].'\' AND users_id = \''.$account['users_id'].'\' AND members_admin = \'1\'';
      $access = cs_sql_count(__FILE__,'members',$cond);
    } else {
      $access = ($account['access_cups'] >= 2) ? 1 : 0;
      $cs_cups['squads_id'] = $account['users_id'];
      
    }
  
    if(!empty($access)) {
      $cs_cups['cups_id'] = $cups_id;
      $cells = array_keys($cs_cups);
      $values = array_values($cs_cups);
      cs_sql_insert(__FILE__,'cupsquads',$cells,$values);
      $msg = $cs_lang['successfully_joined'];
    } else {
      $msg = $cs_lang['no_access'];
    }

    cs_redirect($msg,'cups','center');
  }

} else {
  $content =  empty($full) ? $cs_lang['no_access'] : $cs_lang['cup_full'];
  cs_redirect($content, 'cups', 'view', 'id=' . $cups_id);
}