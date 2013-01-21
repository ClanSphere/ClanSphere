<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('wars');
$cs_post = cs_post('id');
$cs_get = cs_get('id');
$data = array();

$rounds_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $rounds_id = $cs_post['id'];

$select = 'wars_id, maps_id, rounds_score1, rounds_score2, rounds_description';
$cs_rounds = cs_sql_select(__FILE__,'rounds',$select,"rounds_id = '" . $rounds_id . "'");

$new_map = '';

if(isset($_POST['submit'])) {

  $new_map = $_POST['new_map'];
  $cs_rounds['rounds_score1'] = (int) $_POST['rounds_score1'];
  $cs_rounds['rounds_score2'] = (int) $_POST['rounds_score2'];
  $cs_rounds['rounds_description'] = $_POST['rounds_description'];
  
  if(empty($_POST['maps_id']) AND empty($_POST['new_map']))
    $error .= $cs_lang['no_map'] . cs_html_br(1);

}

if(!isset($_POST['submit']))
  $data['head']['body'] = $cs_lang['edit_round'];
elseif(!empty($error))
  $data['head']['body'] = $error;

if(!empty($error) OR !isset($_POST['submit'])) {
  
  $data['rounds'] = $cs_rounds;
  
  $cs_wars = cs_sql_select(__FILE__,'wars','games_id',"wars_id = '".$cs_rounds['wars_id']."'");
  $cs_maps = cs_sql_select(__FILE__,'maps','maps_name, maps_id',"games_id = '".$cs_wars['games_id']."'",'maps_name',0,0);
  $i = 0;
  if(!empty($cs_maps)) {
    foreach ($cs_maps AS $map) {
      $sel = $map['maps_id'] == $cs_rounds['maps_id'] ? 1 : 0;
      $data['map'][$i]['sel'] = cs_html_option($map['maps_name'],$map['maps_id'],$sel);
      $i++;
    }
  }
  $data['rounds']['new_map'] = $new_map;
  $data['abcode']['smileys'] = cs_abcode_smileys('rounds_description');
  $data['abcode']['features'] = cs_abcode_features('rounds_description');

  $data['rounds']['id'] = $rounds_id;
  
  echo cs_subtemplate(__FILE__,$data,'wars','roundsedit');
}
else {

  if (!empty($_POST['new_map'])) {
      
    $tables = 'wars wrs INNER JOIN {pre}_games gms ON wrs.games_id = gms.games_id';
    $cells = 'gms.games_id AS games_id';
    $where = "wrs.wars_id = '".$warid."'";
    
    $get_game_id = cs_sql_select(__FILE__,$tables,$cells,$where);
    
    $cells1 = array('maps_name','games_id');
    $values1 = array($_POST['new_map'],$get_game_id['games_id']);
    
    cs_sql_insert(__FILE__,'maps',$cells1,$values1);
    
    $cs_rounds['maps_id'] = cs_sql_insertid(__FILE__);
    
  } else {
    $cs_rounds['maps_id'] = (int) $_POST['maps_id'];
  }
  
  $cells = array_keys($cs_rounds);
  $save = array_values($cs_rounds);
  cs_sql_update(__FILE__,'rounds',$cells,$save,$rounds_id);
  
  $warid = cs_sql_select(__FILE__,'rounds','wars_id',"rounds_id = '".$rounds_id."'");
  
  cs_redirect($cs_lang['create_done'],'wars','rounds','id='.$cs_rounds['wars_id']);
}