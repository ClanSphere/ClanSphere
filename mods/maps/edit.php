<?php
// ClanSphere 2009 - www.clansphere.net 
// $Id$

$cs_lang = cs_translate('maps');
$data = array();

$img_max['width'] = 150;
$img_max['height'] = 150;
$img_max['size'] = 51200;
$img_filetypes = array('gif','jpg','png');

if(empty($_GET['id']) AND empty($_POST['submit'])) {

  $data['maps']['action'] = $cs_lang['edit'];
  $data['maps']['link'] = cs_url('maps','manage');
  echo cs_subtemplate(__FILE__,$data,'maps','no_selection');
  
} else {

  if (!empty($_POST['submit'])) {
  $error = '';
  
  if(empty($_POST['maps_name'])) {
    $error .= cs_html_br(1) . '- ' . $cs_lang['no_name'];
  }
  
  if(empty($_POST['games_id'])) {
    $error .= cs_html_br(1) . '- ' . $cs_lang['no_game'];
  }

  $img_size = getimagesize($_FILES['picture']['tmp_name']);
  
  if(!empty($_FILES['picture']['tmp_name']) AND empty($img_size) OR $img_size[2] > 3) {
    $error .= cs_html_br(1) . '- ' . $cs_lang['ext_error'];
    } elseif(!empty($_FILES['picture']['tmp_name'])) {
      switch($img_size[2]) {
        case 1:
          $extension = 'gif'; break;
        case 2:
          $extension = 'jpg'; break;
        case 3:
          $extension = 'png'; break;
      }
  
      if($img_size[0] > $img_max['width']) {
        $error .= cs_html_br(1) . '- ' . $cs_lang['too_wide'];
      }
    
      if($img_size[1] > $img_max['height']) { 
        $error .= cs_html_br(1) . '- ' . $cs_lang['too_high'];
      }
    
      if($_FILES['picture']['size'] > $img_max['size']) { 
        $error .= cs_html_br(1) . '- ' . $cs_lang['too_big'];
      }
    }
  }    

  if (empty($_POST['submit']) || !empty($error)) {
  
    $maps_id = empty($_POST['submit']) ? (int) $_GET['id'] : $_POST['maps_id'];
    $cells = 'games_id, maps_name, maps_text, maps_picture';
    $data['maps'] = cs_sql_select(__FILE__,'maps',$cells,'maps_id = \''.$maps_id.'\'');
    $data['maps']['maps_id'] = empty($error) ? (int) $_GET['id'] : (int) $_POST['maps_id'];
    $data['maps']['message'] = empty($error) ? $cs_lang['fill_in'] : $cs_lang['error_occured'] . $error;
    $data['maps']['maps_name'] = empty($_POST['maps_name']) ? $data['maps']['maps_name'] : $_POST['maps_name'];
    $data['maps']['maps_text'] = empty($_POST['maps_text']) ? $data['maps']['maps_text'] : $_POST['maps_text'];
    $data['abcode']['smileys'] = cs_abcode_smileys('maps_text');
    $data['abcode']['features'] = cs_abcode_features('maps_text');
    $data['maps']['action'] = cs_url('maps','edit');
    $data['games'] = cs_sql_select(__FILE__,'games','games_name,games_id',0,'games_name',0,0);
    $data['games'] = cs_dropdownsel($data['games'],$data['maps']['games_id'],'games_id');
    $data['maps']['maps_picture'] = empty($data['maps']['maps_picture']) ? '-' : cs_html_img('uploads/maps/' . $data['maps']['maps_picture']);
    $matches[1] = $cs_lang['pic_infos'];
    $return_types = '';
    foreach($img_filetypes AS $add) {
      $return_types .= empty($return_types) ? $add : ', ' . $add;
    }
    $matches[2] = $cs_lang['max_width'] . $img_max['width'] . ' px' . cs_html_br(1);
    $matches[2] .= $cs_lang['max_height'] . $img_max['height'] . ' px' . cs_html_br(1);
    $matches[2] .= $cs_lang['max_size'] . cs_filesize($img_max['size']) . cs_html_br(1);
    $matches[2] .= $cs_lang['filetypes'] . $return_types;
    $data['maps']['matches'] = cs_abcode_clip($matches);
  
    echo cs_subtemplate(__FILE__,$data,'maps','edit');
  
  } else {  
  
    $cs_maps['games_id'] = (int) $_POST['games_id'];
    $cs_maps['maps_name'] = $_POST['maps_name'];
    $cs_maps['maps_text'] = $_POST['maps_text'];
  
    $maps_id = (int) $_POST['maps_id'];

    if(empty($_POST['pic_del']) AND empty($_FILES['picture']['tmp_name'])) {
  
      $cells = array_keys($cs_maps);
      $values = array_values($cs_maps);
      cs_sql_update(__FILE__,'maps',$cells,$values,$maps_id);
    
    } elseif(isset($_POST['pic_del']) AND empty($_FILES['picture']['tmp_name'])) {
  
      $select = cs_sql_select(__FILE__,'maps','maps_picture','maps_id = \''.$maps_id.'\'');

      cs_unlink('maps', $select['maps_picture']);
    
      $cs_maps['maps_picture'] = '';
      
      $cells = array_keys($cs_maps);
      $values = array_values($cs_maps);
      cs_sql_update(__FILE__,'maps',$cells,$values,$maps_id);
    
    } else {
  
      $select = cs_sql_select(__FILE__,'maps','maps_picture','maps_id = \''.$maps_id.'\'');
      $url = 'uploads/maps/' . $select['maps_picture'];
      cs_unlink('maps', $select['maps_picture']);
      $filename = 'picture-' . $maps_id . '.' . $extension;
      cs_upload('maps',$filename,$_FILES['picture']['tmp_name']);
    
      $cs_maps['maps_picture'] = $filename;
    
      $cells = array_keys($cs_maps);
      $values = array_values($cs_maps);
      cs_sql_update(__FILE__,'maps',$cells,$values,$maps_id);
    }
  
    cs_redirect($cs_lang['changes_done'], 'maps') ;
  }
}

?>