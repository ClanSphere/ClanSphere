<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');
$cs_post = cs_post('id');
$cs_get = cs_get('id');
$data = array();

$board_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $board_id = $cs_post['id'];

require_once('mods/categories/functions.php');

$board_pwdel = 0;
$new_board_pwd = '';
$data['if']['preview'] = false;


if(isset($_POST['submit']) OR isset($_POST['preview'])) {

  $board['categories_id'] = empty($_POST['categories_name']) ? $_POST['categories_id'] : 
  cs_categories_create('board',$_POST['categories_name']);
  $board['board_access'] = $_POST['board_access'];
  $board['board_name'] = $_POST['board_name'];
  $board['board_text'] = $_POST['board_text'];
  $board['board_read'] = isset($_POST['board_read']) ? $_POST['board_read'] : '';
  $board['board_pwd'] = $_POST['new_board_pwd'];
  $board['squads_id'] = $_POST['squads_id'];
  $new_board_pwd = $_POST['new_board_pwd']; 

  if(!empty($_POST['board_pwdel']))  
    $board_pwdel = $_POST['board_pwdel'];

  $error = '';

  if(empty($board['categories_id'])) 
    $error .= $cs_lang['no_cat'] . cs_html_br(1);
  if(empty($board['board_name']))
    $error .= $cs_lang['no_name'] . cs_html_br(1);
  if(empty($board['board_text'])) 
    $error .= $cs_lang['no_text'] . cs_html_br(1);
}
else {
  $cells = 'categories_id, board_name, board_text, users_id, board_time, board_access, board_pwd, squads_id, board_read';
  $board = cs_sql_select(__FILE__,'board',$cells,"board_id = '" . $board_id . "'");
}


if(!isset($_POST['submit']) OR isset($_POST['preview']))
  $data['head']['body'] = $cs_lang['body_edit'];
elseif(!empty($error))
  $data['head']['body'] = $error;


if(isset($_POST['preview']) AND empty($error)) {
  $data['if']['preview'] = TRUE;
  if(!empty($board['board_pwd'])) {
    $data['prev']['icon'] = cs_html_img('symbols/board/password.png');
  }elseif(!empty($board['squads_id'])) {
    $data['prev']['icon'] = cs_html_img('symbols/board/board_read_.png');
  }else{
    $data['prev']['icon'] = cs_icon('password');
  }
  $data['prev']['text'] = cs_secure($board['board_text'],1);
}


if(!empty($error) OR isset($_POST['preview']) OR !isset($_POST['submit'])) {

  $data['data'] = $board;

  $data['categories']['dropdown'] = cs_categories_dropdown2('board',$board['categories_id']);
  $data['abcode']['features'] = cs_abcode_features('board_text');

  $data['access']['options'] = '';
  $levels = 0;
  while($levels < 6) {
    $board['board_access'] == $levels ? $sel = 1 : $sel = 0;
    $data['access']['options'] .= cs_html_option($levels . ' - ' . $cs_lang['lev_' . $levels],$levels,$sel);
    $levels++;
  }
  
  $checked = 'checked="checked"';
  $data['check']['yes'] = !empty($board['board_read']) ? $checked : '';
  $data['check']['no'] = empty($board['board_read']) ? $checked : '';
  
  
  $matches[1] = $cs_lang['secure_stages'];
  $matches[2] = $cs_lang['stage_1'] . $cs_lang['stage_1_text'] . cs_html_br(1);
  $matches[2] .= $cs_lang['stage_2'] . $cs_lang['stage_2_text'] . cs_html_br(1);
  $matches[2] .= $cs_lang['stage_3'] . $cs_lang['stage_3_text'] . cs_html_br(1);
  $matches[2] .= $cs_lang['stage_4'] . $cs_lang['stage_4_text'];
  $data['clip']['sec_level'] = cs_abcode_clip($matches);

  $data['if']['pwd_remove'] = !empty($board['board_pwd']) ? TRUE : FALSE;

  $op_squads = cs_sql_option(__FILE__,'squads');
  $data['squads']['lang'] = $cs_lang[$op_squads['label']];
  $data_squads = cs_sql_select(__FILE__,'squads','squads_name,squads_id','squads_own=1','squads_name',0,0); 
  $data['squads']['dropdown'] = cs_dropdown('squads_id','squads_name',$data_squads,$board['squads_id']);   
  
  $data['board']['id'] = $board_id;


 echo cs_subtemplate(__FILE__,$data,'board','edit');
}
else {

  if(!empty($new_board_pwd)) {
    global $cs_db;
    if($cs_db['hash'] == 'md5')
      $board['board_pwd'] = md5($new_board_pwd);
    elseif($cs_db['hash'] == 'sha1') 
      $board['board_pwd'] = sha1($new_board_pwd);
      $sql_del = 1;
  }
  
  if(!empty($board_pwdel)) {
    $board['board_pwd'] = '';  
    $sql_del = 1;
  }
  if(!empty($sql_del)) {
    $board_pws_sql = cs_sql_select(__FILE__,'boardpws','boardpws_id',"board_id = '" . $board_id . "'",0,0,0);
    if(!empty($board_pws_sql)) {
      foreach($board_pws_sql AS $value) {
        cs_sql_delete(__FILE__,'boardpws',$value['boardpws_id']);
      }
    }
  }
  $board_cells = array_keys($board);
  $board_save = array_values($board);
 cs_sql_update(__FILE__,'board',$board_cells,$board_save,$board_id);

 cs_redirect($cs_lang['changes_done'], 'board') ;
} 