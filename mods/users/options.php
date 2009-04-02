<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');

$data = array();
$data['options'] = cs_sql_option(__FILE__,'users');

$files = cs_files();

if(isset($_POST['submit'])) {

  require 'mods/clansphere/func_options.php';
	$error = '';
  $save = array();

  $save['max_width'] = (int) $_POST['max_width'];
  $save['max_height'] = (int) $_POST['max_height'];
  $save['max_size'] = (int) $_POST['max_size'];
  $save['min_letters'] = (int) $_POST['min_letters'];
  $save['def_register'] = (int) $_POST['def_register'];
  $save['register'] = $_POST['register'];
  $save['def_picture'] = !empty($_POST['def_picture_on']) ? 1 : 0;
  if(!empty($files['def_picture']['tmp_name'])) $save['def_picture'] =  1;

  cs_optionsave('users', $save);

  if (!empty($save['def_picture']) && empty($data['options']['def_picture']))
    cs_sql_update(__FILE__, 'users', array('users_picture'), array('nopicture.jpg'), 0, "users_picture = ''");
  elseif (empty($save['def_picture']) && !empty($data['options']['def_picture']))
    cs_sql_update(__FILE__, 'users', array('users_picture'), array(''), 0, "users_picture = 'nopicture.jpg'");

  $data['link']['continue'] = cs_url('clansphere','system');
  $data['lang']['head'] = $cs_lang['options'];

  if (!empty($files['def_picture']['tmp_name'])) {
    $img_size = getimagesize($files['def_picture']['tmp_name']);

    if ($files['def_picture']['type'] != 'image/jpeg') $error .= cs_html_br(1) . $cs_lang['ext_error'];
    if ($files['def_picture']['size'] > $_POST['max_size']) $error .= cs_html_br(1) . $cs_lang['too_big'];
    if ($img_size[0] > $_POST['max_width']) $error .= cs_html_br(1) . $cs_lang['too_wide'];
    if ($img_size[1] > $_POST['max_height']) $error .= cs_html_br(1) . $cs_lang['too_high'];
    if (empty($error)) cs_upload('users','nopicture.jpg',$files['def_picture']['tmp_name']);
  }

  if (empty($error)) cs_redirect($cs_lang['success'], 'options', 'roots');
}

if(!isset($_POST['submit']) || !empty($error)) {

	if (!empty($error)) $data['lang']['manage_options'] = $cs_lang['error_occured'] . $error;
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
  $data['img']['nopic'] = cs_html_img('uploads/users/nopic.jpg');

  echo cs_subtemplate(__FILE__,$data,'users','options');
}

?>