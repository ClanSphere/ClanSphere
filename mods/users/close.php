<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');

$users_form = 1;
$data = array();

if(isset($_POST['agree'])) {
  $users_form = 0;
  $users_cells = array('users_active');
  $users_save = array('0');
  cs_sql_update(__FILE__,'users',$users_cells,$users_save,$account['users_id']);
  
  cs_redirect($cs_lang['close_true'],'users','home');
}

if(isset($_POST['cancel'])) {
  $users_form = 0;
  cs_redirect($cs_lang['close_false'],'users','home');
}

if(!empty($users_form)) {
  echo cs_subtemplate(__FILE__,$data,'users','close');
}