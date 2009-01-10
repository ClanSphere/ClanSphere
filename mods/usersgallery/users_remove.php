<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');

$gallery_form = 1;
$gallery_id = $_REQUEST['id'];
settype($gallery_id,'integer');

$cs_gallery = cs_sql_select(__FILE__,'usersgallery','*',"usersgallery_id = '" . $gallery_id . "'",'usersgallery_id DESC');
$pic = cs_secure($cs_gallery['usersgallery_name']);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['remove'];
echo cs_html_roco(0);
if($pic['users_id'] == $account['users_id'] OR $account['access_usersgallery'] > 4) {
  if(isset($_POST['agree'])) {
	$gallery_form = 0;

	cs_unlink('usersgallery', $pic, 'pics');
	cs_unlink('usersgallery', 'Thumb_' . $pic, 'thumbs');

	cs_sql_delete(__FILE__,'usersgallery',$gallery_id);
	$query = "DELETE FROM {pre}_voted WHERE voted_mod='usersgallery' AND ";
	$query .= "voted_fid='" . $gallery_id . "'";
	cs_sql_query(__FILE__,$query);
	$query = "DELETE FROM {pre}_comments WHERE comments_mod='usersgallery' AND ";
	$query .= "comments_fid='" . $gallery_id . "'";
	cs_sql_query(__FILE__,$query);

	cs_redirect($cs_lang['del_true'],'usersgallery','center');
}

if(isset($_POST['cancel'])) {
	$gallery_form = 0;

	cs_redirect($cs_lang['del_false'],'usersgallery','center');
}

if(!empty($gallery_form)) {
	echo cs_html_roco(1,'leftb');
	$id = cs_secure($cs_gallery['usersgallery_id']);
	echo cs_html_img("mods/gallery/image.php?usersthumb=" . $id);
	echo cs_html_br(1);
	echo sprintf($cs_lang['del_rly'],$pic);
	echo cs_html_roco(0);
	echo cs_html_roco(1,'centerc');
	echo cs_html_form(1,'gallery_remove','usersgallery','users_remove');
	echo cs_html_vote('id',$gallery_id,'hidden');
	echo cs_html_vote('agree',$cs_lang['confirm'],'submit');
	echo cs_html_vote('cancel',$cs_lang['cancel'],'submit');
	echo cs_html_form (0);
	echo cs_html_roco(0);
	echo cs_html_table(0);
}
} else {
  cs_redirect('','errors','404');
}  
?>