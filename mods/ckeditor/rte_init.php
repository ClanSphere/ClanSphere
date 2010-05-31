<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

global $account, $cs_main;

if(empty($account['access_ckeditor']))
  $cs_main['rte_html'] = '';
else {

  # set access for uploads
  $_SESSION['access_ckeditor'] = empty($account['access_ckeditor']) ? 0 : $account['access_ckeditor'];

  # fetch options for ckeditor
  $op_ckeditor = cs_sql_option(__FILE__,'ckeditor');

  # set language and other options
  global $com_lang, $cs_main;
  $_SESSION['ckeditor_lang'] = empty($com_lang['short']) ? 'en' : $com_lang['short'];
  $_SESSION['ckeditor_skin'] = empty($op_ckeditor['skin']) ? 'kama' : $op_ckeditor['skin'];
  $_SESSION['ckeditor_height'] = empty($op_ckeditor['height']) ? '300' : $op_ckeditor['height'];
  $_SESSION['ckeditor_path'] = 'http://' . $_SERVER['HTTP_HOST'] . substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));

  cs_scriptload('ckeditor', 'javascript', 'ckeditor.js');
  cs_scriptload('ckeditor', 'javascript', 'adapters/jquery.js');
  cs_scriptload('ckeditor', 'javascript', 'ckeditor_init.php');

  function cs_rte_html($name, $value = '') {

    global $cs_main;

    # handle abcode html tag behavior
    $value = cs_abcode_inhtml($value, 'del');

    $data['ckeditor']['name'] = $name;
    $data['ckeditor']['value'] = htmlentities($value, ENT_QUOTES, $cs_main['charset']);

    return cs_subtemplate(__FILE__, $data, 'ckeditor', 'rte_html');
  }
}