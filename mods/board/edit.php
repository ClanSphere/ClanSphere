<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');
$cs_post = cs_post('id');
$cs_get = cs_get('id');

$board_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $board_id = $cs_post['id'];

require_once('mods/categories/functions.php');
$data = array();

#$board_id = $_REQUEST['id'];
#settype($board_id,'integer');
$board_pwdel = 0;
$new_board_pwd = '';

$data['board']['id'] = $board_id;

if(isset($_POST['submit']) OR isset($_POST['preview'])) {
  $data['edit']['categories_id'] = empty($_POST['categories_name']) ? $_POST['categories_id'] : 
  cs_categories_create('board',$_POST['categories_name']);
  $data['edit']['board_access'] = $_POST['board_access'];
  $data['edit']['board_name'] = $_POST['board_name'];
  $data['edit']['board_text'] = $_POST['board_text'];
  $data['edit']['board_pwd'] = $_POST['new_board_pwd'];
  $data['edit']['squads_id'] = $_POST['squads_id'];
  $data['edit']['board_read'] = $_POST['board_read'];
  $new_board_pwd = $_POST['new_board_pwd']; 

  if(!empty($_POST['board_pwdel']))  
    $board_pwdel = $_POST['board_pwdel'];

  $errormsg = '';

  if(empty($data['edit']['categories_id'])) 
    $errormsg .= $cs_lang['no_cat'] . cs_html_br(1);
  if(empty($data['edit']['board_name']))
    $errormsg .= $cs_lang['no_name'] . cs_html_br(1);
  if(empty($data['edit']['board_text'])) 
    $errormsg .= $cs_lang['no_text'] . cs_html_br(1);
}
else {
  $cells = 'categories_id, board_name, board_text, users_id, board_time, board_access, board_pwd, squads_id, board_read';
  $data['edit'] = cs_sql_select(__FILE__,'board',$cells,"board_id = '" . $board_id . "'");
}

$data['if']['preview'] = false;

if(isset($_POST['preview']) AND empty($errormsg)) {
	$data['if']['preview'] = true;
  if(empty($data['edit']['board_pwd']))
    $data['edit']['board_ico'] = cs_icon('tutorials');
  else
    $data['edit']['board_ico'] = cs_icon('password');  
  $data['edit']['pre_text'] = cs_secure($data['edit']['board_text'],1);
}

$data['if']['error'] = false;
if(!empty($errormsg)) {
	$data['if']['error'] = true;
  $data['if']['preview'] = false;
  $data['edit']['errormsg'] = $errormsg;
}

if(!empty($errormsg) OR isset($_POST['preview']) OR !isset($_POST['submit'])) {
  $data['edit']['cat_drop'] = cs_categories_dropdown2('board',$data['edit']['categories_id']);
	$data['edit']['ab_box'] = cs_abcode_features('board_text');

  $levels = 0;
  $sel = 0;
  while($levels < 6) {
    $data['edit']['board_access'] == $levels ? $sel = 1 : $sel = 0;
    $data['access'][$levels]['access_level'] = cs_html_option($levels . ' - ' . $cs_lang['lev_' . $levels],$levels,$sel);
    $levels++;
  }
	
  $checked1 = !empty($data['edit']['board_read']) ? 'checked' : 0;
  $checked2 = !empty($data['edit']['board_read']) ? 0 : 'checked';
  $data['edit']['check_yes'] = cs_html_input('board_read',1,'radio',0,0,$checked1);
  $data['edit']['check_no'] = cs_html_input('board_read',0,'radio',0,0,$checked2);
	
  $matches[1] = $cs_lang['secure_stages'];
  $matches[2] = $cs_lang['stage_1'] . $cs_lang['stage_1_text'] . cs_html_br(1);
  $matches[2] .= $cs_lang['stage_2'] . $cs_lang['stage_2_text'] . cs_html_br(1);
  $matches[2] .= $cs_lang['stage_3'] . $cs_lang['stage_3_text'] . cs_html_br(1);
  $matches[2] .= $cs_lang['stage_4'] . $cs_lang['stage_4_text'];
  $data['edit']['sec_level'] = cs_abcode_clip($matches);

  if(!empty($data['edit']['board_pwd']))
  {       
    echo cs_html_roco(1,'leftc');
    echo cs_icon('configure') . $cs_lang['more'];
    echo cs_html_roco(2,'leftb');
    echo cs_html_vote('board_pwdel','1','checkbox',$board_pwdel);
    echo $cs_lang['board_pwddel'];
    echo cs_html_roco(0);
  } 

	$op_squads = cs_sql_option(__FILE__,'squads');
  $data['edit']['squad_lang'] = $cs_lang[$op_squads['label']];
  $data_squads = cs_sql_select(__FILE__,'squads','squads_name,squads_id','squads_own=1','squads_name',0,0); 
  $data['edit']['squad_drop'] = cs_dropdown('squads_id','squads_name',$data_squads,$data['edit']['squads_id']);   
}
else 
{
  if(!empty($new_board_pwd))
  {
    global $cs_db;
      if($cs_db['hash'] == 'md5')
          $data['edit']['board_pwd'] = md5($new_board_pwd);
           elseif($cs_db['hash'] == 'sha1') 
         $data['edit']['board_pwd'] = sha1($new_board_pwd);
       $sql_del = 1;
    }
  if(!empty($board_pwdel))
  {
    $data['edit']['board_pwd'] = '';  
    $sql_del = 1;
  }
  if(!empty($sql_del))
  {
    $board_pws_sql = cs_sql_select(__FILE__,'boardpws','boardpws_id',"board_id = '" . $board_id . "'",0,0,0);
    if(!empty($board_pws_sql))
    {
      foreach($board_pws_sql AS $value)
      {
        cs_sql_delete(__FILE__,'boardpws',$value['boardpws_id']);
      }
    }
  }
  $board_cells = array_keys($data['edit']);
  $board_save = array_values($data['edit']);
  cs_sql_update(__FILE__,'board',$board_cells,$board_save,$board_id);

  cs_redirect($cs_lang['changes_done'], 'board') ;
} 

echo cs_subtemplate(__FILE__,$data,'board','edit');

?>