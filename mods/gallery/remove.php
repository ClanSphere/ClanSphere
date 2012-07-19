<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');
$cs_get = cs_get('id');
$data = array();

$gallery_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

$cs_gallery = cs_sql_select(__FILE__,'gallery','gallery_name',"gallery_id = " . $gallery_id);
$picture = cs_secure($cs_gallery['gallery_name']);


if(isset($_GET['agree'])) {
  
  if (!cs_unlink('gallery', $picture, 'pics') OR !cs_unlink('gallery', 'Thumb_' . $picture, 'thumbs')) {
   cs_redirect($cs_lang['del_false'], 'gallery');
    die();
  }
  
 cs_sql_delete(__FILE__,'gallery',$gallery_id);
  $query = "DELETE FROM {pre}_voted WHERE voted_mod='gallery' AND ";
  $query .= "voted_fid=" . $gallery_id;
 cs_sql_query(__FILE__,$query);
  $query = "DELETE FROM {pre}_comments WHERE comments_mod='gallery' AND ";
  $query .= "comments_fid=" . $gallery_id;
 cs_sql_query(__FILE__,$query);

 cs_redirect($cs_lang['del_true'], 'gallery');
}

if(isset($_GET['cancel']))
 cs_redirect($cs_lang['del_false'], 'gallery');

else {

  $data['head']['body'] = sprintf($cs_lang['del_pic_rly'],$cs_gallery['gallery_name']);
  $data['gallery']['img'] = cs_html_img("mods/gallery/image.php?thumb=" . $gallery_id);
  $data['url']['agree'] = cs_url('gallery','remove','id=' . $gallery_id . '&amp;agree');
  $data['url']['cancel'] = cs_url('gallery','remove','id=' . $gallery_id . '&amp;cancel');

 echo cs_subtemplate(__FILE__,$data,'gallery','remove');
}