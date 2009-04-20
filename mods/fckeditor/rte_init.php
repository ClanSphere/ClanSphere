<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

global $account, $cs_main;

if(empty($account['access_fckeditor']))
  $cs_main['rte_html'] = '';
else {

  # set access for uploads
  $_SESSION['access_fckeditor'] = empty($account['access_fckeditor']) ? 0 : $account['access_fckeditor'];

  function cs_rte_html($name, $value = '') {

    static $op_fck;
    if(empty($op_fck)) {
      $op_fck = cs_sql_option(__FILE__,'fckeditor');
      $op_fck['toolbar'] = 1;
      $op_fck['width'] = '100%';
      $op_fck['skin'] = empty($op_fck['skin']) ? 'default' : $op_fck['skin'];
    }

    if(substr($value,0,6) == '[html]' AND substr($value,-7,7) == '[/html]') {
      $value = substr($value, 6, -7);
    }

    global $cs_main;
    require_once $cs_main['def_path'] . '/mods/fckeditor/fckeditor.php';

    $oFCKeditor = new FCKeditor($name);

    $oFCKeditor->BasePath = 'http://' . $_SERVER['HTTP_HOST'] . substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/')) . '/mods/fckeditor/';
    $oFCKeditor->Value = $value;
    $oFCKeditor->Width  = $op_fck['width'];
    $oFCKeditor->Height = $op_fck['height'];
    $oFCKeditor->ToolbarSet = 'Default';
    $oFCKeditor->Config['AutoDetectLanguage'] = TRUE;
    $oFCKeditor->Config['DefaultLanguage'] = 'en';
    $oFCKeditor->Config['SkinPath'] = $oFCKeditor->BasePath . 'editor/skins/' . $op_fck['skin'] . '/';

    return $oFCKeditor->CreateHtml();
  }
}