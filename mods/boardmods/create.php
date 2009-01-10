<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('boardmods');
require_once('mods/categories/functions.php');

$data = array();

if(isset($_POST['submit'])) {

  $data['bm']['categories_id'] = empty($_POST['categories_id']) ? cs_categories_create('boardmods',$_POST['categories_name']) 
		: (int) $_POST['categories_id'];

  $data['bm']['boardmods_modpanel'] = isset($_POST['boardmods_modpanel']) ? $_POST['boardmods_modpanel'] : 0;
  $data['bm']['boardmods_edit'] = isset($_POST['boardmods_edit']) ? $_POST['boardmods_edit'] : 0;
  $data['bm']['boardmods_del'] = isset($_POST['boardmods_del']) ? $_POST['boardmods_del'] : 0;
  $data['bm']['users_id'] = $_POST['users_id'];
	
  $error = 0;
  $errormsg = '';

  if(empty($data['bm']['categories_id'])) {
    $error++;
    $errormsg .= $cs_lang['no_cat'] . cs_html_br(1);
  }
  if(empty($data['bm']['users_id'])) {
    $error++;
    $errormsg .= $cs_lang['no_user'] . cs_html_br(1);
  }
  $check = "users_id = '" . $data['bm']['users_id'] . "'";
  $find_user = cs_sql_select(__FILE__,'boardmods','users_id',$check,0,0);
  if(!empty($find_user)) {
	$error++;
	$errormsg .= $cs_lang['user_exists'] . cs_html_br(1);
  }

} else {
	$data['bm']['boardmods_modpanel'] = 0;
	$data['bm']['boardmods_edit'] = 0;
	$data['bm']['boardmods_del'] = 0;
	$data['bm']['users_id'] = '';
}

if(!isset($_POST['submit']) AND empty($error)) {
  $data['head']['body'] = $cs_lang['body'];
}
elseif(!empty($error)) {
  $data['head']['body'] = $errormsg;
}

if(!empty($error) OR !isset($_POST['submit'])) {

	$categories_id = empty($_POST['categories_id']) ? 0 : $_POST['categories_id'];
	$data['bm']['cat_dropdown'] = cs_categories_dropdown('boardmods',$categories_id);
	
	$users = cs_sql_select(__FILE__,'users','users_nick, users_id',0,'users_nick ASC',0,0);
	$data['bm']['users_dropdown'] = cs_dropdown('users_id','users_nick',$users,$data['bm']['users_id']);
	
	$data['bm']['boardmods_modpanel'] = $data['bm']['boardmods_modpanel'] == 1 ? 'checked="checked"' : '';
	$data['bm']['boardmods_edit'] = $data['bm']['boardmods_edit'] == 1 ? 'checked="checked"' : '';
	$data['bm']['boardmods_del'] = $data['bm']['boardmods_del'] == 1 ? 'checked="checked"' : '';

} else {
	
	$boardmods_cells = array_keys($data['bm']);
	$boardmods_save = array_values($data['bm']);
	cs_sql_insert(__FILE__,'boardmods',$boardmods_cells,$boardmods_save);
	
    cs_redirect($cs_lang['create_done'],'boardmods');
} 
	echo cs_subtemplate(__FILE__,$data,'boardmods','create');

?>
