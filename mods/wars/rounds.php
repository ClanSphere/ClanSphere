<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('wars');
$cs_post = cs_post('id');
$cs_get = cs_get('id');
$data = array();

$wars_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $wars_id = $cs_post['id'];

$cs_rounds['wars_id'] = $wars_id;
$cs_rounds['maps_id'] = 0;
$new_map = '';
$cs_rounds['rounds_score1'] = '';
$cs_rounds['rounds_score2'] = '';
$cs_rounds['rounds_description'] = '';
$cs_rounds['rounds_order'] = cs_sql_count(__FILE__,'rounds','wars_id = \''.$cs_rounds['wars_id'].'\'') + 1;
$error = '';


if (!empty($_GET['up']) || !empty($_GET['down'])) {
  
  $roundid = !empty($_GET['up']) ? (int) $_GET['up'] : $_GET['down'];
  
  $round = cs_sql_select(__FILE__,'rounds','rounds_order',"rounds_id = '".$roundid."'");
  
  $new_order = !empty($_GET['up']) ? $round['rounds_order'] - 1 : $round['rounds_order'] + 1;
  $where = "wars_id = '" . $wars_id . "' AND rounds_order = '" . $new_order . "'";
  $round_old = cs_sql_select(__FILE__,'rounds','rounds_id',$where);
  
  $cells = array('rounds_order');
  
  if (empty($round_old)) {
  
    $rounds = cs_sql_select(__FILE__,'rounds','rounds_id',"wars_id = '".$wars_id."'",'rounds_id ASC',0,0);
    $count_rounds = count($rounds);
    for ($run = 0; $run < $count_rounds; $run++) {
      $values = array($run + 1);
      cs_sql_update(__FILE__,'rounds', $cells, $values, $rounds[$run]['rounds_id']);
    }
    
    $round = cs_sql_select(__FILE__,'rounds','rounds_order',"rounds_id = '".$roundid."'");
    $new_order = !empty($_GET['up']) ? $round['rounds_order'] - 1 : $round['rounds_order'] + 1;
    $where = "wars_id = '" . $wars_id . "' AND rounds_order = '" . $new_order . "'";
    $round_old = cs_sql_select(__FILE__,'rounds','rounds_id',$where);
  
  }
  
  $values = array($round['rounds_order']);
  cs_sql_update(__FILE__,'rounds', $cells, $values, $round_old['rounds_id']);
  
  $values = array($new_order);
  cs_sql_update(__FILE__,'rounds', $cells, $values, $roundid);   
  
}

if(isset($_POST['submit'])) {

  $cs_rounds['maps_id'] = (int) $_POST['maps_id'];
  $new_map = $_POST['new_map'];
  $cs_rounds['rounds_score1'] = (int) $_POST['rounds_score1'];
  $cs_rounds['rounds_score2'] = (int) $_POST['rounds_score2'];
  $cs_rounds['rounds_description'] = $_POST['rounds_description'];
  
  if(empty($_POST['maps_id']) AND empty($_POST['new_map']))
    $error .= $cs_lang['no_map'] . cs_html_br(1);
  
}

if(!isset($_POST['submit']))
  $data['head']['body'] = $cs_lang['rounds_management'];
elseif(!empty($error))
  $data['head']['body'] = $error;


if (!empty($error) OR empty($_POST['submit'])) {
  
  $data['wars'] = $cs_rounds;
  
  $cs_wars = cs_sql_select(__FILE__,'wars','games_id',"wars_id = '".$wars_id."'");
  $cs_maps = cs_sql_select(__FILE__,'maps','maps_name, maps_id',"games_id = '".$cs_wars['games_id']."'",'maps_name',0,0);
  $i = 0;
  if(!empty($cs_maps)) {
    foreach ($cs_maps AS $map) {
      $sel = $map['maps_id'] == $cs_rounds['maps_id'] ? 1 : 0;
      $data['map'][$i]['sel'] = cs_html_option($map['maps_name'],$map['maps_id'],$sel);
      $i++;
    }
  }
  $data['wars']['new_map'] = $new_map;
  $data['abcode']['smileys'] = cs_abcode_smileys('rounds_description');
  $data['abcode']['features'] = cs_abcode_features('rounds_description');

  $data['wars']['id'] = $wars_id;
  
  $data['get']['msg'] = cs_getmsg();
  
  $tables = 'rounds rnd LEFT JOIN {pre}_maps mps ON rnd.maps_id = mps.maps_id';
  $cells  = 'rnd.rounds_id AS rounds_id, rnd.rounds_score1 AS rounds_score1, ';
  $cells .= 'rnd.rounds_score2 AS rounds_score2, mps.maps_name AS maps_name, ';
  $cells .= 'rnd.rounds_order AS rounds_order';
  $sort = 'rnd.rounds_order ASC, rnd.rounds_id ASC';
  $cs_rounds = cs_sql_select(__FILE__,$tables,$cells,'rnd.wars_id = \''.$wars_id.'\'',$sort,0,0);
  $count = count($cs_rounds);
  
  if (!empty($cs_rounds)) {
      $data['if']['rounds'] = true;
    $img_up = cs_html_img('symbols/clansphere/up_arrow.png');
    $img_down = cs_html_img('symbols/clansphere/down_arrow.png');
    $run = 0;
    $run2 = 0;
    foreach ($cs_rounds AS $round) {
      $run2++;
      $data['maps'][$run]['name'] = $round['maps_name'];
      $data['maps'][$run]['result'] = $round['rounds_score1'] . ' : ' . $round['rounds_score2'];
      $data['maps'][$run]['rounds_id'] = $round['rounds_id'];
      $up = $run2 != 1 ? cs_link($img_up,'wars','rounds','id='.$wars_id.'&amp;up='.$round['rounds_id']) : '-';
      $down= $run2 != $count ? cs_link($img_down,'wars','rounds','id='.$wars_id.'&amp;down='.$round['rounds_id']) : '-';
      $data['maps'][$run]['up_down'] = $up . ' ' . $down;
      $run++;
    }    
  }
  else
  {
       $data['if']['rounds'] = false;      
  }
  
  echo cs_subtemplate(__FILE__,$data,'wars','rounds');
}
else {

  if (!empty($new_map)) {
    $get_game_id = cs_sql_select(__FILE__,'wars','games_id','wars_id = \''.$cs_rounds['wars_id'].'\'');
      
    $cells1 = array('maps_name','games_id');
    $values1 = array($_POST['new_map'],$get_game_id['games_id']);
    cs_sql_insert(__FILE__,'maps',$cells1,$values1);
    $cs_rounds['maps_id'] = cs_sql_insertid(__FILE__);  
  } else {
    $cs_rounds['maps_id'] = (int) $_POST['maps_id'];
  }
  
  $cells2 = array_keys($cs_rounds);
  $values2 = array_values($cs_rounds);    
   cs_sql_insert(__FILE__,'rounds',$cells2,$values2);
  
  cs_redirect($cs_lang['create_done'],'wars','rounds','id='.$cs_rounds['wars_id']);
}