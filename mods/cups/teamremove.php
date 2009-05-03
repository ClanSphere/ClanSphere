<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cups');
$data = array();

$teams_id = (int) $_GET['id'];

if (isset($_GET['cancel'])) {
  $cs_team = cs_sql_select(__FILE__,'cupsquads','cups_id','cupsquads_id = \''.$teams_id.'\'');

  cs_redirect($cs_lang['del_false'],'cups','teams','where='.$cs_team['cups_id']);
} elseif (isset($_GET['confirm'])) {
  $cs_team = cs_sql_select(__FILE__,'cupsquads','cups_id, squads_id','cupsquads_id = \''.$teams_id.'\'');
  cs_sql_delete(__FILE__,'cupsquads',$teams_id);
  $cs_cup = cs_sql_select(__FILE__,'cups','cups_system, cups_name','cups_id = \''.$cs_team['cups_id'].'\'');
  $messages_cells = array('users_id','messages_time','messages_subject','messages_text',
        'users_id_to','messages_show_receiver');
  $messages_text = sprintf($cs_lang['team_removed_mail'],$cs_cup['cups_name']);
  if ($cs_cup['cups_system'] == 'users') {
    $messages_values = array($account['users_id'],cs_time(),$cs_lang['team_removed'],$messages_text,
      $cs_team['squads_id'],'1');
    cs_sql_insert(__FILE__,'messages',$messages_cells,$messages_values);
  } else {
    $cs_members = cs_sql_select(__FILE__,'members','users_id','squads_id = \''.$teams_id.'\'',0,0,0);
    $count_members = count($cs_members);
    for ($run = 0; $run < $count_members; $run++) {
      $messages_values = array($account['users_id'],cs_time(),$cs_lang['team_removed'],$messages_text,
        $cs_members[$run]['users_id'],'1');
      cs_sql_insert(__FILE__,'messages',$messages_cells,$messages_values);
    }
  }

  cs_redirect($cs_lang['del_true'] . '. ' . $cs_lang['sent_message'],'cups','teams','where='.$cs_team['cups_id']);
  
} else {
  $data['head']['topline']  = $cs_lang['rly_remove_participant'];
  $data['cups']['content']  = cs_link($cs_lang['confirm'],'cups','teamremove','id='.$teams_id.'&amp;confirm');
  $data['cups']['content'] .= ' - ';
  $data['cups']['content'] .= cs_link($cs_lang['cancel'],'cups','teamremove','id='.$teams_id.'&amp;cancel');
}

echo cs_subtemplate(__FILE__,$data,'cups','teamremove');