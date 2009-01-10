<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('categories');

$categories_id = (int) $_REQUEST['id'];
$op_categories = cs_sql_option(__FILE__,'categories');
$img_filetypes = array('gif','jpg','png');
$files = cs_files();

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['edit'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');

if(isset($_POST['submit'])) {

  $cs_categories['categories_name'] = $_POST['categories_name'];
  $cs_categories['categories_url'] = $_POST['categories_url'];
  $cs_categories['categories_text'] = $_POST['categories_text'];
  $cs_categories['categories_access'] = $_POST['categories_access'];
  $cs_categories['categories_picture'] = $_POST['categories_picture'];
  $cs_categories['categories_order'] = $_POST['categories_order'];
  $cs_categories['categories_subid'] = (int) $_POST['categories_id'];
  
  $error = 0;
  $message = '';

	if(isset($_POST['delete']) AND $_POST['delete'] == TRUE AND !empty($cs_categories['categories_picture'])) {
		cs_unlink('categories', $cs_categories['categories_picture']);
		$cs_categories['categories_picture'] = '';
	}

  $img_size = getimagesize($files['picture']['tmp_name']);
  if(!empty($files['picture']['tmp_name']) AND empty($img_size) OR $img_size[2] > 3) {

    $message .= $cs_lang['ext_error'] . cs_html_br(1);
		$error++;
  }
  elseif(!empty($files['picture']['tmp_name'])) {

    switch($img_size[2]) {
    case 1:
      $ext = 'gif'; break;
    case 2:
      $ext = 'jpg'; break;
    case 3:
      $ext = 'png'; break;
    }
    $filename = 'picture-' . $categories_id . '.' . $ext;
    
    if($img_size[0]>$op_categories['max_width']) {
  
  		$message .= $cs_lang['too_wide'] . cs_html_br(1);
  		$error++;
    }
    if($img_size[1]>$op_categories['max_height']) { 
  
  		$message .= $cs_lang['too_high'] . cs_html_br(1);
  		$error++;
    }
    if($files['picture']['size']>$op_categories['max_size']) { 
  
  		$message .= $cs_lang['too_big'] . cs_html_br(1);
  		$error++;
    }
    if(empty($error) AND cs_upload('categories', $filename, $files['picture']['tmp_name']) OR !empty($error) AND extension_loaded('gd') AND cs_resample($files['picture']['tmp_name'], 'uploads/categories/' . $filename, $op_categories['max_width'], $op_categories['max_height'])) {
      $error = 0;
      $message = '';
      if($cs_categories['categories_picture'] != $filename AND !empty($cs_categories['categories_picture'])) {
        cs_unlink('categories', $cs_categories['categories_picture']);
      }
			$cs_categories['categories_picture'] = $filename;
    }
    else {
        $message .= $cs_lang['up_error'];
        $error++;
    }
  }

  if(empty($cs_categories['categories_name'])) {
    $error++;
    $message .= $cs_lang['no_name'] . cs_html_br(1);
  }
  
  $where = "categories_name = '" . cs_sql_escape($cs_categories['categories_name']) . "'";
	$where .= " AND categories_mod = '" . cs_sql_escape($_POST['cat_mod']) . "'";
  $where .= " AND categories_id != '" . $categories_id . "'";
  $search = cs_sql_count(__FILE__,'categories',$where);
  if(!empty($search)) {
    $error++;
    $message .= $cs_lang['cat_exists'] . cs_html_br(1);
  }
}
else {
  $cs_categories = cs_sql_select(__FILE__,'categories','*',"categories_id = '" . $categories_id . "'");
}
if(!isset($_POST['submit'])) {
  echo $cs_lang['body_edit'];
}
elseif(!empty($error)) {
  echo $message;
}

echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

if(!empty($error) OR !isset($_POST['submit'])) {
  
  include 'mods/categories/functions.php';

  echo cs_html_form (1,'categories_edit','categories','edit',1);
  echo cs_html_table(1,'forum',1);
  
  echo cs_html_roco(1,'leftc');
	echo cs_icon('folder_yellow') . $cs_lang['name'] . ' *';
	echo cs_html_roco(2,'leftb');
  echo cs_html_input('categories_name',$cs_categories['categories_name'],'text',80,40);
  echo cs_html_roco(0);
  
  $cat_mod = empty($_POST['cat_mod']) ? $cs_categories['categories_mod'] : $_POST['cat_mod'];
  
  echo cs_html_roco(1,'leftc');
  echo cs_icon('add_sub_task') . $cs_lang['subcat_of'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_div(1,0,'id="cat_dropdown"');
  echo cs_categories_dropdown2($cat_mod,$cs_categories['categories_subid'],0);
  echo cs_html_div(0);
  echo cs_html_roco(0);
  
  echo cs_html_roco(1,'leftc');
  echo cs_icon('kcmdf') . $cs_lang['modul'] . ' *';
  echo cs_html_roco(2,'leftb');
	
	$modules = cs_checkdirs('mods');
	foreach($modules as $mods) {
		if($mods['dir'] == $cat_mod) {
  		echo $mods['name'];
  		break;
		}
	}
	echo cs_html_vote('cat_mod',$cat_mod,'hidden');
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('access') . $cs_lang['needed_access'];
  echo cs_html_roco(2,'leftb',0,2);
	echo cs_html_select(1,'categories_access');
	$levels = 0;
	$sel = 0;
	while($levels < 6) {
		$cs_categories['categories_access'] == $levels ? $sel = 1 : $sel = 0;
		echo cs_html_option($levels . ' - ' . $cs_lang['lev_' . $levels],$levels,$sel);
		$levels++;
	}
	echo cs_html_select(0);
  echo cs_html_roco(0);
	
	echo cs_html_roco(1,'leftc');
  echo cs_icon('gohome') . $cs_lang['url'];
  echo cs_html_roco(2,'leftb',0,2);
  echo 'http://' . cs_html_input('categories_url',$cs_categories['categories_url'],'text',80,50);
  echo cs_html_roco(0);
	
	echo cs_html_roco(1,'leftc');
  echo cs_icon('kate') . $cs_lang['text'];
  echo cs_html_br(2);
  echo cs_abcode_smileys('categories_text');
  echo cs_html_roco(2,'leftb');
  echo cs_abcode_features('categories_text');
  echo cs_html_textarea('categories_text',$cs_categories['categories_text'],'50','8');
  echo cs_html_roco(0);
  
  echo cs_html_roco(1,'leftc');
  echo cs_icon('enumList') . $cs_lang['priority'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('categories_order',$cs_categories['categories_order'],'text',2,2);
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('images') . $cs_lang['pic_current'];
  echo cs_html_roco(2,'leftb');
  if(empty($cs_categories['categories_picture'])) {
    echo $cs_lang['nopic'];
  }
  else {
		$place = 'uploads/categories/' . $cs_categories['categories_picture'];
    $size = getimagesize($cs_main['def_path'] . '/' . $place);
    echo cs_html_img($place,$size[1],$size[0]);
  }
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('download') . $cs_lang['pic_up'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('picture','','file');
	echo cs_html_vote('categories_picture',$cs_categories['categories_picture'],'hidden');
	echo cs_html_br(2);
	$matches[1] = $cs_lang['pic_infos'];
	$return_types = '';
	foreach($img_filetypes AS $add) {
		$return_types .= empty($return_types) ? $add : ', ' . $add;
	}
	$matches[2] = $cs_lang['max_width'] . $op_categories['max_width'] . ' px' . cs_html_br(1);
	$matches[2] .= $cs_lang['max_height'] . $op_categories['max_height'] . ' px' . cs_html_br(1);
	$matches[2] .= $cs_lang['max_size'] . cs_filesize($op_categories['max_size']) . cs_html_br(1);
	$matches[2] .= $cs_lang['filetypes'] . $return_types;
	echo cs_abcode_clip($matches);
  echo cs_html_roco(0);
	
	echo cs_html_roco(1,'leftc');
	echo cs_icon('configure') . $cs_lang['more'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_vote('delete','1','checkbox');
	echo $cs_lang['pic_remove'];
	echo cs_html_roco(0);
  
  echo cs_html_roco(1,'leftc');
  echo cs_icon('ksysguard') . $cs_lang['options'];
  echo cs_html_roco(2,'leftb');
	echo cs_html_vote('id',$categories_id,'hidden');
  echo cs_html_vote('submit',$cs_lang['edit'],'submit');
  echo cs_html_vote('reset',$cs_lang['reset'],'reset');
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_form(0);
}
else {

  $categories_cells = array_keys($cs_categories);
  $categories_save = array_values($cs_categories);
  cs_sql_update(__FILE__,'categories',$categories_cells,$categories_save,$categories_id);
  
    cs_redirect($cs_lang['changes_done'], 'categories') ;
} 
  
?>
