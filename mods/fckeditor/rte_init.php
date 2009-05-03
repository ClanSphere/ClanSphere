<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

global $account, $cs_main;

if(empty($account['access_fckeditor']))
  $cs_main['rte_html'] = '';
else {

  # set access for uploads
  $_SESSION['access_fckeditor'] = empty($account['access_fckeditor']) ? 0 : $account['access_fckeditor'];

  cs_scriptload('fckeditor', 'javascript', 'fckeditor.js');

  function cs_rte_html($name, $value = '') {

    # handle old html tag behavior
    if(substr($value,0,6) == '[html]' AND substr($value,-7,7) == '[/html]') {
      $value = substr($value, 6, -7);
    }

    global $cs_main;
    $data = array('fck');
    $data['fck'] = cs_sql_option(__FILE__,'fckeditor');
    $data['fck']['skin'] = empty($data['fck']['skin']) ? 'default' : $data['fck']['skin'];
    $data['fck']['height'] = empty($data['fck']['height']) ? '300' : $data['fck']['height'];
    $data['fck']['path'] = 'http://' . $_SERVER['HTTP_HOST'] . substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));

    if(empty($cs_main['ajax'])) {

      require_once $cs_main['def_path'] . '/mods/fckeditor/fckeditor.php';

      $oFCKeditor = new FCKeditor($name);
      $oFCKeditor->BasePath = $data['fck']['path'] . '/mods/fckeditor/';
      $oFCKeditor->Value = $value;
      $oFCKeditor->Width  = '100%';
      $oFCKeditor->Height = $data['fck']['height'];
      $oFCKeditor->ToolbarSet = 'Default';
      $oFCKeditor->Config['AutoDetectLanguage'] = TRUE;
      $oFCKeditor->Config['DefaultLanguage'] = 'en';
      $oFCKeditor->Config['SkinPath'] = $oFCKeditor->BasePath . 'editor/skins/' . $data['fck']['skin'] . '/';

      return $oFCKeditor->CreateHtml();
    }
    else {

      $data['fck']['name'] = $name;
      $data['fck']['value'] = str_replace(array('"',"\n","\r"),array('\"','',''),$value);

      return cs_subtemplate(__FILE__, $data, 'fckeditor', 'rte_html');
    }
  }
}