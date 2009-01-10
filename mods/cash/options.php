<?php
$cs_lang = cs_translate('cash');

if(isset($_POST['submit'])) {
	$opt['month_out'] = (int) $_POST['month_out'];
	
	$error = 0;
	$errormsg = $cs_lang['error'] . cs_html_br(1);
	
	if(empty($opt['month_out'])) {
	  $error++;
	  $errormsg .= $cs_lang['no_month_out'] . cs_html_br(1);
	}		
	if(empty($error)) {
		require 'mods/clansphere/func_options.php';
		$save = array();
		$save['month_out'] = $opt['month_out'];
		cs_optionsave('cash', $save);
		cs_redirect($cs_lang['create_options'],'cash','manage');
	}
} else {
	$select = 'options_mod, options_value, options_name';
	$where = "options_mod = 'cash' AND options_name = 'month_out'";
	$options = cs_sql_select(__FILE__,'options',$select,$where,0,0);
	$opt['month_out'] = $options['options_value'];
}

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod_name'] . ' - ' . $cs_lang['options'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');

if(!isset($_POST['submit'])) {
  echo $cs_lang['body_create'];
}
elseif(!empty($error)) {
  echo $errormsg;
}

echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

if(!empty($error) OR !isset($_POST['submit'])) {
	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'headb',0,2);
	echo $cs_lang['options'];
	echo cs_html_roco(0);
	
	echo cs_html_form(1,'cash_options','cash','options');
	echo cs_html_roco(1,'leftb',0,0,'150px');
	echo cs_icon('money') . $cs_lang['month_out'];
	echo cs_html_roco(2,'leftc');
	echo cs_html_input('month_out',$opt['month_out'],'text',10,7) . $cs_lang['euro'];
	echo cs_html_roco(0);	
	
	echo cs_html_roco(1,'leftb');
	echo cs_icon('ksysguard') . $cs_lang['options'];
	echo cs_html_roco(2,'leftc');
	echo cs_html_vote('submit',$cs_lang['edit'],'submit');
	echo cs_html_vote('reset',$cs_lang['reset'],'reset');
	echo cs_html_roco(0);
	echo cs_html_form(0);
	echo cs_html_table(0);

} 
?>