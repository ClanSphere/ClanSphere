<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('static');

if (isset($_POST['submit'])) {

  $save = array();
  $save['php_eval'] = empty($_POST['php_eval']) ? 0 : 1;

  require_once 'mods/clansphere/func_options.php';

  cs_optionsave('static', $save);

  cs_redirect($cs_lang['changes_done'], 'options', 'roots');
}
else {

  $data = array();

  $cs_options = cs_sql_option(__FILE__,'static');

  $data['lang']['getmsg'] = cs_getmsg();

  $checked = ' checked="checked"';
  $data['checked']['php_eval'] = !empty($cs_options['php_eval']) ? $checked : '';

  echo cs_subtemplate(__FILE__,$data,'static','options');
}