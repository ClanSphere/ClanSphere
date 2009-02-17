<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');

$data = array();
$data['options'] = cs_sql_option(__FILE__,'users');
$files = cs_files();

if(isset($_POST['submit'])) {
  
  $error = '';
  
  settype($_POST['max_width'],'integer');
  settype($_POST['max_height'],'integer');
  settype($_POST['max_size'],'integer');
  settype($_POST['min_letters'],'integer');
  settype($_POST['def_register'],'integer');
  settype($_POST['def_picture_on'],'integer');
  if (!empty($files['def_picture']['tmp_name'])) $_POST['def_picture_on'] = 1;

  $opt_where = "options_mod = 'users' AND options_name = ";
  $def_cell = array('options_value');
  $def_cont = array($_POST['max_width']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'max_width'");
  $def_cont = array($_POST['max_height']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'max_height'");
  $def_cont = array($_POST['max_size']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'max_size'");
  $def_cont = array($_POST['min_letters']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'min_letters'");
  $def_cont = array($_POST['def_register']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'def_register'");
  $def_cont = array($_POST['register']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'register'");
  $def_cont = array($_POST['def_picture_on']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'def_picture'");
  
  if (!empty($_POST['def_picture_on']) && empty($data['options']['def_picture']))
    cs_sql_update(__FILE__, 'users', array('users_picture'), array('nopicture.jpg'), 0, "users_picture = ''");
  elseif (empty($_POST['def_picture_on']) && !empty($data['options']['def_picture']))
    cs_sql_update(__FILE__, 'users', array('users_picture'), array(''), 0, "users_picture = 'nopicture.jpg'");
  
  $data['link']['continue'] = cs_url('clansphere','system');
  $data['lang']['head'] = $cs_lang['options'];
  
  if (!empty($files['def_picture']['tmp_name'])) {
    
    $img_size = getimagesize($files['def_picture']['tmp_name']);
    $ext = strtolower(substr($files['def_picture']['tmp_name'],strrpos($files['def_picture']['tmp_name'],'.')+1));
    
    if ($ext != 'jpg' && $ext != 'jpeg') $error .= cs_html_br(1) . $cs_lang['ext_error'];
    if ($files['def_picture']['size'] > $_POST['max_size']) $error .= cs_html_br(1) . $cs_lang['too_big'];
    if ($img_size[0] > $_POST['max_width']) $error .= cs_html_br(1) . $cs_lang['too_wide'];
    if ($img_size[1] > $_POST['max_height']) $error .= cs_html_br(1) . $cs_lang['too_high'];
    
    if (empty($error)) cs_upload('users','nopicture.jpg',$files['def_picture']['tmp_name']);
  }
  
  if (empty($error)) echo cs_subtemplate(__FILE__,$data,'users','done');
  
}

if(!isset($_POST['submit']) || !empty($error)) {

  $data['dropdown']['def_register'] = cs_html_select(1,'def_register');
  $sel = $data['options']['def_register'] == '0' ? 1 : 0;
  $data['dropdown']['def_register'] .= cs_html_option($cs_lang['reg_captcha'],0,$sel);
  $sel = $data['options']['def_register'] == '1' ? 1 : 0;
  $data['dropdown']['def_register'] .= cs_html_option($cs_lang['reg_mail'],1,$sel);
  $sel = $data['options']['def_register'] == '2' ? 1 : 0;
  $data['dropdown']['def_register'] .= cs_html_option($cs_lang['reg_captcha_mail'],2,$sel);
  $data['dropdown']['def_register'] .= cs_html_select(0);

  $sel = empty($data['options']['register']) ? 1 : 0;
  $data['options']['register_off'] = cs_html_option($cs_lang['off'],0,$sel);
  $sel = !empty($data['options']['register']) ? 1 : 0;
  $data['options']['register_on'] =  cs_html_option($cs_lang['on'],1,$sel);
  
  $data['selected']['def_picture'] = empty($data['options']['def_picture']) ? '' : 'checked="checked" ';
  
  echo cs_subtemplate(__FILE__,$data,'users','options');
  
}

?>