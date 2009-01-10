<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');

$gallery_form = 1;
$gallery_id = (int)$_REQUEST['id'];

$cs_gallery = cs_sql_select(__FILE__,'gallery','*',"gallery_id = " . $gallery_id,'gallery_id DESC');
$pic = cs_secure($cs_gallery['gallery_name']);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['remove'];
echo cs_html_roco(0);

if(isset($_POST['agree']))
{
	$gallery_form = 0;
	
  if (!cs_unlink('gallery', $pic, 'pics') OR !cs_unlink('gallery', 'Thumb_' . $pic, 'thumbs')) {
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

if(isset($_POST['cancel']))
  	cs_redirect($cs_lang['del_false'], 'gallery');

if(!empty($gallery_form))
{
	echo cs_html_roco(1,'leftb');
	$id = cs_secure($cs_gallery['gallery_id']);
	echo cs_html_img("mods/gallery/image.php?thumb=" . $id);
	echo cs_html_br(1);
	echo $cs_lang['del_before_pic'] . $pic . $cs_lang['del_next_pic'];
	echo cs_html_roco(0);
	echo cs_html_roco(1,'centerc');
	echo cs_html_form(1,'gallery_remove','gallery','remove');
	echo cs_html_vote('id',$gallery_id,'hidden');
	echo cs_html_vote('agree',$cs_lang['confirm'],'submit');
	echo cs_html_vote('cancel',$cs_lang['cancel'],'submit');
	echo cs_html_form (0);
	echo cs_html_roco(0);
	echo cs_html_table(0);
}
?>