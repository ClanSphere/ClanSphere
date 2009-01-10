<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('categories');

$op_categories = cs_sql_option(__FILE__,'categories');
$img_filetypes = array('gif','jpg','png');

if(isset($_POST['submit'])) {

  $cs_categories['categories_name'] = $_POST['categories_name'];
  $cs_categories['categories_mod'] = $_POST['categories_mod'];
  $cs_categories['categories_url'] = $_POST['categories_url'];
  $cs_categories['categories_text'] = $_POST['categories_text'];
  $cs_categories['categories_access'] = $_POST['categories_access'];
  $cs_categories['categories_order'] = $_POST['categories_order'];
  $cs_categories['categories_subid'] = (int) $_POST['categories_id'];
  
	$error = 0;
  $message = '';

  $img_size = getimagesize($_FILES['picture']['tmp_name']);
  if(!empty($_FILES['picture']['tmp_name']) AND empty($img_size) OR $img_size[2] > 3) {

    $message .= $cs_lang['ext_error'] . cs_html_br(1);
		$error++;
  }
  elseif(!empty($_FILES['picture']['tmp_name'])) {

    switch($img_size[2]) {
    case 1:
      $extension = 'gif'; break;
    case 2:
      $extension = 'jpg'; break;
    case 3:
      $extension = 'png'; break;
    }
    
    if($img_size[0]>$op_categories['max_width']) {
  
  		$message .= $cs_lang['too_wide'] . cs_html_br(1);
  		$error++;
    }
    if($img_size[1]>$op_categories['max_height']) { 
  
  		$message .= $cs_lang['too_high'] . cs_html_br(1);
  		$error++;
    }
    if($_FILES['picture']['size']>$op_categories['max_size']) { 
  
  		$message .= $cs_lang['too_big'] . cs_html_br(1);
  		$error++;
    }
	}

  if(empty($cs_categories['categories_name'])) {
    $error++;
    $message .= $cs_lang['no_name'] . cs_html_br(1);
  }
  
  $where = "categories_name = '" . cs_sql_escape($cs_categories['categories_name']) . "'";
	$where .= " AND categories_mod = '" . cs_sql_escape($cs_categories['categories_mod']) . "'";
  $search = cs_sql_count(__FILE__,'categories',$where);
  if(!empty($search)) {
    $error++;
    $message .= $cs_lang['cat_exists'] . cs_html_br(1);
  }
}
else {
  $cs_categories['categories_name'] = '';
  $cs_categories['categories_mod'] = empty($_REQUEST['where']) ? $op_categories['def_mod'] : $_REQUEST['where'];
  $cs_categories['categories_url'] = '';
  $cs_categories['categories_text'] = '';
  $cs_categories['categories_order'] = 0;
  $cs_categories['categories_access'] = 0;
  $cs_categories['categories_subid'] = 0;
}

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['create'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc');
if(!isset($_POST['submit'])) {
  echo $cs_lang['body_create'];
}
elseif(!empty($error)) {
  echo $message;
}
else {
  echo $cs_lang['create_done'];
}
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

if(!empty($error) OR !isset($_POST['submit'])) {
  
  include 'mods/categories/functions.php';

  echo cs_html_form(1,'categories_create','categories','create',1);
  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'leftc');
	echo cs_icon('folder_yellow') . $cs_lang['name'] . ' *';
	echo cs_html_roco(2,'leftb');
  echo cs_html_input('categories_name',$cs_categories['categories_name'],'text',80,40);
  echo cs_html_roco(0);
  
  echo cs_html_roco(1,'leftc');
  echo cs_icon('add_sub_task') . $cs_lang['subcat_of'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_div(1,0,'id="cat_dropdown"');
  echo cs_categories_dropdown2($cs_categories['categories_mod'],$cs_categories['categories_subid'],0);
  echo cs_html_div(0);
  echo cs_html_roco(0);
  
  echo cs_html_roco(1,'leftc');
  echo cs_icon('kcmdf') . $cs_lang['modul'] . ' *';
  echo cs_html_roco(2,'leftb');
	echo cs_html_select(1,'categories_mod','onchange="javascript: cs_ajax_getcontent(\'mods/categories/getcats.php?mod=\'+this.value,\'cat_dropdown\')"');
	$modules = cs_checkdirs('mods');
	foreach($modules as $mods) {
    $check_axx = empty($account['access_' . $mods['dir'] . '']) ? 0 : $account['access_' . $mods['dir'] . ''];
		if(!empty($mods['categories']) AND $check_axx > 2) {
  		$mods['dir'] == $cs_categories['categories_mod'] ? $sel = 1 : $sel = 0;
  		echo cs_html_option($mods['name'],$mods['dir'],$sel);
		}
	}
	echo cs_html_select(0);
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
  echo cs_icon('download') . $cs_lang['pic_up'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('picture','','file');
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
  echo cs_icon('ksysguard') . $cs_lang['options'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_vote('submit',$cs_lang['create'],'submit');
  echo cs_html_vote('reset',$cs_lang['reset'],'reset');
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_form(0);
}
else {

  $categories_cells = array_keys($cs_categories);
  $categories_save = array_values($cs_categories);
  cs_sql_insert(__FILE__,'categories',$categories_cells,$categories_save);

	if(!empty($_FILES['picture']['tmp_name'])) {
  	$where = "categories_name = '" . cs_sql_escape($cs_categories['categories_name']) . "'";
  	$getid = cs_sql_select(__FILE__,'categories','categories_id',$where);
		$filename = 'picture-' . $getid['categories_id'] . '.' . $extension;
  	cs_upload('categories',$filename,$_FILES['picture']['tmp_name']);
		
		$cs_categories2['categories_picture'] = $filename;
	  $categories2_cells = array_keys($cs_categories2);
		$categories2_save = array_values($cs_categories2);			
		cs_sql_update(__FILE__,'categories',$categories2_cells,$categories2_save,$getid['categories_id']);
  }
	
	cs_redirect($cs_lang['create_done'],'categories','manage','where=' . $cs_categories['categories_mod']);
}

?>