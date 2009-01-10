<?php

// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');

require_once('mods/categories/functions.php');

$gallery_id = $_REQUEST['id'];
settype($gallery_id,'integer');

$gallery_edit = cs_sql_select(__FILE__,'gallery','*',"gallery_id = '" . $gallery_id . "'");
$gallery_comment = $gallery_edit['gallery_description'];
$gallery_titel = $gallery_edit['gallery_titel'];
$cat_id = $gallery_edit['categories_id'];
$user_gallery_id = $gallery_edit['gallery_access'];
$picture = $gallery_edit['gallery_id'];
$show = $gallery_edit['gallery_status'];
$vote_endi = $gallery_edit['gallery_vote'];
$gallery_close = $gallery_edit['gallery_close'];

$download = $gallery_edit['gallery_download'];
$temp = explode("|--@--|", $download);
$download_endi = $temp[0];
$watermark_vote = $temp[1];

$gallery_count = $gallery_edit['gallery_count'];
$gallery_watermark = $gallery_edit['gallery_watermark'];

$watermark_pos = $gallery_edit['gallery_watermark_pos'];
$temp = explode("|--@--|", $watermark_pos);
$watermark_pos = $temp[0];
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



$time = $gallery_edit['gallery_time'];
$gallery_form = 1; 
$gallery_error = 3;
$message = '';

	echo cs_html_form (1,'gallery_pic','gallery','edit',1);
	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'headb');
	echo $cs_lang['mod'] . ' - ' . $cs_lang['edit'];
	echo cs_html_roco(0);
	echo cs_html_roco(1,'leftb');
	echo $cs_lang['body_edit'];
	echo cs_html_roco(0);

if(isset($_POST['submit'])) {

  
	if(!empty($_POST['gallery_titel'])) 
	{
		$gallery_titel = $_POST['gallery_titel'];
		$gallery_error--;
	}
	else
	{
		$message .= $cs_lang['no_titel'] . cs_html_br(1);
	}
  	$cat_id = empty($_POST['categories_name']) ? $_POST['categories_id'] : 
	cs_categories_create('gallery',$_POST['categories_name']);
	if(!empty($cat_id)) 
	{
		$cat_id = $_POST['categories_id'];
		$gallery_error--;
	}
	else
	{
		$message .= $cs_lang['no_cat'] . cs_html_br(1);
	}
	
	if(!empty($_POST['vote_endi'])) 
	{
		$vote_endi = $_POST['vote_endi'];
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
		$time = cs_time();
	}
	
	if(!empty($_POST['gallery_count_reset'])) 
	{
		$gallery_count = 0;
	}
	
	if(!empty($_POST['user_gallery_id'])) {
		$user_gallery_id = $_POST['user_gallery_id'];
	}
	
	if(!empty($_POST['show'])) {
		$show = $_POST['show'];
	}
	else
	{	
		$show = '0';
	}
	
	if(!empty($_POST['gallery_comment'])) {
		$gallery_comment = $_POST['gallery_comment'];
		$gallery_error--;
	}
	else
	{
		$message .= $cs_lang['no_comment'] . cs_html_br(1);
	}
	$gallery_close = isset($_POST['gallery_close']) ? $_POST['gallery_close'] : 0;

if(empty($gallery_error)) {
		$gallery_form = 0;
		$gallery_cells = array('gallery_titel','categories_id','gallery_access','gallery_status','gallery_description','gallery_time','gallery_vote','gallery_download','gallery_count','gallery_watermark','gallery_watermark_pos','gallery_close');
		$gallery_save = array($gallery_titel,$cat_id,$user_gallery_id,$show,$gallery_comment,$time,$vote_endi,$download,$gallery_count,$watermark,$watermark_pos,$gallery_close);
		cs_sql_update(__FILE__,'gallery',$gallery_cells,$gallery_save,$gallery_id);
		
		cs_redirect($cs_lang['changes_done'], 'gallery') ;
		
	}
		
        } else {
        $fileerror=1;
       }
      

	if(!empty($message)) {
		echo cs_html_roco(1,'leftb');
		echo cs_icon('important');
    	echo $cs_lang['error'];
		echo cs_html_roco(0);
		echo cs_html_roco(1,'leftb');
    	echo $message;
		echo cs_html_roco(0);

	}

		echo cs_html_table(0);
		echo cs_html_form (0);
		echo cs_html_br(1);

	if(!empty($gallery_form)) {

		echo cs_html_form (1,'gallery_pic','gallery','edit',1);
		echo cs_html_table(1,'forum',1);
		echo cs_html_roco(1,'leftc');
		echo cs_icon('download') . $cs_lang['upload'];
		echo cs_html_roco(2,'leftb',0,2);
		echo cs_html_img('mods/gallery/image.php?thumb=' . $picture);
		echo cs_html_roco(0);

		echo cs_html_roco(1,'leftc');
		echo cs_icon('kedit') . $cs_lang['titel'];
		echo cs_html_roco(2,'leftb',0,2);
		echo cs_html_input('gallery_titel',$gallery_titel,'text',200,42);
		echo cs_html_roco(0);
	
		echo cs_html_roco(1,'leftc');
		echo cs_icon('folder_yellow') . $cs_lang['category'];
		echo cs_html_roco(2,'leftb',0,2);
		echo cs_categories_dropdown('gallery',$cat_id);
  		echo cs_html_roco(0);
	
		echo cs_html_roco(1,'leftc');
		echo cs_icon('access') . $cs_lang['user_gallery_id'];
		echo cs_html_roco(2,'leftb',0,2);
		echo cs_html_select(1,'user_gallery_id');
		$levels = 0;
      	while($levels < 6) 
		{
			$user_gallery_id == $levels ? $sel = 1 : $sel = 0;
			echo cs_html_option($levels . ' - ' . $cs_lang['lev_' . $levels],$levels,$sel);
			$levels++;
		}	 
    	echo cs_html_select(0);	
		echo cs_html_roco(0);

		echo cs_html_roco(1,'leftc');
		echo cs_icon('xpaint') . $cs_lang['show'];
		echo cs_html_roco(2,'leftb',0,2);
		echo cs_html_select(1,'show');
		$levels = 0;
    	while($levels < 2) 
		{
			$show == $levels ? $sel = 1 : $sel = 0;
			echo cs_html_option($levels . ' - ' . $cs_lang['show_' . $levels],$levels,$sel);
			$levels++;
		}	 
    	echo cs_html_select(0);	
		echo cs_html_roco(0);
		
		if(extension_loaded('gd'))
		{
			echo cs_html_roco(1,'leftc',2);
			echo cs_icon('xpaint') . $cs_lang['watermark'];
			echo cs_html_roco(2,'leftb',0,2);
			$no_watermark = $cs_lang['no_watermark'];
			$no_cat_data_watermark = array('0' => array('categories_id' => '', 'categories_mod' => 'gallery-watermark', 'categories_name' => $no_watermark, 'categories_picture' => ''));
			$cat_data_watermark_1 = cs_sql_select(__FILE__,'categories','*',"categories_mod = 'gallery-watermark'",'categories_name',0,0);
			if(empty($cat_data_watermark_1))
			{
				$cat_data_watermark = $no_cat_data_watermark;
			}
			else
			{
				$cat_data_watermark = array_merge ($no_cat_data_watermark, $cat_data_watermark_1);
			}
			$search_value = $gallery_watermark;
			if(!empty($search_value))
			{
				foreach ($cat_data_watermark as $key => $row)
				{
					foreach($row as $cell)
					{
						if (strpos($cell, $search_value) !== FALSE)
						{
							$watermark_id = $key;
						}
					}
				}
			}
			$el_id = 'watermark_1';
			$onc = "document.getElementById('" . $el_id . "').src='" . $cs_main['php_self']['dirname'] . "uploads/categories/' + this.form.";
			$onc .= "watermark.options[this.form.watermark.selectedIndex].value";
			echo cs_html_select(1,'watermark',"onchange=\"" . $onc . "\"");
			foreach ($cat_data_watermark as $data) 
			{
				$data['categories_picture'] == $gallery_watermark ? $sel = 1 : $sel = 0;
				echo cs_html_option($data['categories_name'],$data['categories_picture'],$sel);
			}
			echo cs_html_select(0) . ' ';
			if(!empty($watermark_id))
			{
				$url = 'uploads/categories/' . $cat_data_watermark[$watermark_id]['categories_picture'];
			}
			else
			{
				$url = 'symbols/gallery/nowatermark.png';
			}
			echo cs_html_img($url,'','','id="' . $el_id . '"');
			echo cs_html_roco(0);
		
			echo cs_html_roco(2,'leftb');
			echo cs_html_select(1,'watermark_pos');
			$levels = 1;
			while($levels < 10) 
			{
				$watermark_pos == $levels ? $sel = 1 : $sel = 0;
				echo cs_html_option($levels . ' - ' . $cs_lang['watermark_' . $levels],$levels,$sel);
				$levels++;
			}	 
			echo cs_html_select(0);	
			echo cs_html_roco(3,'leftb');
			echo $cs_lang['wm_trans'];
			echo cs_html_input('gallery_watermark_trans',$gallery_watermark_trans,'text',2,2);
			echo '%';
			echo cs_html_roco(0);
		}
		
		echo cs_html_roco(1,'leftc');
		echo cs_icon('kate') . $cs_lang['comment'];
 		echo cs_html_br(2);
 		echo cs_abcode_smileys('gallery_comment');
		echo cs_html_roco(2,'leftb',0,2);
		echo cs_abcode_features('gallery_comment');
		echo cs_html_textarea('gallery_comment',$gallery_comment,'50','15');
		echo cs_html_roco(0);
		
		echo cs_html_roco(1,'leftc');
		echo cs_icon('configure') . $cs_lang['more'];
		echo cs_html_roco(2,'leftb',0,2);
		echo cs_html_vote('vote_endi','1','checkbox',$vote_endi);
		echo $cs_lang['vote_endi'];
		echo cs_html_br(1);
		echo cs_html_vote('download_endi','1','checkbox',$download_endi);
		echo $cs_lang['download_endi'];
		echo cs_html_br(1);
		echo cs_html_vote('watermark_vote','1','checkbox',$watermark_vote);
		echo $cs_lang['watermark_vote'];
		echo cs_html_br(1);
		echo cs_html_vote('new_time','1','checkbox',$new_time);
		echo $cs_lang['new_date'];
		echo cs_html_br(1);
		echo cs_html_vote('gallery_count_reset','1','checkbox',$gallery_count_reset);
		echo $cs_lang['gallery_count_reset'];
		echo cs_html_br(1);
		echo cs_html_vote('gallery_close','1','checkbox',$gallery_close);
		echo $cs_lang['gallery_close'];
		echo cs_html_roco(0);

		echo cs_html_roco(1,'leftc');
		echo cs_icon('ksysguard') . $cs_lang['options'];
		echo cs_html_roco(2,'leftb',0,2);
		echo cs_html_vote('id',$gallery_id,'hidden');
		echo cs_html_vote('submit',$cs_lang['submit'],'submit');
		echo cs_html_vote('reset',$cs_lang['reset'],'reset');
		echo cs_html_roco(0);
		echo cs_html_table(0);
		echo cs_html_form (0);
	}
?>