<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');

require_once('mods/usersgallery/functions.php');

$gallery_id = $_REQUEST['id'];
settype($gallery_id,'integer');

$edit = cs_sql_select(__FILE__,'usersgallery','*',"usersgallery_id = '" . $gallery_id . "'");

$download = $edit['usersgallery_download'];
$temp = explode("|--@--|", $download);
$download_endi = $temp[0];
$watermark_vote = $temp[1];
$cs_option = cs_sql_option(__FILE__,'gallery');

if(!empty($temp[1]))
{
	$gallery_watermark_trans = $temp[1];
}
else
{
	$gallery_watermark_trans = '';
}
$gallery_count_reset = 0;
$new_time = 0;
$gallery_form = 1;
$gallery_error = 3;
$message = '';

	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'headb');
	echo $cs_lang['mod'] . ' - ' . $cs_lang['edit'];
	echo cs_html_roco(0);
	echo cs_html_roco(1,'leftb');
	echo $cs_lang['body_edit'];
	echo cs_html_roco(0);

if(isset($_POST['submit'])) {


	if(!empty($_POST['usersgallery_titel']))
	{
		$edit['usersgallery_titel'] = $_POST['usersgallery_titel'];
		$gallery_error--;
	}
	else
	{
		$message .= $cs_lang['no_titel'] . cs_html_br(1);
	}
  	$edit['folders_id'] = empty($_POST['folders_name']) ? $_POST['folders_id'] : cs_categories_create('usersgallery',$_POST['folders_name'],$account['users_id']);
	if(!empty($edit['folders_id']))
	{
		$edit['folders_id'] = $_POST['folders_id'];
		$gallery_error--;
	}
	else
	{
		$message .= $cs_lang['no_cat'] . cs_html_br(1);
	}

	if(!empty($_POST['usersgallery_vote']))
	{
		$edit['usersgallery_vote'] = $_POST['usersgallery_vote'];
	}

	if(!empty($_POST['watermark']))
	{
		$watermark = $_POST['watermark'];
		$watermark_pos = $_POST['watermark_pos'];
		$watermark_trans = $_POST['gallery_watermark_trans'];
		$watermark_pos = $watermark_pos . '|--@--|' . $watermark_trans;
	}
	else
	{
	$watermark = '';
	$watermark_pos = '';
	}

	if(!empty($_POST['download_endi']))
	{
		$download_endi = $_POST['download_endi'];
	}
	else
	{
		$download_endi = '0';
	}

	if(!empty($_POST['watermark_vote']))
	{
		$watermark_vote = $_POST['watermark_vote'];
	}
	else
	{
		$watermark_vote = '0';
	}

	$download = $download_endi . '|--@--|' . $watermark_vote;

	if(!empty($_POST['new_time']))
	{
		$edit['usersgallery_time'] = cs_time();
	}

	if(!empty($_POST['gallery_count_reset']))
	{
		$edit['usersgallery_count'] = 0;
	}

	if(!empty($_POST['usersgallery_access'])) {
		$edit['usersgallery_access'] = $_POST['usersgallery_access'];
	}

	if(!empty($_POST['usersgallery_status'])) {
		$edit['usersgallery_status'] = $_POST['usersgallery_status'];
	}
	else
	{
		$edit['usersgallery_status'] = '0';
	}

	if(!empty($_POST['usersgallery_description'])) {
		$edit['usersgallery_description'] = $_POST['usersgallery_description'];
		$gallery_error--;
	}
	else
	{
		$message .= $cs_lang['no_comment'] . cs_html_br(1);
	}
	$edit['usersgallery_close'] = isset($_POST['usersgallery_close']) ? $_POST['usersgallery_close'] : 0;

	if(empty($gallery_error)) {
		$gallery_form = 0;
		$cells = array_keys($edit);
		$save = array_values($edit);
		cs_sql_update(__FILE__,'usersgallery',$cells,$save,$gallery_id);


		cs_redirect($cs_lang['changes_done'],'usersgallery','center');
	}
} else {
        $fileerror=1;
       }


	if(!empty($message)) {

		echo cs_html_roco(1,'leftb');
    	echo $message;
		echo cs_html_roco(0);

	}

		echo cs_html_table(0);
		echo cs_html_br(1);

	if(!empty($gallery_form)) {

		echo cs_html_form (1,'gallery_pic','usersgallery','users_edit',1);
		echo cs_html_table(1,'forum',1);
		echo cs_html_roco(1,'leftc');
		echo cs_icon('download') . $cs_lang['upload'];
		echo cs_html_roco(2,'leftb',0,2);
		echo cs_html_img('mods/gallery/image.php?usersthumb=' . $edit['usersgallery_id']);
		echo cs_html_roco(0);

		echo cs_html_roco(1,'leftc');
		echo cs_icon('kedit') . $cs_lang['titel'];
		echo cs_html_roco(2,'leftb',0,2);
		echo cs_html_input('usersgallery_titel',$edit['usersgallery_titel'],'text',200,42);
		echo cs_html_roco(0);

		echo cs_html_roco(1,'leftc');
		echo cs_icon('folder_yellow') . $cs_lang['category'];
		echo cs_html_roco(2,'leftb',0,2);
		echo make_folders_select('folders_id',$edit['folders_id'],$account['users_id'],'usersgallery');
  		echo cs_html_roco(0);

		echo cs_html_roco(1,'leftc');
		echo cs_icon('access') . $cs_lang['needed_access'];
		echo cs_html_roco(2,'leftb',0,2);
		echo cs_html_select(1,'usersgallery_access');
		$levels = 0;
      	while($levels < 6)
		{
			$edit['usersgallery_access'] == $levels ? $sel = 1 : $sel = 0;
			echo cs_html_option($levels . ' - ' . $cs_lang['lev_' . $levels],$levels,$sel);
			$levels++;
		}
    	echo cs_html_select(0);
		echo cs_html_roco(0);

		echo cs_html_roco(1,'leftc');
		echo cs_icon('xpaint') . $cs_lang['show'];
		echo cs_html_roco(2,'leftb',0,2);
		echo cs_html_select(1,'usersgallery_status');
		$levels = 0;
    	while($levels < 2)
		{
			$edit['usersgallery_status'] == $levels ? $sel = 1 : $sel = 0;
			echo cs_html_option($levels . ' - ' . $cs_lang['show_' . $levels],$levels,$sel);
			$levels++;
		}
    	echo cs_html_select(0);
		echo cs_html_roco(0);

		echo cs_html_roco(1,'leftc');
		echo cs_icon('kate') . $cs_lang['comment'];
 		echo cs_html_br(2);
 		echo cs_abcode_smileys('gallery_comment');
		echo cs_html_roco(2,'leftb',0,2);
		echo cs_abcode_features('gallery_comment');
		echo cs_html_textarea('usersgallery_description',$edit['usersgallery_description'],'50','5');
		echo cs_html_roco(0);

		echo cs_html_roco(1,'leftc');
		echo cs_icon('configure') . $cs_lang['head'];
		echo cs_html_roco(2,'leftb',0,2);
		echo cs_html_vote('usersgallery_vote','1','checkbox',$edit['usersgallery_vote']);
		echo $cs_lang['vote_endi'];
		echo cs_html_br(1);
		echo cs_html_vote('download_endi','1','checkbox',$download_endi);
		echo $cs_lang['download_endi'];
		echo cs_html_br(1);
		echo cs_html_vote('new_time','1','checkbox',$new_time);
		echo $cs_lang['new_date'];
		echo cs_html_br(1);
		echo cs_html_vote('gallery_count_reset','1','checkbox',$gallery_count_reset);
		echo $cs_lang['gallery_count_reset'];
		echo cs_html_br(1);
		echo cs_html_vote('usersgallery_close','1','checkbox',$edit['usersgallery_close']);
		echo $cs_lang['gallery_close'];
		echo cs_html_roco(0);

		echo cs_html_roco(1,'leftc');
		echo cs_icon('ksysguard') . $cs_lang['options'];
		echo cs_html_roco(2,'leftb',0,2);
		echo cs_html_vote('id',$gallery_id,'hidden');
		echo cs_html_vote('submit',$cs_lang['save'],'submit');
		echo cs_html_vote('reset',$cs_lang['reset'],'reset');
		echo cs_html_roco(0);
		echo cs_html_table(0);
		echo cs_html_form (0);
	}
?>