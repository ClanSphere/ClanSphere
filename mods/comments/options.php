<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('comments');
$data = array();

$options = cs_sql_option(__FILE__,'comments');

if (isset($_POST['submit'])) {
  require('mods/clansphere/func_options.php');
  $save['show_avatar'] = $_POST['show_avatar'];
  $save['allow_unreg'] = $_POST['allow_unreg'];
  cs_optionsave('comments', $save);
  cs_redirect($cs_lang['success'],'options','roots');
}

$checked = ' checked="checked"';
$data['checked']['show_avatar'] = empty($options['show_avatar']) ? '' : $checked;
$data['checked']['show_avatar_no'] = !empty($options['show_avatar']) ? '' : $checked;

$data['checked']['allow_unreg'] = empty($options['allow_unreg']) ? '' : $checked;
$data['checked']['allow_unreg_no'] = !empty($options['allow_unreg']) ? '' : $checked;

echo cs_subtemplate(__FILE__,$data,'comments','options');
?>