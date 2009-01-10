<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('install');

require_once('mods/users/functions.php');

$error = 0;
$errormsg = '';

if(isset($_POST['submit'])) {

  $create['users_lang'] = $_POST['lang'];
  $create['users_nick'] = $_POST['nick'];
  $create_['password'] = $_POST['password'];
  $create['users_email'] = $_POST['email'];

  $nick2 = str_replace(' ','',$create['users_nick']);
  $nickchars = strlen($nick2);
  if($nickchars<4) {
    $error++;
    $errormsg .= $cs_lang['short_nick'] . cs_html_br(1);
  }

  $pwd2 = str_replace(' ','',$create_['password']);
  $pwdchars = strlen($pwd2);
  if($pwdchars<4) {
    $error++;
    $errormsg .= $cs_lang['short_pwd'] . cs_html_br(1);
  }

  $pattern = "=^[_a-z0-9-]+(\.[_a-z0-9-]+)*@([0-9a-z](-?[0-9a-z])*\.)+[a-z]{2}([zmuvtg]|fo|me)?$=i";
  if(!preg_match($pattern,$create['users_email'])) {
    $error++;
    $errormsg .= $cs_lang['email_false'] . cs_html_br(1);
  }
}
else {

  $create['users_lang'] = $account['users_lang'];
  $create['users_nick'] = '';
  $create_['password'] = '';
  $create['users_email'] = '';
}

echo cs_html_form (1,'install_admin','install','admin');
echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['admin'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc');
if(!isset($_POST['submit'])) {
  echo $cs_lang['create_admin'];
}
elseif(!empty($error)) {
  echo $errormsg;
}
else {
  echo $cs_lang['admin_done'];
}
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

if(!empty($error) OR !isset($_POST['submit'])) {

	echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'leftb',0,2);
  echo $cs_lang['admin'];
  echo cs_html_roco(0);
	echo cs_html_roco(1,'leftc');
	echo $cs_lang['lang'] . ' *';
	echo cs_html_roco(2,'leftb');
	echo cs_html_select(1,'lang');
	$languages = cs_checkdirs('lang');
	foreach($languages as $lang) {
		$sel = $lang['name'] == $create['users_lang'] ? 1 : 0;
		echo cs_html_option($lang['name'],$lang['name'],$sel);
	}
	echo cs_html_select(0);
	echo cs_html_roco(0);
  
	echo cs_html_roco(1,'leftc');
	echo $cs_lang['nick'] . ' *';
	echo cs_html_roco(2,'leftb');
	echo cs_html_input('nick',$create['users_nick'],'text',40,40);
	echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo $cs_lang['email'] . ' *';
	echo cs_html_roco(2,'leftb');
	echo cs_html_input('email',$create['users_email'],'text',40,40);
	echo cs_html_roco(0);
  
	echo cs_html_roco(1,'leftc');
	echo $cs_lang['password'] . ' *';
	echo cs_html_roco(2,'leftb');
	echo cs_html_input('password',$create_['password'],'password',30,30);
	echo cs_html_roco(0);
  
  echo cs_html_roco(1,'leftb',0,2);
  echo $cs_lang['show'];
  echo cs_html_roco(0);
  
  echo cs_html_roco(1,'leftc');
  echo $cs_lang['show_groups_as'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_select(1,'clanlabel');
   echo cs_html_option($cs_lang['clan'],'clan',1);
   echo cs_html_option($cs_lang['association'],'association');
   echo cs_html_option($cs_lang['club'],'club');
   echo cs_html_option($cs_lang['guild'],'guild');
   echo cs_html_option($cs_lang['enterprise'],'enterprise');
   echo cs_html_option($cs_lang['school'],'school');
  echo cs_html_select(0);
  echo cs_html_roco(0);
  
  echo cs_html_roco(1,'leftc');
  echo $cs_lang['show_subgroups_as'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_select(1,'squadlabel');
   echo cs_html_option($cs_lang['squads'],'squad',1);
   echo cs_html_option($cs_lang['groups'],'group');
   echo cs_html_option($cs_lang['sections'],'section');
   echo cs_html_option($cs_lang['teams'],'team');
   echo cs_html_option($cs_lang['class'],'class');
   echo cs_html_select(0);
  echo cs_html_roco(0);
  
  echo cs_html_roco(1,'leftc');
  echo $cs_lang['show_members_as'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_select(1,'memberlabel');
   echo cs_html_option($cs_lang['members'],'members',1);
   echo cs_html_option($cs_lang['employees'],'employees');
   echo cs_html_option($cs_lang['teammates'],'teammates');
   echo cs_html_option($cs_lang['classmates'],'classmates');
   echo cs_html_select(0);
  echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo cs_icon('ksysguard') . $cs_lang['options'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_vote('submit',$cs_lang['create'],'submit');
	echo cs_html_vote('reset',$cs_lang['reset'],'reset');
	echo cs_html_roco(0);
	echo cs_html_table(0);
	echo cs_html_form(0);
}
else {

	$create['users_timezone'] = date('Z');
	$create['users_dstime'] = 0;
	create_user(5,$create['users_nick'],$create_['password'],$create['users_lang'],$create['users_email'],'fam',$create['users_timezone'],$create['users_dstime']);
  
  // Options
  $def_cell = array('options_value');
  cs_sql_update(__FILE__,'options',$def_cell,array($_POST['clanlabel']),0,'options_mod = \'clans\' AND options_name = \'label\'');
  cs_sql_update(__FILE__,'options',$def_cell,array($_POST['squadlabel']),0,'options_mod = \'squads\' AND options_name = \'label\'');
  cs_sql_update(__FILE__,'options',$def_cell,array($_POST['memberlabel']),0,'options_mod = \'members\' AND options_name = \'label\'');

	
	cs_redirect('','install','complete','lang='.$create['users_lang']);
}

?>