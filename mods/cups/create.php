<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cups');

require_once 'mods/categories/functions.php';

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['create'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc');

$cs_cups['cups_name'] = empty($_POST['cups_name']) ? '' : $_POST['cups_name'];
$cs_cups['games_id'] = empty($_POST['games_id']) ? 0 : (int) $_POST['games_id'];
$cs_cups['cups_teams'] = empty($_POST['cups_teams']) ? 0 : (int) $_POST['cups_teams'];
$cs_cups['cups_start'] = cs_datepost('cups_start','unix');
$cs_cups['cups_system'] = empty($_POST['cups_system']) ? '' : $_POST['cups_system'];
$cs_cups['cups_text'] = empty($_POST['cups_text']) ? '' : $_POST['cups_text'];
$cs_cups['cups_brackets'] = empty($_POST['cups_brackets']) ? 0 : 1;

if (isset($_POST['submit'])) {
  
  $error = '';
  
  if (empty($cs_cups['cups_name'])) {
    $error .= cs_html_br(1) . $cs_lang['no_name'];
  }
  if (empty($cs_cups['games_id'])) {
    $error .= cs_html_br(1) . $cs_lang['no_game'];
  }
  if (empty($cs_cups['cups_teams'])) {
    $error .= cs_html_br(1) . $cs_lang['no_maxteams'];
  }
  
  if (substr_count(decbin($cs_cups['cups_teams']),'1') != 1) {
    $error .= cs_html_br(1) . $cs_lang['wrong_maxteams'];
  }
}

if(empty($_POST['submit']) || !empty($error)) {
  
  echo empty($error) ? $cs_lang['create_new_cup'] : $cs_lang['error_occured'] . $error;
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_br(1);
  
  echo cs_html_form(1,'cupscreate','cups','create');
  echo cs_html_table(1,'forum',1);
  
  echo cs_html_roco(1,'leftc');
  echo cs_icon('kate') . $cs_lang['name'] . ' *';
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('cups_name',$cs_cups['cups_name'],'text',100,35);
  echo cs_html_roco(0);
  
  echo cs_html_roco(1,'leftc');
  echo cs_icon('package_games') . $cs_lang['game'] . ' *';
  echo cs_html_roco(2,'leftb');
  echo cs_html_select(1,'games_id',"onchange=\"cs_gamechoose(this.form)\"");
    echo cs_html_option('----',0,1);
  $cs_games = cs_sql_select(__FILE__,'games','games_name,games_id',0,'games_name',0,0);
  $games_count = count($cs_games);
  for($run = 0; $run < $games_count; $run++) {
      echo cs_html_option($cs_games[$run]['games_name'],$cs_games[$run]['games_id'],0);
  }
  echo cs_html_select(0);
  echo cs_html_img('uploads/games/0.gif',0,0,'id="game_1"');
  echo cs_html_roco(0);
  
  echo cs_html_roco(1,'leftc');
  echo cs_icon('folder_yellow') . $cs_lang['cup_system'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_select(1,'cups_system');
  $cups_system = empty($cs_cups['cups_system']) ? 'teams' : $cs_cups['cups_system'];
  echo cs_html_option($cs_lang['teams'],'teams',$cups_system == 'teams' ? 1 : 0);
  echo cs_html_option($cs_lang['users'],'users',$cups_system == 'users' ? 1 : 0);
  echo cs_html_select(0);
  echo cs_html_roco(0);
  
  echo cs_html_roco(1,'leftc');
  echo cs_icon('folder_yellow') .$cs_lang['kind_of_cup'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_select(1,'cups_brackets');
  echo cs_html_option($cs_lang['ko'],0,empty($cs_cups['cups_brackets']) ? 1 : 0);
  echo cs_html_option($cs_lang['brackets'],1,!empty($cs_cups['cups_brackets']) ? 1 : 0);
  echo cs_html_select(0);
  echo cs_html_roco(0);
  
  echo cs_html_roco(1,'leftc');
  echo cs_icon('kdmconfig') . $cs_lang['max_teams'] . ' *';
  echo cs_html_roco(2,'leftb');
  $cups_teams = empty($cs_cups['cups_teams']) ? 32 : $cs_cups['cups_teams'];
  echo cs_html_input('cups_teams',$cups_teams,'text',6,6);
  echo cs_html_roco(0);
  
  echo cs_html_roco(1,'leftc');
  echo cs_icon('kate') . $cs_lang['text'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_textarea('cups_text',$cs_cups['cups_text'],40,20);
  echo cs_html_roco(0);  
  
  echo cs_html_roco(1,'leftc');
  echo cs_icon('1day') . $cs_lang['cup_start'];
  echo cs_html_roco(2,'leftb'); 
  $cups_start = empty($cs_cups['cups_start']) ? cs_time() : $cs_cups['cups_start'];
  echo cs_dateselect('cups_start','unix',$cups_start,2000);
  echo cs_html_roco(0);
  
  echo cs_html_roco(1,'leftc');
  echo cs_icon('ksysguard') . $cs_lang['options'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('submit',$cs_lang['create'],'submit');
  echo cs_html_roco(0);
  
  echo cs_html_table(0);
  echo cs_html_form(0);
  
} else {
    
  $cells = array_keys($cs_cups);
  $values = array_values($cs_cups);
  
  cs_sql_insert(__FILE__,'cups',$cells,$values);
  
  cs_redirect($cs_lang['create_done'],'cups');
  
}

?>