<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

if(defined('UPLOAD_PROTECTED') AND !empty($_SESSION)) {
  if(isset($_POST['remove'])) {
    $file = $_POST['remove'];
    if(isset($_SESSION['ajaxuploads'][$file]) && file_exists('uploads/cache/' . $_SESSION['ajaxuploads'][$file]))
      cs_unlink('cache',$_SESSION['ajaxuploads'][$file]);
    unset($_SESSION['ajaxuploads'][$file]);
    echo $file . ' deleted';
  }
  elseif(isset($_POST['upload_name']) AND isset($_FILES['' . $_POST['upload_name'] . '']['tmp_name'])) {
    
    $upload_name = $_POST['upload_name'];
    $file = $_FILES[$upload_name]['tmp_name'];
    $new_name = 'tmp_'.time().strrchr($_FILES[$upload_name]['name'],'.');
    
    $error = !cs_upload('cache', $new_name, $_FILES[$upload_name]['tmp_name'], 0);
    if (!isset($_SESSION['ajaxuploads'])) $_SESSION['ajaxuploads'] = array();
    $_SESSION['ajaxuploads'][$upload_name] = $new_name;
    
    $upload = array();
    
    $upload['name'] = $upload_name;
    $upload['original_name'] = $_FILES[$upload_name]['name'];
    $upload['size'] = cs_filesize($_FILES[$upload_name]['size']);

    if($error) {
      $upload['error'] = true;
    }
    echo '<script language="javascript" type="text/javascript">';
    echo 'window.top.Clansphere.ajax.upload_complete(' . json_encode($upload) . ');';
    echo '</script>';
  }
  else {
    echo '<script language="javascript" type="text/javascript">';
    echo 'alert("no file given");';
    echo '</script>';
  }
} else {
  echo '<script language="javascript" type="text/javascript">';
  echo 'alert("Permission denied");';
  echo '</script>';
}