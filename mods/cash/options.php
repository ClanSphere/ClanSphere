<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cash');
$data = array();

if(isset($_POST['submit'])) {
	$opt['month_out'] = empty($_POST['month_out']) ? 0 : (int) $_POST['month_out'];
	
	require 'mods/clansphere/func_options.php';
	$save = array();
	$save['month_out'] = $opt['month_out'];
	cs_optionsave('cash', $save);
	cs_redirect($cs_lang['create_options'],'cash','manage');

}
else {
	$select = 'options_mod, options_value, options_name';
	$where = "options_mod = 'cash' AND options_name = 'month_out'";
	$options = cs_sql_select(__FILE__,'options',$select,$where,0,0);
	$opt['month_out'] = $options['options_value'];
}

if(!isset($_POST['submit'])) {

	$data['op']['month_out'] = $opt['month_out'];

  echo cs_subtemplate(__FILE__,$data,'cash','options');
}

?>