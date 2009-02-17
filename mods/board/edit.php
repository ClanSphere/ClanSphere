<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

require_once('mods/categories/functions.php');

$board_id = $_REQUEST['id'];
settype($board_id,'integer');
$board_pwdel = 0;
$new_board_pwd = '';

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_edit'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');

if(isset($_POST['submit']) OR isset($_POST['preview'])) 
{
  $cs_board['categories_id'] = empty($_POST['categories_name']) ? $_POST['categories_id'] : 
  cs_categories_create('board',$_POST['categories_name']);
  $cs_board['board_access'] = $_POST['board_access'];
  $cs_board['board_name'] = $_POST['board_name'];
  $cs_board['board_text'] = $_POST['board_text'];
  $cs_board['board_time'] = $_POST['board_time']; 
  $cs_board['board_pwd'] = $_POST['board_pwd'];
  $cs_board['users_id'] = $_POST['users_id'];  
  $cs_board['squads_id'] = $_POST['squads_id'];
  $cs_board['board_read'] = $_POST['board_read'];
  $new_board_pwd = $_POST['new_board_pwd']; 
  
  if(!empty($_POST['board_pwdel']))  
    $board_pwdel = $_POST['board_pwdel'];

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
  $cells = 'categories_id, board_name, board_text, users_id, board_time, board_access, board_pwd, squads_id, board_read';
  $cs_board = cs_sql_select(__FILE__,'board',$cells,"board_id = '" . $board_id . "'");
}
if(!isset($_POST['submit']) AND !isset($_POST['preview'])) 
{
  echo $cs_lang['body_edit'];
}
elseif(!empty($error)) 
{
  echo $errormsg;
}
elseif(isset($_POST['preview'])) 
{
  echo $cs_lang['preview'];
}

echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

if(isset($_POST['preview']) AND empty($error)) 
{
  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'leftb',0,0,15);
  echo cs_icon('tutorials');
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
  echo cs_html_br(2);
}

if(!empty($error) OR isset($_POST['preview']) OR !isset($_POST['submit'])) 
{
  echo cs_html_form (1,'board_edit','board','edit');
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
  $checked1 = !empty($cs_board['board_read']) ? 'checked' : 0;
  $checked2 = !empty($cs_board['board_read']) ? 0 : 'checked';
    echo cs_html_input('board_read',1,'radio',0,0,$checked1) . $cs_lang['yes'];
  echo cs_html_input('board_read',0,'radio',0,0,$checked2) . $cs_lang['no'];
    echo cs_html_roco(0);
        
   echo cs_html_roco(1,'leftc');
   if(!empty($cs_board['board_pwd']))
   {
           echo cs_icon('password') . $cs_lang['password_yes'];
           $more = $cs_lang['password2'];
   }
   else
   {
     echo cs_icon('password') . $cs_lang['password_no'];
     $more = $cs_lang['password1'];
  }
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('new_board_pwd',$new_board_pwd,'password',30,30,'onkeydown="javascript:passwordcheck(this.value);" onkeyup="javascript:passwordcheck(this.value);"','form') .cs_html_br(1). $more;
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

  if(!empty($cs_board['board_pwd']))
  {       
    echo cs_html_roco(1,'leftc');
    echo cs_icon('configure') . $cs_lang['more'];
    echo cs_html_roco(2,'leftb');
    echo cs_html_vote('board_pwdel','1','checkbox',$board_pwdel);
    echo $cs_lang['board_pwddel'];
    echo cs_html_roco(0);
  } 
  
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
  echo cs_html_vote('users_id',$cs_board['users_id'],'hidden');
  echo cs_html_vote('board_time',$cs_board['board_time'],'hidden');
  echo cs_html_vote('id',$board_id,'hidden'); 
  echo cs_html_vote('board_pwd',$cs_board['board_pwd'],'hidden');
  echo cs_html_vote('submit',$cs_lang['edit'],'submit');
  echo cs_html_vote('preview',$cs_lang['preview'],'submit');
  echo cs_html_vote('reset',$cs_lang['reset'],'reset');
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_form(0);
}
else 
{       
  if(!empty($new_board_pwd))
  {
    global $cs_db;
      if($cs_db['hash'] == 'md5')
          $cs_board['board_pwd'] = md5($new_board_pwd);
           elseif($cs_db['hash'] == 'sha1') 
         $cs_board['board_pwd'] = sha1($new_board_pwd);
       $sql_del = 1;
    }
  if(!empty($board_pwdel))
  {
    $cs_board['board_pwd'] = '';  
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
  $board_cells = array_keys($cs_board);
  $board_save = array_values($cs_board);
  cs_sql_update(__FILE__,'board',$board_cells,$board_save,$board_id);
  
    cs_redirect($cs_lang['changes_done'], 'board') ;
} 
?>