<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

require_once('mods/categories/functions.php');

$cs_board['board_time'] = cs_time();
$cs_board['users_id'] = $account['users_id'];

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['create'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');

if(isset($_POST['submit']) OR isset($_POST['preview'])) 
{

	$cs_board['categories_id'] = empty($_POST['categories_name']) ? $_POST['categories_id'] : 
	cs_categories_create('board',$_POST['categories_name']);
	$cs_board['board_access'] = $_POST['board_access'];
	$cs_board['board_name'] = $_POST['board_name'];
	$cs_board['board_text'] = $_POST['board_text'];
	$cs_board['board_pwd'] = $_POST['board_pwd'];
	$cs_board['squads_id'] = $_POST['squads_id'];
	$cs_board['board_read'] = $_POST['board_read'];

	$error = 0;
	$errormsg = '';

	if(empty($cs_board['categories_id'])) 
	{
		$error++;
		$errormsg .= $cs_lang['no_cat'] . cs_html_br(1);
	}
	if(empty($cs_board['board_name']))
	{
		$error++;
		$errormsg .= $cs_lang['no_name'] . cs_html_br(1);
	}
	if(empty($cs_board['board_text'])) 
	{
		$error++;
		$errormsg .= $cs_lang['no_text'] . cs_html_br(1);
	}
}
else 
{
	$cs_board['categories_id'] = 0;
	$cs_board['squads_id'] = 0;
	$cs_board['board_name'] = '';
	$cs_board['board_access'] = 0;
	$cs_board['board_text'] = ''; 
	$cs_board['board_pwd'] = '';
}
if(!isset($_POST['submit']) AND !isset($_POST['preview'])) 
{
	echo $cs_lang['body_create'];
}
elseif(!empty($error)) 
{
	echo $errormsg;
}
elseif(isset($_POST['preview']))
{
	echo $cs_lang['preview'];
}
else 
{
	echo $cs_lang['create_done'];
}

echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

if(isset($_POST['preview']) AND empty($error)) 
{
	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'leftb',0,0,15);
	if(empty($cs_board['board_pwd']))
		echo cs_icon('tutorials');
	else
		echo cs_icon('password');	
	echo cs_html_roco(2,'leftc');
	echo cs_html_big(1);
	echo cs_link(cs_secure($cs_board['board_name']),'board','listcat','where='); 
	echo cs_html_big(0);
	echo cs_html_br(1);
	echo cs_secure($cs_board['board_text'],1);
	echo cs_html_roco(3,'leftb');
	echo '0';
	echo cs_html_roco(4,'leftc');
	echo '0';
	echo cs_html_roco(5,'leftb');
	echo '0';
	echo cs_html_roco(0);
	echo cs_html_table(0);
	echo cs_html_br(1);
}

if(!empty($error) OR isset($_POST['preview']) OR !isset($_POST['submit'])) 
{
	echo cs_html_form (1,'board_create','board','create');
	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'leftc');
	echo cs_icon('kedit') . $cs_lang['name'] . ' *';
	echo cs_html_roco(2,'leftb');
	echo cs_html_input('board_name',$cs_board['board_name'],'text',200,50);
	echo cs_html_roco(0);
  
	echo cs_html_roco(1,'leftc');
	echo cs_icon('folder_yellow') . $cs_lang['category'] . ' *';
	echo cs_html_roco(2,'leftb');
	echo cs_categories_dropdown2('board',$cs_board['categories_id']);
  	echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo cs_icon('kate') . $cs_lang['text'] . ' *';
	echo cs_html_roco(2,'leftb');
	echo cs_abcode_features('board_text');
	echo cs_html_textarea('board_text',$cs_board['board_text'],'50','5');
	echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo cs_icon('access') . $cs_lang['access'] . ' *';
	echo cs_html_roco(2,'leftb',0,2);
	echo cs_html_select(1,'board_access');
	$levels = 0;
	$sel = 0;
	while($levels < 6) 
	{
		$cs_board['board_access'] == $levels ? $sel = 1 : $sel = 0;
		echo cs_html_option($levels . ' - ' . $cs_lang['lev_' . $levels],$levels,$sel);
		$levels++;
	}
	echo cs_html_select(0);
	echo cs_html_roco(0);  
	
	echo cs_html_roco(1,'leftc');          
	echo cs_icon('access') . $cs_lang['only_read'] . ' *';
	echo cs_html_roco(2,'leftb');
    echo cs_html_input('board_read',1,'radio') . $cs_lang['yes'];
	echo cs_html_input('board_read',0,'radio',0,0,'checked') . $cs_lang['no'];
  	echo cs_html_roco(0);
	
	echo cs_html_roco(1,'leftc');
	echo cs_icon('password') . $cs_lang['add_password'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_input('board_pwd',$cs_board['board_pwd'],'password',30,30,'onkeydown="javascript:passwordcheck(this.value);" onkeyup="javascript:passwordcheck(this.value);"','form') .cs_html_br(1). $cs_lang['password1'];
	echo cs_html_roco(0);   
	
  echo cs_html_roco(1,'leftc');
  echo cs_icon('password') . $cs_lang['secure'] . '';
  echo cs_html_roco(2,'leftb');
  echo cs_html_div(1,'float:left; background-image:url(' . $cs_main['php_self']['dirname'] . 'symbols/votes/vote03.png); width:100px; height:13px; margin-top: 3px; margin-left: 2px;');
  echo cs_html_div(1,'float:left; background-image:url(' . $cs_main['php_self']['dirname'] . 'symbols/votes/vote01.png); width: 1px; height: 13px;','id="pass_secure"');   
  echo cs_html_div(0);
  echo cs_html_div(0);
  echo cs_html_div(1,'float:left; padding-left: 3px; padding-top: 3px; display:none','id="pass_stage_1"');   
  echo $cs_lang['stage_1'];
  echo cs_html_div(0);
  echo cs_html_div(1,'float:left; padding-left: 3px; padding-top: 3px; display:none','id="pass_stage_2"');   
  echo $cs_lang['stage_2'];
  echo cs_html_div(0);
  echo cs_html_div(1,'float:left; padding-left: 3px; padding-top: 3px; display:none','id="pass_stage_3"');   
  echo $cs_lang['stage_3'];
  echo cs_html_div(0);
  echo cs_html_div(1,'float:left; padding-left: 3px; padding-top: 3px; display:none','id="pass_stage_4"');   
  echo $cs_lang['stage_4'];
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
	
	echo cs_html_roco(1,'leftc');          
	$op_squads = cs_sql_option(__FILE__,'squads');
	echo cs_icon('yast_group_add') . $cs_lang[$op_squads['label']];
	echo cs_html_roco(2,'leftb');
	$data_squads = cs_sql_select(__FILE__,'squads','squads_name,squads_id','squads_own=1','squads_name',0,0); 
  	echo cs_dropdown('squads_id','squads_name',$data_squads,$cs_board['squads_id']);   
  	echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo cs_icon('ksysguard') . $cs_lang['options'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_vote('submit',$cs_lang['create'],'submit');
	echo cs_html_vote('preview',$cs_lang['preview'],'submit');
	echo cs_html_vote('reset',$cs_lang['reset'],'reset');
	echo cs_html_roco(0);
	echo cs_html_table(0);
	echo cs_html_form(0);
}
else 
{
	global $cs_db;
	if(!empty($cs_board['board_pwd']))
	{
  		if($cs_db['hash'] == 'md5') { 
    			$cs_board['board_pwd'] = md5($cs_board['board_pwd']);
  		}
       		elseif($cs_db['hash'] == 'sha1') { 
   			$cs_board['board_pwd'] = sha1($cs_board['board_pwd']);
  		}
	}
	$board_cells = array_keys($cs_board);
	$board_save = array_values($cs_board);
	cs_sql_insert(__FILE__,'board',$board_cells,$board_save);

	cs_redirect($cs_lang['create_done'],'board');
} 
?>