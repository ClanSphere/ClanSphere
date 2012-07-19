<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('squads');

$op_squads = cs_sql_option(__FILE__,'squads');
$op_clans = cs_sql_option(__FILE__,'clans');
$files = cs_files();

$data = array();

$data['if']['gamesmod'] = empty($account['access_games']) ? FALSE : TRUE;

$img_filetypes = array('gif','jpg','png');

if(isset($_POST['submit'])) {

  $cs_squads['clans_id'] = $_POST['clans_id'];
  $cs_squads['games_id'] = empty($_POST['games_id']) ? 0 : $_POST['games_id'];
  $cs_squads['squads_own'] = empty($_POST['squads_own']) ? 0 : 1;
  $cs_squads['squads_name'] = $_POST['squads_name'];
  $cs_squads['squads_order'] = empty($_POST['squads_order']) ? $op_squads['def_order'] : $_POST['squads_order'];
  $cs_squads['squads_pwd'] = $_POST['squads_pwd'];
  $cs_squads['squads_fightus'] = empty($_POST['squads_fightus']) ? 0 : 1;
  $cs_squads['squads_joinus'] = empty($_POST['squads_joinus']) ? 0 : 1;
  $cs_squads['squads_text'] = $_POST['squads_text'];
  
  $error = '';

  if(!empty($files['picture']['tmp_name']))
    $img_size = getimagesize($files['picture']['tmp_name']);
  if(!empty($files['picture']['tmp_name']) AND (empty($img_size) OR $img_size[2] > 3)) {
    $error .= $cs_lang['ext_error'] . cs_html_br(1);
  } elseif(!empty($files['picture']['tmp_name'])) {
    switch($img_size[2]) {
      case 1:
        $extension = 'gif'; break;
      case 2:
        $extension = 'jpg'; break;
      case 3:
        $extension = 'png'; break;
    }
    
    if($img_size[0]>$op_squads['max_width']) {
      $error .= $cs_lang['too_wide'] . cs_html_br(1);
    }
    if($img_size[1]>$op_squads['max_height']) { 
      $error .= $cs_lang['too_high'] . cs_html_br(1);
    }
    if($files['picture']['size']>$op_squads['max_size']) { 
      $error .= $cs_lang['too_big'] . cs_html_br(1);
    }
  }
  if(empty($cs_squads['clans_id'])) {
    $error .= $cs_lang['no_'.$op_clans['label']] . cs_html_br(1);
  }
  if(empty($cs_squads['squads_name'])) {
    $error .= $cs_lang['no_name'] . cs_html_br(1);
  }
  
  $where = "squads_name = '" . cs_sql_escape($cs_squads['squads_name']) . "'";
  $search = cs_sql_count(__FILE__,'squads',$where);
  if(!empty($search)) {
    $error .= $cs_lang['squad_exists'] . cs_html_br(1);
  }
}
else {

  $cs_squads['clans_id'] = 0;
  $cs_squads['games_id'] = 0;
  $cs_squads['squads_own'] = 0;
  $cs_squads['squads_name'] = '';
  $cs_squads['squads_order'] = $op_squads['def_order'];
  $cs_squads['squads_pwd'] = '';
  $cs_squads['squads_fightus'] = 0;
  $cs_squads['squads_joinus'] = 0;
  $cs_squads['squads_text'] = '';
}

if(!isset($_POST['submit'])) {
  $data['head']['body'] = $cs_lang['errors_here'];
}
elseif(!empty($error)) {
   $data['head']['body'] = $error;
}


if(!empty($error) OR !isset($_POST['submit'])) {
  
  foreach($cs_squads AS $key => $value)
    $data['squads'][$key] = cs_secure($value);

  $data['head']['mod'] = $cs_lang[$op_squads['label'].'s'];
  $data['squads']['abcode'] = cs_abcode_features('squads_text');

  $data['lang']['own_label'] = $cs_lang['own_'.$op_clans['label']];
  $checked = 'checked="checked"';
  $data['squads']['own_check'] = empty($cs_squads['squads_own']) ? '' : $checked;
  
   $data['squads']['joinus_check'] = empty($cs_squads['squads_joinus']) ? '' : $checked ;
   $data['squads']['fightus_check'] = empty($cs_squads['squads_fightus']) ? '' : $checked ;
   
  $data['lang']['clan_label'] = $cs_lang[$op_clans['label']];
  $cs_clans = cs_sql_select(__FILE__,'clans','clans_name,clans_id',0,'clans_name',0,0);
  $data['squads']['clan_sel'] = cs_dropdown('clans_id','clans_name',$cs_clans,$cs_squads['clans_id']);

  if($data['if']['gamesmod'] == TRUE) {
    $data['games'] = array();
    $el_id = 'game_1';
    $cs_games = cs_sql_select(__FILE__,'games','games_name,games_id',0,'games_name',0,0);
    $games_count = count($cs_games);
    for($run = 0; $run < $games_count; $run++) {
      $sel = $cs_games[$run]['games_id'] == $cs_squads['games_id'] ? 1 : 0;
      $data['games'][$run]['sel'] = cs_html_option($cs_games[$run]['games_name'],$cs_games[$run]['games_id'],$sel);
    }
    $url = 'uploads/games/' . $cs_squads['games_id'] . '.gif';
    $data['squads']['games_img'] = cs_html_img($url,0,0,'id="' . $el_id . '"');
  }

  $matches[1] = $cs_lang['secure_stages'];
  $matches[2] = $cs_lang['stage_1'] . $cs_lang['stage_1_text'] . cs_html_br(1);
  $matches[2] .= $cs_lang['stage_2'] . $cs_lang['stage_2_text'] . cs_html_br(1);
  $matches[2] .= $cs_lang['stage_3'] . $cs_lang['stage_3_text'] . cs_html_br(1);
  $matches[2] .= $cs_lang['stage_4'] . $cs_lang['stage_4_text'];
  $data['squads']['secure_clip'] = cs_abcode_clip($matches);

  $matches[1] = $cs_lang['pic_infos'];
  $return_types = '';
  foreach($img_filetypes AS $add) {
    $return_types .= empty($return_types) ? $add : ', ' . $add;
  }
  $matches[2] = $cs_lang['max_width'] . $op_squads['max_width'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_height'] . $op_squads['max_height'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_size'] . cs_filesize($op_squads['max_size']) . cs_html_br(1);
  $matches[2] .= $cs_lang['filetypes'] . $return_types;
  $data['squads']['picup_clip'] = cs_abcode_clip($matches);


  echo cs_subtemplate(__FILE__,$data,'squads','create');
}
else {

  $squads_cells = array_keys($cs_squads);
  $squads_save = array_values($cs_squads);
  cs_sql_insert(__FILE__,'squads',$squads_cells,$squads_save);

  if(!empty($files['picture']['tmp_name'])) {
      $where = "squads_name = '" . cs_sql_escape($cs_squads['squads_name']) . "'";
      $getid = cs_sql_select(__FILE__,'squads','squads_id',$where);
    $filename = 'picture-' . $getid['squads_id'] . '.' . $extension;
      cs_upload('squads',$filename,$files['picture']['tmp_name']);
    
    $cs_squads2['squads_picture'] = $filename;
    $squads2_cells = array_keys($cs_squads2);
    $squads2_save = array_values($cs_squads2);      
    cs_sql_update(__FILE__,'squads',$squads2_cells,$squads2_save,$getid['squads_id']);
  }
  cs_redirect($cs_lang['create_done'],'squads');
}