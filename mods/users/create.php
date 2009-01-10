<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');

require_once('mods/users/functions.php');

$error = 0;
$errormsg = '';
$conv_joinus = 0;

if(isset($_POST['submit'])) {
  
  $op_users = cs_sql_option(__FILE__,'users');
  
  $create['access_id'] = $_POST['access_id'];
  $create['users_lang'] = $_POST['lang'];
  $create['users_nick'] = $_POST['nick'];
  $create_['password'] = $_POST['password'];
  $create['users_email'] = $_POST['email'];
  $create['users_country'] = $_POST['country'];
  
  if(!empty($_POST['conv_joinus'])) {
		$create['users_name'] = $_POST['users_name'];
		$create['users_surname'] = $_POST['users_surname'];
		$create['users_age'] = $_POST['users_age'];
		$create['users_place'] = $_POST['users_place'];
		$create['users_icq'] = $_POST['users_icq'];
		$create['users_msn'] = $_POST['users_msn'];
		$create['users_pwd'] = $_POST['users_pwd'];
 	    $conv_joinus = 1;
  }
  
  $nick2 = str_replace(' ','',$create['users_nick']);
  $nickchars = strlen($nick2);
  if($nickchars < $op_users['min_letters']) {
    $error++;
    $errormsg .= sprintf($cs_lang['short_nick'],$op_users['min_letters']) . cs_html_br(1);
  }

  $search_nick = cs_sql_count(__FILE__,'users',"users_nick = '" . cs_sql_escape($create['users_nick']) . "'");
  if(!empty($search_nick)) {
    $error++;
    $errormsg .= $cs_lang['nick_exists'] . cs_html_br(1);
  }

	$whr_acc = "access_id = '" . cs_sql_escape($create['access_id']) . "'";
  $get_acc = cs_sql_select(__FILE__,'access','*',$whr_acc);
  if($get_acc['access_clansphere'] > $account['access_clansphere'] OR $get_acc['access_access'] > $account['access_access'] OR $get_acc['access_users'] > $account['access_users']) {
    $error++;
    $errormsg .= $cs_lang['access_denied'] . cs_html_br(1);
  }
  if(empty($_POST['conv_joinus'])) {
    $pwd2 = str_replace(' ','',$create_['password']);
    $pwdchars = strlen($pwd2);
    if($pwdchars<4) {
      $error++;
      $errormsg .= $cs_lang['short_pwd'] . cs_html_br(1);
    }
  }

  $search_email = cs_sql_count(__FILE__,'users',"users_email = '" . cs_sql_escape($create['users_email']) . "'");
  if(!empty($search_email)) {
    $error++;
    $errormsg .= $cs_lang['email_exists'] . cs_html_br(1);
  }
  
  $pattern = "=^[_a-z0-9-]+(\.[_a-z0-9-]+)*@([0-9a-z](-?[0-9a-z])*\.)+[a-z]{2}([zmuvtg]|fo|me)?$=i";
  if(!preg_match($pattern,$create['users_email'])) {
    $error++;
    $errormsg .= $cs_lang['email_false'] . cs_html_br(1);
  }
	
	$flood = cs_sql_select(__FILE__,'users','users_register',0,'users_register DESC');
	$maxtime = $flood['users_register'] + $cs_main['def_flood'];
	if($maxtime > cs_time()) {
		$error++;
		$diff = $maxtime - cs_time();
		$errormsg .= sprintf($cs_lang['flood_on'], $diff);
	}

	if(empty($create['access_id'])) {
    $error++;
    $errormsg .= $cs_lang['no_access'] . cs_html_br(1);
  }

  isset($_POST['send_mail']) ? $rgsm = $_POST['send_mail'] : $rgsm = 0;
  $create_['send_mail'] = $rgsm;
}
else {

  $create['users_lang'] = $cs_main['def_lang'];
  $create['users_country'] = 'fam';
  $create['users_nick'] = '';
  $create_['password'] = '';
  $create['users_email'] = '';
  $create_['send_mail'] = 0;
  $create['access_id'] = 0;

	if(!empty($_GET['joinus'])) {
		$joinus_where = "joinus_id = '" . cs_sql_escape($_GET['joinus']) . "'";
		$cs_joinus = cs_sql_select(__FILE__,'joinus','*',$joinus_where);
		if(!empty($cs_joinus)) {
		  $create['users_nick'] = $cs_joinus['joinus_nick'];
		  $create['users_email'] = $cs_joinus['joinus_email'];
		  $create['users_country'] = $cs_joinus['joinus_country'];
		  $create['users_name'] = $cs_joinus['joinus_name'];
		  $create['users_surname'] = $cs_joinus['joinus_surname'];
		  $create['users_age'] = $cs_joinus['joinus_age'];
		  $create['users_place'] = $cs_joinus['joinus_place'];
		  $create['users_icq'] = $cs_joinus['joinus_icq'];
  		  $create['users_msn'] = $cs_joinus['joinus_msn'];
		  $create['users_pwd'] = $cs_joinus['users_pwd'];
		  $create['access_id'] = '3';
		  $conv_joinus = 1;
		}
	}
}

echo cs_html_form (1,'users_create','users','create');
echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod_name'] . ' - ' . $cs_lang['create'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc');
if(!isset($_POST['submit'])) {
  echo $cs_lang['create_users'];
}
elseif(!empty($error)) {
  echo $errormsg;
}
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

if(!empty($error) OR !isset($_POST['submit'])) {

	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'leftc',0,0,'25%');
	echo cs_icon('locale') . $cs_lang['lang'] . ' *';
	echo cs_html_roco(2,'leftb',0,0,'75%');
	echo cs_html_select(1,'lang');
	$languages = cs_checkdirs('lang');
	foreach($languages as $lang) {
		$lang['name'] == $create['users_lang'] ? $sel = 1 : $sel = 0;
		echo cs_html_option($lang['name'],$lang['name'],$sel);
	}
	echo cs_html_select(0);
	echo cs_html_roco(0);
  
	echo cs_html_roco(1,'leftc');
	echo cs_icon('personal') . $cs_lang['nick'] . ' *';
	echo cs_html_roco(2,'leftb');
	echo cs_html_input('nick',$create['users_nick'],'text',40,40);
	echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo cs_icon('mail_generic') . $cs_lang['email'] . ' *';
	echo cs_html_roco(2,'leftb');
	echo cs_html_input('email',$create['users_email'],'text',40,40);
	echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo cs_icon('access') . $cs_lang['access'] . ' *';
	echo cs_html_roco(2,'leftb');
	$where = "access_clansphere <= '" . $account['access_clansphere'] . "'";
	$access_data = cs_sql_select(__FILE__,'access','access_name, access_id, access_clansphere',$where,'access_name',0,0);
	echo cs_dropdown('access_id','access_name',$access_data,$create['access_id']);
	echo cs_html_roco(0);
  
    if(empty($conv_joinus)) {
	  echo cs_html_roco(1,'leftc');
	  echo cs_icon('password') . $cs_lang['password'] . ' *';
	  echo cs_html_roco(2,'leftb');
	  echo cs_html_input('password',$create_['password'],'password',30,30,'onkeydown="javascript:passwordcheck(this.value);" onkeyup="javascript:passwordcheck(this.value);"','form');
	  echo cs_html_roco(0);
	
  echo cs_html_roco(1,'leftc');
  echo cs_icon('password') . $cs_lang['secure'] . '';
  echo cs_html_roco(2,'leftb');
  echo cs_html_div(1,'float:left; background-image:url(' . $cs_main['php_self']['dirname'] . 'symbols/votes/vote03.png); width:100px; height:13px;');
    echo cs_html_div(1,'float:left; background-image:url(' . $cs_main['php_self']['dirname'] . 'symbols/votes/vote01.png); width: 1%; height:13px;','id="pass_secure"');   
    echo cs_html_div(0);
  echo cs_html_div(0);
  
    echo cs_html_div(1,'clear:both');
  $matches[1] = $cs_lang['secure_stages'];
  $matches[2] = $cs_lang['stage_1'] . $cs_lang['stage_1_text'] . cs_html_br(1);
  $matches[2] .= $cs_lang['stage_2'] . $cs_lang['stage_2_text'] . cs_html_br(1);
  $matches[2] .= $cs_lang['stage_3'] . $cs_lang['stage_3_text'] . cs_html_br(1);
  $matches[2] .= $cs_lang['stage_4'] . $cs_lang['stage_4_text'];
  echo cs_abcode_clip($matches);
  echo cs_html_div(0);
  echo cs_html_roco(0);
  
  	} else {
	
	  echo cs_html_roco(1,'leftc');
	  echo cs_icon('password') . $cs_lang['password'];
	  echo cs_html_roco(2,'leftb');
	  echo $cs_lang['auto_pass'];
	  echo cs_html_input('users_pwd',$create['users_pwd'],'hidden');
	  echo cs_html_roco(0);
	  $code_id = generate_code(8);

	  echo cs_html_vote('password',$code_id,'hidden');
	  echo cs_html_vote('conv_joinus',$conv_joinus,'hidden');
	  echo cs_html_vote('users_age',$create['users_age'],'hidden');
	
	  echo cs_html_roco(1,'leftc');
	  echo cs_icon('personal') . $cs_lang['prename'];
	  echo cs_html_roco(2,'leftb');
	  echo cs_html_input('users_name',$create['users_name'],'text',80,50);
	  echo cs_html_roco(0);

		echo cs_html_roco(1,'leftc');
		echo cs_icon('personal') . $cs_lang['surname'];
		echo cs_html_roco(2,'leftb');
		echo cs_html_input('users_surname',$create['users_surname'],'text',80,50);
		echo cs_html_roco(0);
		
		echo cs_html_roco(1,'leftc');
		echo cs_icon('starthere') . $cs_lang['place'];
		echo cs_html_roco(2,'leftb');
		echo ' ' . cs_html_input('users_place',$create['users_place'],'text',40,40);
		echo cs_html_roco(0);
		
		echo cs_html_roco(1,'leftc');
		echo cs_icon('licq') . $cs_lang['icq'];
		echo cs_html_roco(2,'leftb',0,2);
		echo cs_html_input('users_icq',$create['users_icq'],'text',12,12);
		echo cs_html_roco(0);
		
		echo cs_html_roco(1,'leftc');
		echo cs_icon('msn_protocol') . $cs_lang['msn'];
		echo cs_html_roco(2,'leftb',0,2);
		echo cs_html_input('users_msn',$create['users_msn'],'text',40,40);
		echo cs_html_roco(0);
	
	}
   
	echo cs_html_roco(1,'leftc');
	echo cs_icon('configure') . $cs_lang['extended'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_vote('send_mail','1','checkbox',$create_['send_mail']);
	echo $cs_lang['send_mail'];
	echo cs_html_roco(0);
  
	echo cs_html_roco(1,'leftc');
	echo cs_icon('ksysguard') . $cs_lang['options'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_vote('country',$create['users_country'],'hidden');
	echo cs_html_vote('submit',$cs_lang['create'],'submit');
	echo cs_html_vote('reset',$cs_lang['reset'],'reset');
	echo cs_html_roco(0);
	echo cs_html_table(0);
	echo cs_html_form(0);
}
else {
	
	$create['users_timezone'] 	= empty($cs_main['def_timezone']) ? 0 : $cs_main['def_timezone'];
	$create['users_dstime']	 	= empty($cs_main['def_dstime']) ? 0 : $cs_main['def_dstime'];
	create_user($create['access_id'],$create['users_nick'],$create_['password'],$create['users_lang'],$create['users_email'],$create['users_country'],$create['users_timezone'],$create['users_dstime']);
	
	if(!empty($create_['send_mail'])) {
		$content = $cs_lang['mail_reg_start'] . $cs_lang['mail_reg_nick'] . $create['users_nick'];
		if(empty($_POST['conv_joinus'])) {
		  $content .= $cs_lang['mail_reg_password'] . $create_['password'];
		} else {
		  $content .= $cs_lang['mail_reg_password'] . $cs_lang['mail_reg_password2'];
		}
		$content .= $cs_lang['mail_reg_ip'] . $_SERVER['REMOTE_ADDR'];
		$content .= $cs_lang['mail_reg_ask'] . $cs_main['def_mail'] . $cs_lang['mail_reg_end'];
  
    cs_mail($create['users_email'],$cs_lang['mail_reg_head'],$content);
  }
  
  cs_redirect($cs_lang['create_done'],'users');
  
}

?>