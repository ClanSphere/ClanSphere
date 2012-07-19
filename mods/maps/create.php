<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('maps');

$files_gl = cs_files();
$data = array();
$options = cs_sql_option(__FILE__,'maps');

$img_filetypes = array('gif','jpg','png');

if (!empty($_POST['submit'])) {

  $error = '';

  if(empty($_POST['maps_name'])) {
    $error .= cs_html_br(1) . '- ' . $cs_lang['no_name'];
  }
  if(empty($_POST['games_id'])) {
    $error .= cs_html_br(1) . '- ' . $cs_lang['no_game'];
  }

  $img_size = empty($files_gl['picture']['tmp_name']) ? 0 : getimagesize($files_gl['picture']['tmp_name']);

  if(!empty($files_gl['picture']['tmp_name']) AND empty($img_size) OR $img_size[2] > 3) {
    $error .= cs_html_br(1) . '- ' . $cs_lang['ext_error'];
  } elseif(!empty($files_gl['picture']['tmp_name'])) {
    switch($img_size[2]) {
      case 1:
        $extension = 'gif'; break;
      case 2:
        $extension = 'jpg'; break;
      case 3:
        $extension = 'png'; break;
    }

    if($img_size[0] > $options['max_width']) {
      $error .= cs_html_br(1) . '- ' . $cs_lang['too_wide'];
    }

    if($img_size[1] > $options['max_height']) {
      $error .= cs_html_br(1) . '- ' . $cs_lang['too_high'];
    }

    if($files_gl['picture']['size'] > $options['max_size']) {
      $error .= cs_html_br(1) . '- ' . $cs_lang['too_big'];
    }
  }

  $data['maps']['maps_name'] = empty($_POST['maps_name']) ? '' : $_POST['maps_name'];
  $data['maps']['server_name'] = empty($_POST['server_name']) ? 0 : $_POST['server_name'];
  $data['maps']['maps_text'] = empty($_POST['maps_text']) ? '' : $_POST['maps_text'];
  $data['maps']['games_id'] = empty($_POST['games_id']) ? 0 : (int) $_POST['games_id'];
} else {

  $data['maps']['maps_name'] = '';
  $data['maps']['server_name'] = '';
  $data['maps']['maps_text'] = '';
  $data['maps']['games_id'] = '';

}

if(empty($_POST['submit']) || !empty($error)) {
  $data['maps']['message'] = empty($error) ? $cs_lang['fill_in'] : $cs_lang['error_occured'] . $error;
  $data['maps']['action'] = cs_url('maps','create');
  $data['abcode']['features'] = cs_abcode_features('maps_text');
  $data['abcode']['smileys'] = cs_abcode_smileys('maps_text');
  $data['games'] = cs_sql_select(__FILE__,'games','games_name,games_id',0,'games_name',0,0);
  $data['games'] = cs_dropdownsel($data['games'],$data['maps']['games_id'],'games_id');
  $return_types = '';
  foreach($img_filetypes AS $add) {
    $return_types .= empty($return_types) ? $add : ', ' . $add;
  }
  $matches[1] = $cs_lang['pic_infos'];
  $matches[2] = $cs_lang['max_width'] . $options['max_width'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_height'] . $options['max_height'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_size'] . cs_filesize($options['max_size']) . cs_html_br(1);
  $matches[2] .= $cs_lang['filetypes'] . $return_types;
  $data['maps']['matches'] = cs_abcode_clip($matches);
  echo cs_subtemplate(__FILE__,$data,'maps','create');

} elseif (!empty($_POST['submit']) && empty($error)) {

  $cells = array('games_id','maps_name','maps_text', 'server_name');
  $values = array($_POST['games_id'],$_POST['maps_name'],$_POST['maps_text'], $_POST['server_name']);
  cs_sql_insert(__FILE__,'maps',$cells,$values);

  if(!empty($files_gl['picture']['tmp_name'])) {
    $where = "maps_name = '" . cs_sql_escape($_POST['maps_name']) . "'";
    $getid = cs_sql_select(__FILE__,'maps','maps_id',$where);

    $filename = 'picture-' . $getid['maps_id'] . '.' . $extension;

    cs_upload('maps',$filename,$files_gl['picture']['tmp_name']);

    $cells2 = array('maps_picture');
    $values2 = array($filename);

    cs_sql_update(__FILE__,'maps',$cells2,$values2,$getid['maps_id']);
  }
  cs_redirect($cs_lang['create_done'],'maps');
}