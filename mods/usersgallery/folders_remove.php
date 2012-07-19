<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery', 1);
$cs_post = cs_post('id');
$cs_get = cs_get('id');
$data = array();

$folders_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $folders_id = $cs_post['id'];

require_once('mods/gallery/functions.php');

# select folder
$select = 'folders_id, sub_id, folders_name, folders_order, folders_position, folders_picture';
$where = "folders_id= '" . $folders_id . "' AND folders_mod = 'usersgallery'";
$folder = cs_sql_select(__FILE__,'folders',$select,$where);

# select pictures in folder
$select = 'usersgallery_id';
$where = "folders_id = '" . $folders_id . "'";
$pictures = cs_sql_select(__FILE__,'usersgallery',$select,$where,0,0,0);
$count_pictures = count($pictures);

# get subfolders
$subfolders = get_subfolders($folders_id);
$subfolders = empty($subfolders) ? array() : $subfolders;
$count_subfolders = count($subfolders);

# count pictures in subfolders
$count_it = 0;
foreach($subfolders AS $sub) {
  $where = "folders_id = '" . $sub['folders_id'] . "'";
  $count_pics = cs_sql_count(__FILE__,'usersgallery',$where);
  if(!empty($count_pics)) {
    $count_it += $count_pics;
  }
}

$all_pictures = $count_it + $count_pictures;


if(isset($_POST['agree'])) {

  $delete_mode = isset($_POST['del']) ? (int) $_POST['del'] : 0;
  $new_folders_id = isset($_POST['folders_id']) ? (int) $_POST['folders_id'] : 0;
  
  $error = '';
  
  if(empty($delete_mode) AND !empty($count_pictures))
    $error .= $cs_lang['pls_sel_del_mode'] . cs_html_br(1);
  if($delete_mode == 3 AND empty($new_folders_id))
    $error .= $cs_lang['pls_sel_target'] . cs_html_br(1);
  elseif($delete_mode == 3 AND $new_folders_id == $folders_id)
    $error .= $cs_lang['target_same'] . cs_html_br(1);

}

$data['if']['error'] = FALSE;
if(!empty($error)) {
  $data['if']['error'] = TRUE;
  $data['error']['msg'] = $error;
}
  

if(isset($_POST['cancel']))
  cs_redirect($cs_lang['del_false'],'usersgallery','center','page=cat');


if(!empty($error) OR !isset($_POST['agree'])){

  $ask = ' ' . $cs_lang['del_question'];

  if(!empty($count_subfolders) AND !empty($count_pictures)) {
    $msg = sprintf($cs_lang['del_subfolder_pictures'],cs_secure($folder['folders_name']),$count_subfolders,$all_pictures) . $ask;
    $data['if']['pictures_in_folder'] = TRUE;
  }
  elseif(!empty($count_subfolders) AND empty($count_pictures)) {
    $msg = sprintf($cs_lang['del_subfolder'],cs_secure($folder['folders_name']),$count_subfolders) . $ask;
  }
  elseif(!empty($count_pictures) AND empty($count_subfolders)) {
    $msg = sprintf($cs_lang['del_folder_pics'],cs_secure($folder['folders_name']),$count_pictures) . $ask;
    $data['if']['pictures_in_folder'] = TRUE;    
  }
  else {
    $msg = sprintf($cs_lang['del_folder_rly'],cs_secure($folder['folders_name']));
    $data['if']['pictures_in_folder'] = FALSE;
  }
  
  $data['lang']['fr_opt_2'] = sprintf($cs_lang['fr_opt_2'],$count_pictures,cs_secure($folder['folders_name']));
    
  $where = "folders_mod = 'usersgallery' AND folders_id != '" . $folders_id . "' AND users_id = '" . $account['users_id'] . "'";
  $select = 'folders_id, folders_name, sub_id, folders_position';
  $folders = cs_sql_select(__FILE__,'folders',$select,$where,'folders_name',0,0);
  if(!empty($folders)) {
    $data['if']['other_folders'] = TRUE;
    $data['folders']['dropdown'] = make_folders_select('folders_id',0,$account['users_id'],'usersgallery',0);
  }else{
    $data['if']['other_folders'] = FALSE;
  }

  $data['head']['body'] = $msg;
  $data['hidden']['id'] = $folders_id;
  
 echo cs_subtemplate(__FILE__,$data,'usersgallery','folders_remove');

}
else {

  # move folder content to new selected folder ($new_folders_id)
  if($delete_mode == 3){
  
    # move subfolders -> new selected folder
    foreach($get_subfolders AS $sub) {
      $cells = array('sub_id');
      $update = array($new_folders_id);
     cs_sql_update(__FILE__,'folders',$cells,$update,$sub['folders_id']);
    }
    // move pictures -> new selected folder
    foreach($pictures AS $picture) {
      $cells = array('folders_id');
      $update = array($new_folders_id);
     cs_sql_update(__FILE__,'usersgallery',$cells,$update,$picture['usersgallery_id']);
    }
  
  }
 
  if($delete_mode == 1 OR $delete_mode == 2) {
    # remove all the pictures that where stored in the folder
    $gallery_pics = cs_sql_select(__FILE__,'usersgallery','usersgallery_name, usersgallery_id','folders_id='.$folders_id,0,0,0);
    foreach($gallery_pics AS $pic_array) {
      $pic = $pic_array['usersgallery_name'];
      $gallery_id = $pic_array['usersgallery_id'];
    
      # del on HDD
      if (!cs_unlink('usersgallery', $pic, 'pics') OR !cs_unlink('usersgallery', 'Thumb_' . $pic, 'thumbs')) {
        cs_redirect($cs_lang['del_false'], 'usersgallery','center','page=cat');
        die();
      }
    
      # del on DB (comments & votings)
      $query = "DELETE FROM {pre}_voted WHERE voted_mod='usersgallery' AND ";
      $query .= "voted_fid=" . $gallery_id;
     cs_sql_query(__FILE__,$query);
      $query = "DELETE FROM {pre}_comments WHERE comments_mod='usersgallery' AND ";
      $query .= "comments_fid=" . $gallery_id;
     cs_sql_query(__FILE__,$query);
  
     cs_sql_delete(__FILE__,'usersgallery',$gallery_id);
    }
  }

  if($delete_mode == 1 OR $delete_mode == 3) {
    # remove the folder thumbnail
    if(!empty($folder['folders_picture'])) {
      cs_unlink('folders',$folder['folders_picture'],'pictures');
    }
  }
  if($delete_mode == 1) {
    # remove the folder and subfolders
    $select = 'folders_id, sub_id, folders_name, folders_order, folders_position';
    $folder = cs_sql_select(__FILE__,'folders',$select,"folders_mod='usersgallery'",'folders_id ASC',0,0);
    $folder = make_folders_array($folder);
   make_folders_remove($folder,$folders_id);
  }
  if($delete_mode == 3 OR empty($delete_mode) AND empty($count_pictures)) {
    # delete only folder
    cs_sql_delete(__FILE__,'folders',$folders_id);
  }

  cs_redirect($cs_lang['del_true'],'usersgallery','center','page=cat');
}