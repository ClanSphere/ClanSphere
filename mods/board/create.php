<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

require_once('mods/categories/functions.php');
$data = array();

$data['create']['board_time'] = cs_time();
$data['create']['users_id'] = $account['users_id'];

if(isset($_POST['submit']) OR isset($_POST['preview'])) {
  $data['create']['categories_id'] = empty($_POST['categories_name']) ? $_POST['categories_id'] : 
  cs_categories_create('board',$_POST['categories_name']);
  $data['create']['board_access'] = $_POST['board_access'];
  $data['create']['board_name'] = $_POST['board_name'];
  $data['create']['board_text'] = $_POST['board_text'];
  $data['create']['board_pwd'] = $_POST['board_pwd'];
  $data['create']['squads_id'] = $_POST['squads_id'];
  $data['create']['board_read'] = $_POST['board_read'];

  $errormsg = '';

  if(empty($data['create']['categories_id'])) 
    $errormsg .= $cs_lang['no_cat'] . cs_html_br(1);
  if(empty($data['create']['board_name']))
    $errormsg .= $cs_lang['no_name'] . cs_html_br(1);
  if(empty($data['create']['board_text'])) 
    $errormsg .= $cs_lang['no_text'] . cs_html_br(1);
}
else {
  $data['create']['categories_id'] = 0;
  $data['create']['squads_id'] = 0;
  $data['create']['board_name'] = '';
  $data['create']['board_access'] = 0;
  $data['create']['board_text'] = ''; 
  $data['create']['board_pwd'] = '';
}

$data['if']['preview'] = false;

if(isset($_POST['preview']) AND empty($errormsg)) {
  $data['if']['preview'] = true;
  if(empty($data['create']['board_pwd']))
    $data['create']['board_ico'] = cs_icon('tutorials');
  else
    $data['create']['board_ico'] = cs_icon('password');  
  $data['create']['pre_text'] = cs_secure($data['create']['board_text'],1);
}

$data['if']['error'] = false;
if(!empty($errormsg)) {
  $data['if']['error'] = true;
  $data['if']['preview'] = false;
  $data['create']['errormsg'] = $errormsg;
}

if(!empty($errormsg) OR isset($_POST['preview']) OR !isset($_POST['submit'])) {
  $data['create']['cat_drop'] = cs_categories_dropdown2('board',$data['create']['categories_id']);
  $data['create']['ab_box'] = cs_abcode_features('board_text');

  $levels = 0;
  $sel = 0;
  while($levels < 6) {
    $data['create']['board_access'] == $levels ? $sel = 1 : $sel = 0;
    $data['access'][$levels]['access_level'] = cs_html_option($levels . ' - ' . $cs_lang['lev_' . $levels],$levels,$sel);
    $levels++;
  }
    
  $matches[1] = $cs_lang['secure_stages'];
  $matches[2] = $cs_lang['stage_1'] . $cs_lang['stage_1_text'] . cs_html_br(1);
  $matches[2] .= $cs_lang['stage_2'] . $cs_lang['stage_2_text'] . cs_html_br(1);
  $matches[2] .= $cs_lang['stage_3'] . $cs_lang['stage_3_text'] . cs_html_br(1);
  $matches[2] .= $cs_lang['stage_4'] . $cs_lang['stage_4_text'];
  $data['create']['sec_level'] = cs_abcode_clip($matches);
  
  $op_squads = cs_sql_option(__FILE__,'squads');
  $data['create']['squad_lang'] = $cs_lang[$op_squads['label']];
  $data_squads = cs_sql_select(__FILE__,'squads','squads_name,squads_id','squads_own=1','squads_name',0,0); 
  $data['create']['squad_drop'] = cs_dropdown('squads_id','squads_name',$data_squads,$data['create']['squads_id']);   
}
else 
{
  global $cs_db;
  if(!empty($data['create']['board_pwd'])) {
    if($cs_db['hash'] == 'md5') 
      $data['create']['board_pwd'] = md5($data['create']['board_pwd']);
    elseif($cs_db['hash'] == 'sha1')
      $data['create']['board_pwd'] = sha1($data['create']['board_pwd']);
  }
  $board_cells = array_keys($data['create']);
  $board_save = array_values($data['create']);
  cs_sql_insert(__FILE__,'board',$board_cells,$board_save);

  cs_redirect($cs_lang['create_done'],'board');
} 

echo cs_subtemplate(__FILE__,$data,'board','create');