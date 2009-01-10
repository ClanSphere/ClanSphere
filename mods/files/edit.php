<?php

$cs_lang = cs_translate('files');

require_once('mods/categories/functions.php');
$files_id = $_REQUEST['id'];
settype($files_id,'integer');

$files_newtime = 0;
$files_newcount = 0;

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_edit'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');

if(isset($_POST['submit'])) {

	if(!empty($_POST['files_newtime'])) {
		$cs_files['files_time'] = cs_time();
		$files_newtime = 1;
	} 
	
	if(!empty($_POST['files_newcount'])) {
		$cs_files['files_count'] = '';
		$files_newcount = 1;
	}

	$cs_files['categories_id'] = empty($_POST['categories_name']) ? $_POST['categories_id'] : 
	cs_categories_create('files',$_POST['categories_name']);

	$cs_files['files_close'] = isset($_POST['files_close']) ? $_POST['files_close'] : 0; 
	$cs_files['files_vote'] = isset($_POST['files_vote']) ? $_POST['files_vote'] : 0;
	$cs_files['files_name'] = $_POST['files_name'];
	$cs_files['files_version'] = $_POST['files_version'];
	$cs_files['files_description'] = $_POST['files_description'];
	$files_size_live = $_POST['files_size_live'];    
	$size = $_POST['size'];
	$run_loop = isset($_POST['run_loop']) ? $_POST['run_loop'] : 1;
	$cs_files['files_mirror'] = '';
	for($run=0; $run < $run_loop; $run++)
	{
	  	$num = $run+1;
		if(!empty($_POST["files_mirror_url_$num"]) AND !empty($_POST["files_mirror_ext_$num"]))
		{
			$cs_files["files_mirror"] = $cs_files["files_mirror"] . "\n-----\n" . $_POST["files_mirror_url_$num"] . "\n" . $_POST["files_mirror_name_$num"] . "\n". $_POST["files_mirror_ext_$num"] . "\n" . $_POST["files_access_$num"];
		}
	}
	
	if($size == 0) 
	{ 
		$cs_files['files_size'] = $files_size_live * 1024;
	}
	elseif($size == 1)
	{
		$cs_files['files_size'] = $files_size_live * 1024 * 1024;
	}
	elseif($size == 2)
	{
		$cs_files['files_size'] = $files_size_live * 1024 * 1024 * 1024;
	}	

  $error = 0;
  $errormsg = '';

  if(empty($cs_files['categories_id'])) {
    $error++;
    $errormsg .= $cs_lang['no_cat'] . cs_html_br(1);
  }
  if(empty($cs_files['files_name'])) {
    $error++;
    $errormsg .= $cs_lang['no_name'] . cs_html_br(1);
  }
  if(empty($cs_files['files_description'])) {
    $error++;
    $errormsg .= $cs_lang['no_text'] . cs_html_br(1);
  }
  if(empty($cs_files['files_mirror'])) {
    $error++;
    $errormsg .= $cs_lang['no_mirror'] . cs_html_br(1);
  }
  if(empty($cs_files['files_size'])) {
	$error++;
    $errormsg .= $cs_lang['no_size'] . cs_html_br(1);
  }
}
else
{
	$cells = 'categories_id, files_name, files_version, files_description, files_mirror, users_id, files_time, files_close, files_vote,files_size';
	$cs_files = cs_sql_select(__FILE__,'files',$cells,"files_id = '" . $files_id . "'");
}
if(isset($_POST['mirror']))
{
  	$cs_files['categories_id'] = empty($_POST['categories_name']) ? $_POST['categories_id'] : 
	cs_categories_create('files',$_POST['categories_name']);
	$cs_files['files_close'] = isset($_POST['files_close']) ? $_POST['files_close'] : 0; 
	$cs_files['files_vote'] = isset($_POST['files_vote']) ? $_POST['files_vote'] : 0;
	$cs_files['files_name'] = $_POST['files_name'];
	$cs_files['files_version'] = $_POST['files_version'];
	$cs_files['files_description'] = $_POST['files_description'];
	$files_size_live = $_POST['files_size_live'];    
	$size = $_POST['size'];
  	$_POST['run_loop']++;
}
$files_size_live = $cs_files['files_size'];

if($cs_files['files_size'] >= 1024) 
{
	$files_size_live = $cs_files['files_size'] / 1024; 
	$size = 0;
}
if($cs_files['files_size'] >= 1024 * 1024)
{       
	$files_size_live = $cs_files['files_size'] / 1024 / 1024;
	$size = 1;
}
if($cs_files['files_size'] >= 1024 * 1024 * 1024)
{       
	$files_size_live = $cs_files['files_size'] / 1024 / 1024 / 1024;
	$size = 2;
}
		
if(!isset($_POST['submit'])) {
  echo $cs_lang['body_edit'];
}
elseif(!empty($error)) {
  echo $errormsg;
}

echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);


if(!empty($error) OR !isset($_POST['submit']))
{
	echo cs_html_form (1,'files_edit','files','edit',1);
	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'leftc');
	echo cs_icon('kedit') . $cs_lang['name'] . ' *';
	echo cs_html_roco(2,'leftb',0,2);
	echo cs_html_input('files_name',$cs_files['files_name'],'text',200,50);
	echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo cs_icon('package_editors') . 'Version' . ' *';
	echo cs_html_roco(2,'leftb',0,2);
	echo cs_html_input('files_version',$cs_files['files_version'],'text',5,5);
	echo cs_html_roco(0);
	
	echo cs_html_roco(1,'leftc');
	echo cs_icon('fileshare') . $cs_lang['size'] . ' *';
	echo cs_html_roco(2,'leftb',0,2);
	echo cs_html_input('files_size_live',$files_size_live,'text',20,5);
	echo cs_html_select(1,'size');
	$levels = 0;
	while($levels < 3) 
	{
		$size == $levels ? $sel = 1 : $sel = 0;
		echo cs_html_option($cs_lang['size_' . $levels],$levels,$sel);
		$levels++;
	}	 
	echo cs_html_select(0);	
	echo cs_html_roco(0);
	
	echo cs_html_roco(1,'leftc');
	echo cs_icon('folder_yellow') . $cs_lang['category'] . ' *';
	echo cs_html_roco(2,'leftb',0,2);
	echo cs_categories_dropdown('files',$cs_files['categories_id']);
	echo cs_html_roco(0);
	
	echo cs_html_roco(1,'leftc');
	echo cs_icon('kate') . $cs_lang['text'] . ' *';
	echo cs_html_br(2);
	echo cs_abcode_smileys('files_description');
	echo cs_html_roco(2,'leftb',0,2);
	echo cs_abcode_features('files_description');
	echo cs_html_textarea('files_description',$cs_files['files_description'],'50','10');
	echo cs_html_roco(0);
	
	if(isset($_POST['mirror']))
	{
		$run_loop = isset($_POST['run_loop']) ? $_POST['run_loop'] : 1;
	}
	else
	{
  		$files_mirror = $cs_files['files_mirror'];
		$temp = explode("-----", $files_mirror);
		$run_loop = count($temp);
	}
	
	for($run=1; $run < $run_loop; $run++)
	{
	  	$num = $run+1;
	 	if(isset($_POST['mirror']))
		{
			$cs_files["files_mirror_url_$num"] = isset($_POST["files_mirror_url_$num"]) ? $_POST["files_mirror_url_$num"] : 'http://server.net/data.zip';
			$cs_files["files_mirror_name_$num"] = isset($_POST["files_mirror_name_$num"]) ? $_POST["files_mirror_name_$num"] : 'Mirror ' . $num;
			$cs_files["files_mirror_ext_$num"] = isset($_POST["files_mirror_ext_$num"]) ? $_POST["files_mirror_ext_$num"] : 'zip';
			$cs_files["files_access_$num"] = isset($_POST["files_access_$num"]) ? $_POST["files_access_$num"] : 0;
		}
		else
		{
			$temp_a = explode("\n", $temp[$run]);
			$cs_files["files_mirror_url_$num"] = $temp_a['1'];
			$cs_files["files_mirror_name_$num"] = $temp_a['2'];
			$cs_files["files_mirror_ext_$num"] = $temp_a['3'];
			$cs_files["files_access_$num"] = $temp_a['4'];
		}
		echo cs_html_roco(1,'leftc',2);
		echo cs_icon('kedit') . $cs_lang['mirrors'] . ' ' . $run . ' *';
		echo cs_html_roco(2,'leftb');
		echo cs_icon('html') . $cs_lang['url'] . ' *';
		echo cs_html_input("files_mirror_url_$num",$cs_files["files_mirror_url_$num"],'text',200,30);
		echo cs_html_roco(3,'leftc');
		echo cs_icon('kedit') . $cs_lang['name'] . ' ';
		echo cs_html_input("files_mirror_name_$num",$cs_files["files_mirror_name_$num"],'text',50,20);
		echo cs_html_roco(0);
		echo cs_html_roco(2,'leftb');
		echo $cs_lang['extension'] . ' *';
		echo cs_html_input("files_mirror_ext_$num",$cs_files["files_mirror_ext_$num"],'text',10,5);
		echo cs_html_roco(3,'leftc');
		echo cs_icon('access') . $cs_lang['access'];
		echo cs_html_select(1,"files_access_$num");
		$levels = 0;
		while($levels < 6)
		{
			$cs_files["files_access_$num"] == $levels ? $sel = 1 : $sel = 0;
			echo cs_html_option($levels . ' - ' . $cs_lang['lev_' . $levels],$levels,$sel);
			$levels++;
		}
		echo cs_html_select(0);
		echo cs_html_roco(0);
	}
	
	echo cs_html_roco(1,'leftc');
	echo cs_icon('configure') . $cs_lang['more'];
	echo cs_html_roco(2,'leftb',0,2);
	echo cs_html_vote('files_close','1','checkbox',$cs_files['files_close']);
	echo $cs_lang['close']; 
	echo cs_html_br(1);
	echo cs_html_vote('files_vote','1','checkbox',$cs_files['files_vote']);
	echo $cs_lang['votes'];
	echo cs_html_br(1);
	echo cs_html_vote('files_newtime','1','checkbox',$files_newtime);
	echo $cs_lang['new_date']; 
	echo cs_html_br(1);
	echo cs_html_vote('files_newcount','1','checkbox',$files_newcount);
	echo $cs_lang['new_count'];
	echo cs_html_roco(0);
	
	echo cs_html_roco(1,'leftc');
	echo cs_icon('ksysguard') . $cs_lang['options'];
	echo cs_html_roco(2,'leftb',0,2);
	echo cs_html_vote('id',$files_id,'hidden');
	echo cs_html_vote('submit',$cs_lang['edit'],'submit');
	echo cs_html_vote('reset',$cs_lang['reset'],'reset');
	echo cs_html_vote('run_loop',$run_loop,'hidden');
	echo cs_html_vote('mirror',$cs_lang['mirrors+'],'submit');
	echo cs_html_roco(0);
	echo cs_html_table(0);
	echo cs_html_form(0);
}
else 
{
	
  	$files_cells = array_keys($cs_files);
  	$files_save = array_values($cs_files);
  	cs_sql_update(__FILE__,'files',$files_cells,$files_save,$files_id);

  	  cs_redirect($cs_lang['changes_done'], 'files') ;
} 

?>
