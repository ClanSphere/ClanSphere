<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');
$option = cs_sql_option(__FILE__,'categories');
$option2 = cs_sql_option(__FILE__,'gallery');
require_once('mods/usersgallery/functions.php');

$advance = 1;

$img_filetypes = array('gif','jpg','png');
$id = $account['users_id'];
$count = cs_sql_count(__FILE__, 'folders',"folders_mod='usersgallery' AND users_id='".$id."'");
if($count >= $option2['max_folders']) {
	cs_redirect($cs_lang['max_folders'],'usersgallery','center','page=cat');
} else {
	if(isset($_POST['submit'])) {
		$error = 0;
		$message = '';

		$folders['users_id'] = $id;
    $folders['sub_id'] = isset($_POST['sub_id']) ? $_POST['sub_id'] : 0;
		$folders['folders_mod'] = 'usersgallery';
		$folders['folders_name'] = $_POST['folders_name'];
		$folders['folders_url'] = $_POST['folders_url'];
		$folders['folders_text'] = $_POST['folders_text'];
		$folders['folders_access'] = $_POST['folders_access'];
		$folders['folders_position'] = $_POST['folders_position'];
		$advance = isset($_POST['advance-']) ? 0 : 1;
		$advance = isset($_POST['advance+']) ? 1 : 0;
		if(!isset($_POST['advance+']) AND !isset($_POST['advance-'])) {
			$advance = isset($_POST['advance']) ? $_POST['advance'] : 0;
		}
		if(isset($_POST['advance-']) OR isset($_POST['advance+'])) {
			$error++;
			$message .= $cs_lang['body_folder'] . cs_html_br(1);
		}
		if(isset($_FILES['picture']))
		{
			$img_size = getimagesize($_FILES['picture']['tmp_name']);
			if(!empty($_FILES['picture']['tmp_name']) AND empty($img_size) OR $img_size[2] > 3) {
				$message .= $cs_lang['ext_error'] . cs_html_br(1);
				$error++;
			} elseif(!empty($_FILES['picture']['tmp_name'])) {
				switch($img_size[2]) {
					case 1:
						$extension = 'gif'; break;
					case 2:
						$extension = 'jpg'; break;
					case 3:
						$extension = 'png'; break;
				}
				if($img_size[0]>$option['max_width']) {
					$message .= $cs_lang['too_wide'] . cs_html_br(1);
					$error++;
				}
				if($img_size[1]>$option['max_height']) {
					$message .= $cs_lang['too_high'] . cs_html_br(1);
					$error++;
				}
				if($_FILES['picture']['size']>$option['max_size']) {
					$message .= $cs_lang['too_big'] . cs_html_br(1);
					$error++;
				}
			}
		}
		if(empty($folders['folders_name'])) {
			$error++;
			$message .= $cs_lang['no_titel'] . cs_html_br(1);
		}
		$where = "folders_name = '" . cs_sql_escape($folders['folders_name']) . "'";
		$where .= " AND folders_mod = 'usersgallery' AND users_id='" . $account['users_id'] . "'";
		$search = cs_sql_count(__FILE__,'folders',$where);
		if(!empty($search)) {
			$error++;
			$message .= $cs_lang['cat_exists'] . cs_html_br(1);
		}
	} else {
		$folders['sub_id'] = '';
		$folders['folders_name'] = '';
		$folders['folders_mod'] = 'usersgallery';
		$folders['folders_url'] = '';
		$folders['folders_text'] = '';
		$folders['folders_access'] = 0;
		$folders['folders_position'] = 1;
	}
	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'headb');
	echo $cs_lang['mod'] . ' - ' . $cs_lang['folders_create'];
	echo cs_html_roco(0);
	echo cs_html_roco(1,'leftc');
	if(!isset($_POST['submit'])) {
		echo $cs_lang['body_folder'];
	} elseif(!empty($error)) {
		echo $message;
	} else {
		echo $cs_lang['create_done'];
	}
	echo cs_html_roco(0);
	echo cs_html_table(0);
	echo cs_html_br(1);

	if(!empty($error) OR !isset($_POST['submit'])) {
		echo cs_html_form(1,'folders_create','usersgallery','folders_create',1);
		echo cs_html_table(1,'forum',1);
		echo cs_html_roco(1,'leftc');
		echo cs_icon('folder_yellow') . $cs_lang['name'] . ' *';
		echo cs_html_roco(2,'leftb');
		echo cs_html_input('folders_name',$folders['folders_name'],'text',80,40);
		echo cs_html_roco(0);
		if($advance == '1') {
			echo cs_html_roco(1,'leftc');
			echo cs_icon('kcmdf') . $cs_lang['sub_folder'];
			echo cs_html_roco(2,'leftb');
			echo make_folders_select('sub_id',$folders['sub_id'],$id,'usersgallery');
			echo cs_html_roco(0);

			echo cs_html_roco(1,'leftc');
			echo cs_icon('enumList') . $cs_lang['position'];
			echo cs_html_roco(2,'leftb');
			echo cs_html_input('folders_position',$folders['folders_position'],'text',80,40);
			echo cs_html_roco(0);

			echo cs_html_roco(1,'leftc');
			echo cs_icon('access') . $cs_lang['needed_access'];
			echo cs_html_roco(2,'leftb',0,2);
			echo cs_html_select(1,'folders_access');
			$levels = 0;
			$sel = 0;
			while($levels < 6) {
				$folders['folders_access'] == $levels ? $sel = 1 : $sel = 0;
				echo cs_html_option($levels . ' - ' . $cs_lang['lev_' . $levels],$levels,$sel);
				$levels++;
			}
			echo cs_html_select(0);
			echo cs_html_roco(0);

			echo cs_html_roco(1,'leftc');
			echo cs_icon('gohome') . $cs_lang['url'];
			echo cs_html_roco(2,'leftb',0,2);
			echo 'http://' . cs_html_input('folders_url',$folders['folders_url'],'text',80,50);
			echo cs_html_roco(0);
		}
		echo cs_html_roco(1,'leftc');
		echo cs_icon('kate') . $cs_lang['text'];
		echo cs_html_br(2);
	//	echo cs_abcode_smileys('folders_text');
		echo cs_html_roco(2,'leftb');
	//	echo cs_abcode_features('folders_text');
		echo cs_html_textarea('folders_text',$folders['folders_text'],'50','3');
		echo cs_html_roco(0);
		if($advance == '1') {
			echo cs_html_roco(1,'leftc');
			echo cs_icon('download') . $cs_lang['pic_up'];
			echo cs_html_roco(2,'leftb');
			echo cs_html_input('picture','','file');
			echo cs_html_br(2);
			$matches[1] = $cs_lang['pic_infos'];
			$return_types = '';
			foreach($img_filetypes AS $add) {
				$return_types .= empty($return_types) ? $add : ', ' . $add;
			}
			$matches[2] = $cs_lang['max_width'] . $option['max_width'] . ' px' . cs_html_br(1);
			$matches[2] .= $cs_lang['max_height'] . $option['max_height'] . ' px' . cs_html_br(1);
			$matches[2] .= $cs_lang['max_size'] . cs_filesize($option['max_size']) . cs_html_br(1);
			$matches[2] .= $cs_lang['filetypes'] . $return_types;
			echo cs_abcode_clip($matches);
			echo cs_html_roco(0);
		}
		echo cs_html_roco(1,'leftc');
		echo cs_icon('ksysguard') . $cs_lang['options'];
		echo cs_html_roco(2,'leftb');
		if($advance == '0') {
			echo cs_html_vote('sub_id',$folders['sub_id'],'hidden');
			echo cs_html_vote('folders_position',$folders['folders_position'],'hidden');
			echo cs_html_vote('folders_url',$folders['folders_url'],'hidden');
			echo cs_html_vote('folders_access',$folders['folders_access'],'hidden');
			echo cs_html_vote('picture','','hidden');
		}
		echo cs_html_vote('advance',$advance,'hidden');
		echo cs_html_vote('submit',$cs_lang['create'],'submit');
		echo cs_html_vote('reset',$cs_lang['reset'],'reset');
		if($advance == '1') {
			echo cs_html_vote('submit',$advance,'hidden');
			echo cs_html_vote('advance-',$cs_lang['head'],'submit');
		} else {
			echo cs_html_vote('submit',$advance,'hidden');
			echo cs_html_vote('advance+',$cs_lang['head'],'submit');
		}
		echo cs_html_roco(0);
		echo cs_html_table(0);
		echo cs_html_form(0);
	}
  else {

    settype($folders['sub_id'], 'integer');
		$folder_cells = array_keys($folders);
		$folder_save = array_values($folders);
		cs_sql_insert(__FILE__,'folders',$folder_cells,$folder_save);
		if(!empty($_FILES['picture']['tmp_name'])) {
			$where = "folders_name = '" . cs_sql_escape($folders['folders_name']) . "' AND ";
			$where .= "users_id = '" . $id . "'";
			$getid = cs_sql_select(__FILE__,'folders','folders_id',$where);
			$filename = 'picture-' . $getid['folders_id'] . '.' . $extension;
			cs_upload('folders',$filename,$_FILES['picture']['tmp_name']);

			$folders2['folders_picture'] = $filename;
			$cells = array_keys($folders2);
			$save = array_values($folders2);
			cs_sql_update(__FILE__,'folders',$cells,$save,$getid['folders_id']);
		}

		cs_redirect($cs_lang['create_done'],'usersgallery','center','page=cat');
	}
}

?>