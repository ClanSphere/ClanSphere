<?php
// ClanSphere 2006 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');
require_once('mods/gallery/functions.php');
$form = 1;
$id = (int)$_REQUEST['id'];

$from = 'folders';
$select = 'folders_id, sub_id, ';
$select .= 'folders_name, folders_order, ';
$select .= 'folders_position, folders_picture';
$where = "folders_id=" . $id . " AND folders_mod='gallery'";
$order = 'folders_id ASC';
$array = cs_sql_select(__FILE__,$from,$select,$where);

$pic = cs_secure($array['folders_picture']);

if(isset($_POST['agree']))
{
  $form = 0;

  // Remove the folder thumbnail
  if(!empty($pic)) {
    cs_unlink('folders', $pic, 'pictures');
  }
  
  // Remove all the pictures that where stored in the folder
  $gallery_pics = cs_sql_select(__FILE__,'gallery','gallery_name, gallery_id','folders_id='.$id,0,0,0);
  foreach($gallery_pics AS $pic_array) {
    
    $pic = $pic_array['gallery_name'];
    $gallery_id = $pic_array['gallery_id'];
    
    // Del on HDD
    if (!cs_unlink('gallery', $pic, 'pics') OR !cs_unlink('gallery', 'Thumb_' . $pic, 'thumbs')) {
      cs_redirect($cs_lang['del_false'], 'gallery');
      die();
    }
    
    // Del on DB
    $query = "DELETE FROM {pre}_voted WHERE voted_mod='gallery' AND ";
    $query .= "voted_fid=" . $gallery_id;
    cs_sql_query(__FILE__,$query);
    $query = "DELETE FROM {pre}_comments WHERE comments_mod='gallery' AND ";
    $query .= "comments_fid=" . $gallery_id;
    cs_sql_query(__FILE__,$query);
  
  cs_sql_delete(__FILE__,'gallery',$gallery_id);
  }

  $from = 'folders';
  $select = 'folders_id, sub_id, ';
  $select .= 'folders_name, folders_order, folders_position';
  $where = "folders_mod='gallery'";
  $order = 'folders_id ASC';
  $array = cs_sql_select(__FILE__,$from,$select,$where,$order,0,0);
  $loop = count($array);
  $array = make_folders_array($array);
  make_folders_remove($array,$id);

  cs_redirect($cs_lang['del_true'],'gallery','manage','page=folders');
}

if(isset($_POST['cancel']))
{
  $form = 0;
  
  cs_redirect($cs_lang['del_false'],'gallery','manage','page=folders');
}

if(!empty($form))
{
  echo cs_html_table(1,'forum',1);
    echo cs_html_roco(1,'headb');
    echo $cs_lang['mod'] . ' - ' . $cs_lang['remove'];
    echo cs_html_roco(0);
    echo cs_html_roco(1,'leftb');
  echo sprintf($cs_lang['del_rly'],$array['folders_name']);
  echo cs_html_roco(0);
  echo cs_html_roco(1,'centerc');
  echo cs_html_form(1,'remove','gallery','folders_remove');
  echo cs_html_vote('id',$id,'hidden');
  echo cs_html_vote('agree',$cs_lang['confirm'],'submit');
  echo cs_html_vote('cancel',$cs_lang['cancel'],'submit');
  echo cs_html_form (0);
  echo cs_html_roco(0);
  echo cs_html_table(0);
}
?>