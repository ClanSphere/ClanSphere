<?php
// ClanSphere 2008 - www.clansphere.net 
// $Id$

$cs_lang = cs_translate('shoutbox');

if (empty($_POST['submit'])) {
  $data['lang']['info'] = $cs_lang['change_settings'];  
}
else {
  $cells = array('options_value');
  $where = 'options_mod = \'shoutbox\' AND options_name = ';
  
  $content = array((int) $_POST['max_text']);
  cs_sql_update(__FILE__,'options',$cells,$content,0,$where . '\'max_text\'');
  $content = array($_POST['order']);
  cs_sql_update(__FILE__,'options',$cells,$content,0,$where . '\'order\'');
  $content = array($_POST['linebreak']);
  cs_sql_update(__FILE__,'options',$cells,$content,0,$where . '\'linebreak\'');
  $content = array($_POST['limit']);
  cs_sql_update(__FILE__,'options',$cells,$content,0,$where . '\'limit\'');
  
  cs_redirect($cs_lang['success'],'shoutbox','options');
}

$opt = cs_sql_option(__FILE__,'shoutbox');

$data['lang']['getmsg'] = cs_getmsg();
$data['lang']['shoutbox'] = $cs_lang['mod'];
$data['lang']['options'] = $cs_lang['options'];

$sel = 'selected="selected"';

$data['lang']['max_text'] = $cs_lang['max_text'];
$data['lang']['figures'] = $cs_lang['figures'];
$data['op']['max_text'] = $opt['max_text'];
$data['op']['limit'] = $opt['limit'];
$data['op']['linebreak'] = $opt['linebreak'];
$data['selected']['desc'] = $opt['order'] == 'DESC' ? $sel : '';
$data['selected']['asc'] = $opt['order'] == 'ASC' ? $sel : '';
$data['lang']['save'] = $cs_lang['save'];
$data['lang']['reset'] = $cs_lang['reset'];
$data['form']['options'] = cs_url('shoutbox','options');

echo cs_subtemplate(__FILE__,$data,'shoutbox','options');
?>