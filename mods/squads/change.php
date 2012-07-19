<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('squads');

$cs_post = cs_post('id');
$cs_get = cs_get('id');
$files = cs_files();

$data = array();

$data['if']['gamesmod'] = empty($account['access_games']) ? FALSE : TRUE;

$op_squads = cs_sql_option(__FILE__,'squads');
$op_clans = cs_sql_option(__FILE__,'clans');

$squads_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $squads_id = $cs_post['id'];
$clans_pwd = isset($_POST['clans_pwd']) ? $_POST['clans_pwd'] : '';

$data['if']['advanced'] = FALSE;

$op_squads = cs_sql_option(__FILE__,'squads');
$img_filetypes = array('gif','jpg','png');

$from = 'squads sqd INNER JOIN {pre}_members mem ON sqd.squads_id = mem.squads_id';
$cells = 'sqd.clans_id AS clans_id, sqd.games_id AS games_id, sqd.squads_id AS squads_id, sqd.squads_name AS squads_name, sqd.squads_order AS squads_order, sqd.squads_pwd AS squads_pwd, sqd.squads_picture AS squads_picture';
$where = "mem.users_id = '" . $account['users_id'] . "' AND mem.members_admin = 1 AND sqd.squads_id = '" . $squads_id . "'";
$cs_squads_select = cs_sql_select(__FILE__,$from,$cells,$where);

if(isset($_POST['submit'])) {

  $cs_squads['clans_id'] = $_POST['clans_id'];
  $cs_squads['games_id'] = empty($_POST['games_id']) ? 0 : $_POST['games_id'];
  $cs_squads['squads_name'] = $_POST['squads_name'];
  $cs_squads['squads_order'] = empty($_POST['squads_order']) ? $op_squads['def_order'] : $_POST['squads_order'];
  $cs_squads['squads_pwd'] = $_POST['squads_pwd'];
  $cs_squads['squads_picture'] = $_POST['squads_picture'];
  
  $error = '';

  if(empty($cs_squads['clans_id'])) {
    $error .= $cs_lang['no_clan'] . cs_html_br(1);
  }
  if(empty($cs_squads['squads_name'])) {
    $error .= $cs_lang['no_name'] . cs_html_br(1);
  }
  
  $where = "squads_name = '" . cs_sql_escape($cs_squads['squads_name']) . "'";
  $where .= " AND squads_id != '" . $squads_id . "'";
  $search = cs_sql_count(__FILE__,'squads',$where);
  if(!empty($search)) {
    $error .= $cs_lang['squad_exists'] . cs_html_br(1);
  }
  $where = "squads_id = '" . $squads_id . "' AND users_id = '" . $account['users_id'] . "'";
  $search_admin = cs_sql_select(__FILE__,'members','members_admin',$where);
  if(empty($search_admin['members_admin'])) {
    $error .= $cs_lang['no_admin'] . cs_html_br(1);
  }
  if ($cs_squads['clans_id'] != $cs_squads_select['clans_id']) {
    $where = "clans_id = '" . cs_sql_escape($cs_squads['clans_id']) . "'";
    $search = cs_sql_select(__FILE__,'clans','clans_pwd',$where);
    if(empty($search['clans_pwd']) OR $search['clans_pwd'] != $clans_pwd) {
      $error .= $cs_lang['pwd_wrong'] . cs_html_br(1);
    }
  }

  # this is mainly to prevent changes to different squad ids
  if(empty($error)) {

    # squad picture related
    if(isset($_POST['delete']) AND $_POST['delete'] == TRUE AND !empty($cs_squads['squads_picture'])) {
      cs_unlink('squads', $cs_squads['squads_picture']);
      $cs_squads['squads_picture'] = '';
    }

    $img_size = false;
    if(!empty($files['picture']['tmp_name']))
      $img_size = getimagesize($files['picture']['tmp_name']);

    if(!empty($files['picture']['tmp_name']) AND empty($img_size) OR $img_size[2] > 3) {
      $error .= $cs_lang['ext_error'] . cs_html_br(1);
    }
    elseif(!empty($files['picture']['tmp_name'])) {

      switch($img_size[2]) {
      case 1:
        $ext = 'gif'; break;
      case 2:
        $ext = 'jpg'; break;
      case 3:
        $ext = 'png'; break;
      }
      $filename = 'picture-' . $squads_id . '.' . $ext;
      
      if($img_size[0]>$op_squads['max_width']) {
        $error .= $cs_lang['too_wide'] . cs_html_br(1);
      }
      if($img_size[1]>$op_squads['max_height']) { 
        $error .= $cs_lang['too_high'] . cs_html_br(1);
      }
      if($files['picture']['size']>$op_squads['max_size']) { 
        $error .= $cs_lang['too_big'] . cs_html_br(1);
      }
      if(empty($error) AND cs_upload('squads', $filename, $files['picture']['tmp_name']) OR !empty($error) AND extension_loaded('gd') AND cs_resample($files['picture']['tmp_name'], 'uploads/squads/' . $filename, $op_squads['max_width'], $op_squads['max_height'])) {
        $error = 0;
        $error = '';
        if($cs_squads['squads_picture'] != $filename AND !empty($cs_squads['squads_picture'])) {
          cs_unlink('squads', $cs_squads['squads_picture']);
        }
        $cs_squads['squads_picture'] = $filename;
      }
      else {
          $error .= $cs_lang['up_error'];
      }
    }
  }
}
else {
  $cs_squads = $cs_squads_select;
}

if(!isset($_POST['submit'])) {
  $data['head']['body'] = $cs_lang['body_change'];
}
elseif(!empty($error)) {
  $data['head']['body'] = $error;
}

if(!empty($error) OR !isset($_POST['submit'])) {
  
  foreach($cs_squads AS $key => $value)
    $data['squads'][$key] = cs_secure($value);

  $data['head']['mod'] = $cs_lang[$op_squads['label'].'s'];

  $data['lang']['clan_label'] = $cs_lang[$op_clans['label']];
  $cs_clans = cs_sql_select(__FILE__,'clans','clans_name,clans_id',"clans_pwd != '' OR clans_id = " . (int) $cs_squads['clans_id'],'clans_name',0,0);
  $data['squads']['clans_sel'] = cs_dropdown('clans_id','clans_name',$cs_clans,$cs_squads['clans_id']);

  $data['squads']['clans_pwd'] = $clans_pwd;

  if($data['if']['gamesmod'] == TRUE) {
    $el_id = 'game_1';
    $cs_games = cs_sql_select(__FILE__,'games','games_name,games_id',0,'games_name',0,0);
    $games_count = count($cs_games);
    $data['squads']['games_sel'] = '';
    for($run = 0; $run < $games_count; $run++) {
      $sel = $cs_games[$run]['games_id'] == $cs_squads['games_id'] ? 1 : 0;
      $data['squads']['games_sel'] .= cs_html_option($cs_games[$run]['games_name'],$cs_games[$run]['games_id'],$sel);
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

  if(empty($cs_squads['squads_picture'])) {
    $data['squads']['current_pic'] = $cs_lang['nopic'];
  }
  else {
    $data['if']['advanced'] = TRUE;
    $place = 'uploads/squads/' . $cs_squads['squads_picture'];
      $size = getimagesize($cs_main['def_path'] . '/' . $place);
    $data['squads']['current_pic'] = cs_html_img($place,$size[1],$size[0]);
  }

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

  $data['squads']['id'] = $squads_id;

  echo cs_subtemplate(__FILE__,$data,'squads','change');
}
else {

  $squads_cells = array_keys($cs_squads);
  $squads_save = array_values($cs_squads);
  cs_sql_update(__FILE__,'squads',$squads_cells,$squads_save,$squads_id);
  
  cs_redirect($cs_lang['changes_done'],'squads','center');
}