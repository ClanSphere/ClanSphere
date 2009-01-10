<?php

$cs_lang = cs_translate('comments');

if (!empty($_POST['submit'])) {
	require('mods/clansphere/func_options.php');
	$save['show_avatar'] = $_POST['show_avatar'];
	cs_optionsave('comments', $save);
	cs_redirect($cs_lang['success'],'options','roots');
}
$options = cs_sql_option(__FILE__,'comments');

$data = array();
$selected = ' checked="checked"';
$data['selected']['show_avatar'] = empty($options['show_avatar']) ? '' : $selected;
$data['selected']['show_avatar_no'] = !empty($options['show_avatar']) ? '' : $selected;
echo cs_subtemplate(__FILE__,$data,'comments','options');
?>