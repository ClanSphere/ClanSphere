<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('boardmods');
require_once('mods/categories/functions.php');

$data = array(); 

if(isset($_POST['submit'])) {

  $cs_bm['categories_id'] = empty($_POST['categories_id']) ? cs_categories_create('boardmods',$_POST['categories_name']) 
    : (int) $_POST['categories_id'];

  $cs_bm['boardmods_modpanel'] = isset($_POST['boardmods_modpanel']) ? $_POST['boardmods_modpanel'] : 0;
  $cs_bm['boardmods_edit'] = isset($_POST['boardmods_edit']) ? $_POST['boardmods_edit'] : 0;
  $cs_bm['boardmods_del'] = isset($_POST['boardmods_del']) ? $_POST['boardmods_del'] : 0;
  
  $error = 0;
  $errormsg = '';

  if(empty($cs_bm['categories_id'])) {
    $error++;
    $errormsg .= $cs_lang['no_cat'] . cs_html_br(1);
  }

} else {
  $boardmods_id = $_GET['id'];
  $tables = 'boardmods brd INNER JOIN {pre}_users usr ON usr.users_id = brd.users_id';
  $cells  = 'brd.boardmods_id AS boardmods_id, brd.categories_id AS categories_id, brd.users_id AS users_id, usr.users_nick AS users_nick, ';
  $cells .= 'brd.boardmods_modpanel AS boardmods_modpanel, brd.boardmods_edit AS boardmods_edit, brd.boardmods_del AS boardmods_del';
  $cs_bm = cs_sql_select(__FILE__,$tables,$cells,"boardmods_id = '" . $boardmods_id . "'",0,0);
}

if(!isset($_POST['submit']) AND empty($error)) {
  $data['head']['body'] = $cs_lang['body'];
}
elseif(!empty($error)) {
  $data['head']['body'] = $errormsg;
}

if(!empty($error) OR !isset($_POST['submit'])) {

  $data['bm']['id'] = empty($_POST['id']) ? $_GET['id'] : $_POST['id'];
  $data['bm']['user'] = cs_secure($cs_bm['users_nick']);
  $data['bm']['cat_dropdown'] = cs_categories_dropdown('boardmods',$cs_bm['categories_id']);
  $data['bm']['boardmods_modpanel'] = $cs_bm['boardmods_modpanel'] == 1 ? 'checked="checked"' : '';
  $data['bm']['boardmods_edit'] = $cs_bm['boardmods_edit'] == 1 ? 'checked="checked"' : '';
  $data['bm']['boardmods_del'] = $cs_bm['boardmods_del'] == 1 ? 'checked="checked"' : '';

} else {
  
  $boardmods_cells = array_keys($cs_bm);
  $boardmods_save = array_values($cs_bm);
  cs_sql_update(__FILE__,'boardmods',$boardmods_cells,$boardmods_save,$_POST['id']);
  
    cs_redirect($cs_lang['changes_done'],'boardmods');
} 

echo cs_subtemplate(__FILE__,$data,'boardmods','edit');
