<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['remove'];
echo cs_html_roco(0);

$watermark_form = 1;
$watermark_id = $_REQUEST['id'];
settype($watermark_id,'integer');

if(isset($_POST['agree'])) {

	$watermark_form = 0;
	$where = "categories_id = '" . $watermark_id . "'";
	$getpic = cs_sql_select(__FILE__,'categories','categories_picture',$where);
	if(!empty($getpic['categories_picture'])) {
		cs_unlink('categories', $getpic['categories_picture']);
	}
	cs_sql_delete(__FILE__,'categories',$watermark_id);	

	cs_redirect($cs_lang['del_true'],'gallery','manage','watermark');
}

if(isset($_POST['cancel'])) {
	$watermark_form = 0;

	cs_redirect($cs_lang['del_false'],'gallery','manage','watermark');
}

if(!empty($watermark_form)) {

	echo cs_html_roco(1,'leftb');
	echo sprintf($cs_lang['del_rly'],$watermark_id);
	echo cs_html_roco(0);

	echo cs_html_roco(1,'centerc');
	echo cs_html_form(1,'watermark_remove','gallery','wat_remove');
	echo cs_html_vote('id',$watermark_id,'hidden');
	echo cs_html_vote('agree',$cs_lang['confirm'],'submit');
	echo cs_html_vote('cancel',$cs_lang['cancel'],'submit');
	echo cs_html_form (0);
	echo cs_html_roco(0);
	echo cs_html_table(0);
}

?>