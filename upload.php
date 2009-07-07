<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

# Overwrite global settings by using the following array
$cs_main = array('init_sql' => false, 'init_tpl' => false, 'def_mod' => 'ajax', 'def_action' => '');

require_once 'system/core/functions.php';

cs_init($cs_main);

session_start();

if(!empty($_SESSION)) {

  if(isset($_POST['remove'])) {
    $file = $_POST['remove'];
    if(file_exists('uploads/cache/' . $_SESSION['ajaxuploads'][$file]))
      cs_unlink('cache',$_SESSION['ajaxuploads'][$file]);
    unset($_SESSION['ajaxuploads'][$file]);
    echo $file;
  }
  else {
    
    $upload_name = $_POST['upload_name'];
    $file = $_FILES[$upload_name]['tmp_name'];
    $new_name = 'tmp_'.time().strrchr($_FILES[$upload_name]['name'],'.');
    cs_upload('cache', $new_name, $_FILES[$upload_name]['tmp_name'], 0);
    if (!isset($_SESSION['ajaxuploads'])) $_SESSION['ajaxuploads'] = array();
    $_SESSION['ajaxuploads'][$upload_name] = $new_name;

    echo '<script language="javascript" type="text/javascript">';
    echo 'window.top.window.upload_complete(\'' . $upload_name . '\',\'' . $_FILES[$upload_name]['name'] . '\');';
    echo '</script>';
  }
}