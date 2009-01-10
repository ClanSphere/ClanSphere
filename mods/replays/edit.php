<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('replays');

$op_replays = cs_sql_option(__FILE__,'replays');
$rep_max['size'] = $op_replays['file_size'];
$rep_filetypes = explode(",", $op_replays['file_type']);

require_once('mods/categories/functions.php');

$replays_id = $_REQUEST['id'];
settype($replays_id,'integer');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['edit'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');

if(isset($_POST['submit'])) {

  $cs_replays['categories_id'] = empty($_POST['categories_name']) ? $_POST['categories_id'] : 
	cs_categories_create('replays',$_POST['categories_name']);

  $cs_replays['games_id'] = $_POST['games_id'];
	$cs_replays['replays_version'] = $_POST['replays_version'];
  $cs_replays['replays_team1'] = $_POST['replays_team1'];
  $cs_replays['replays_team2'] = $_POST['replays_team2'];
	$cs_replays['replays_date'] = cs_datepost('date','date');
  $cs_replays['replays_map'] = $_POST['replays_map'];
  $cs_replays['replays_mirrors'] = $_POST['replays_mirrors'];
  $cs_replays['replays_info'] = $_POST['replays_info'];
	$cs_replays['replays_close'] = isset($_POST['replays_close']) ? $_POST['replays_close'] : 0;

  $error = 0;
  $errormsg = '';

	if(!empty($_FILES['replay']['tmp_name'])) {
		$rep_size = filesize($_FILES['replay']['tmp_name']);
		$rep_ext = explode('.',$_FILES['replay']['name']);
		$who_ext = count($rep_ext) < 1 ? 0 : count($rep_ext) - 1;
		$extension = in_array($rep_ext[$who_ext],$rep_filetypes) ? $rep_ext[$who_ext] : 0;
	  if(empty($extension)) {

	    $errormsg .= $cs_lang['ext_error'] . cs_html_br(1);
			$error++;
	  }
	  if($_FILES['replay']['size']>$rep_max['size']) { 

	  $errormsg .= $cs_lang['too_big'] . cs_html_br(1);
	 	$error++;
		}

		$filename = 'replay-' . $replays_id . '-' . cs_time() . '.' . $extension;
	  if(empty($error) AND cs_upload('replays', $filename, $_FILES['replay']['tmp_name'])) {
			$replay_file = 'uploads/replays/' . $filename;
			$cs_replays['replays_mirrors'] = empty($cs_replays['replays_mirrors']) ? $replay_file : 
				$replay_file . "\n" . $cs_replays['replays_mirrors'];
		}
		else {
	    $errormsg .= $cs_lang['up_error'];
	    $error++;
	  }
	}

  if(empty($cs_replays['games_id'])) {
    $error++;
    $errormsg .= $cs_lang['no_game'] . cs_html_br(1);
  }
  if(empty($cs_replays['categories_id'])) {
    $error++;
    $errormsg .= $cs_lang['no_cat'] . cs_html_br(1);
  }
  if(empty($cs_replays['replays_version'])) {
    $error++;
    $errormsg .= $cs_lang['no_version'] . cs_html_br(1);
  }
  if(empty($cs_replays['replays_team2'])) {
    $error++;
    $errormsg .= $cs_lang['no_team1'] . cs_html_br(1);
  }
  if(empty($cs_replays['replays_team2'])) {
    $error++;
    $errormsg .= $cs_lang['no_team2'] . cs_html_br(1);
  }
  if(empty($cs_replays['replays_date'])) {
    $error++;
    $errormsg .= $cs_lang['no_date'] . cs_html_br(1);
  }
}
else {

  $cells = 'categories_id, games_id, replays_version, replays_team1, replays_team2, replays_date, replays_map, replays_mirrors, replays_info, replays_close';
  $cs_replays = cs_sql_select(__FILE__,'replays',$cells,"replays_id = '" . $replays_id . "'");
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

if(!empty($error) OR !isset($_POST['submit'])) {

  echo cs_html_form (1,'replays_edit','replays','edit',1);
  echo cs_html_table(1,'forum',1);
  
  echo cs_html_roco(1,'leftc');
	echo cs_icon('folder_yellow') . $cs_lang['category'] . ' *';
	echo cs_html_roco(2,'leftb');
	echo cs_categories_dropdown('replays',$cs_replays['categories_id']);
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('package_games') . $cs_lang['game'] . ' *';
  echo cs_html_roco(2,'leftb');
  $el_id = 'game_1';
  $onc = "document.getElementById('" . $el_id . "').src='" . $cs_main['php_self']['dirname'] . "uploads/games/' + this.form.";
  $onc .= "games_id.options[this.form.games_id.selectedIndex].value + '.gif'";
  echo cs_html_select(1,'games_id',"onchange=\"" . $onc . "\"");
	echo cs_html_option('----',0,0);
  $cs_games = cs_sql_select(__FILE__,'games','games_name,games_id',0,'games_name',0,0);
	$games_count = count($cs_games);
	for($run = 0; $run < $games_count; $run++) {
    $sel = $cs_games[$run]['games_id'] == $cs_replays['games_id'] ? 1 : 0;
    echo cs_html_option($cs_games[$run]['games_name'],$cs_games[$run]['games_id'],$sel);
  }
  echo cs_html_select(0) . ' ';
  $url = 'uploads/games/' . $cs_replays['games_id'] . '.gif';
  echo cs_html_img($url,0,0,'id="' . $el_id . '"');
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('kate') . $cs_lang['version'] . ' *';
  echo cs_html_roco(2,'leftb');
	echo cs_html_input('replays_version',$cs_replays['replays_version'],'text',40,20);
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('kdmconfig') . $cs_lang['team1'] . ' *';
  echo cs_html_roco(2,'leftb');
	echo cs_html_input('replays_team1',$cs_replays['replays_team1'],'text',80,40);
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('yast_group_add') . $cs_lang['team2'] . ' *';
  echo cs_html_roco(2,'leftb');
	echo cs_html_input('replays_team2',$cs_replays['replays_team2'],'text',80,40);
  echo cs_html_roco(0);	

  echo cs_html_roco(1,'leftc');
  echo cs_icon('1day') . $cs_lang['date'] . ' *';
  echo cs_html_roco(2,'leftb');
  echo cs_dateselect('date','date',$cs_replays['replays_date'],1995);
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('openterm') . $cs_lang['map'];
  echo cs_html_roco(2,'leftb',0,2);
	echo cs_html_input('replays_map',$cs_replays['replays_map'],'text',80,40);
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('download') . $cs_lang['upload'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('replay','','file');
	echo cs_html_br(2);
	$matches[1] = $cs_lang['rep_infos'];
	$return_types = '';
	foreach($rep_filetypes AS $add) {
		$return_types .= empty($return_types) ? $add : ', ' . $add;
	}
	$matches[2] = $cs_lang['max_size'] . cs_filesize($rep_max['size']) . cs_html_br(1);
	$matches[2] .= $cs_lang['filetypes'] . $return_types;
	echo cs_abcode_clip($matches);
  echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo cs_icon('download') . $cs_lang['mirrors'];
  echo cs_html_br(2);
	echo $cs_lang['seperate_by_enter'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_textarea('replays_mirrors',$cs_replays['replays_mirrors'],'50','4');
	echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo cs_icon('documentinfo') . $cs_lang['info'];
  echo cs_html_br(2);
  echo cs_abcode_smileys('replays_info');
	echo cs_html_roco(2,'leftb');
  echo cs_abcode_features('replays_info');
	echo cs_html_textarea('replays_info',$cs_replays['replays_info'],'50','8');
	echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo cs_icon('configure') . $cs_lang['more'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_vote('replays_close','1','checkbox',$cs_replays['replays_close']);
	echo $cs_lang['close'];
	echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('ksysguard') . $cs_lang['options'];
  echo cs_html_roco(2,'leftb');
	echo cs_html_vote('id',$replays_id,'hidden');
  echo cs_html_vote('submit',$cs_lang['edit'],'submit');
  echo cs_html_vote('reset',$cs_lang['reset'],'reset');
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_form(0);
}
else {

  $replays_cells = array_keys($cs_replays);
  $replays_save = array_values($cs_replays);
  cs_sql_update(__FILE__,'replays',$replays_cells,$replays_save,$replays_id);
  
  cs_redirect($cs_lang['changes_done'], 'replays') ;
} 
  
?>