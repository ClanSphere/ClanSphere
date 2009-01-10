<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('fckeditor');

$data = array();
$data['head']['action'] = $cs_lang['options'];
$data['head']['topline'] = $cs_lang['options_info'];

$op_fck = cs_sql_option(__FILE__,'fckeditor');

if(isset($_POST['submit'])) {

  settype($_POST['mode'],'integer');

  $opt_where = "options_mod = 'fckeditor' AND options_name = ";
  $def_cell = array('options_value');
  $def_cont = array($_POST['mode']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'mode'");
  $def_cont = array($_POST['skin']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'skin'");
  $def_cont = array($_POST['height']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'height'");

  $data['head']['topline'] = $cs_lang['changes_done'];
}

$data['op']['mode'] = isset($_POST['mode']) ? $_POST['mode'] : $op_fck['mode'];
$data['op']['mode_off'] = empty($data['op']['mode']) ? ' checked="checked"' : '';
$data['op']['mode_on'] = empty($data['op']['mode']) ? '' : ' checked="checked"';

$data['op']['height'] = isset($_POST['height']) ? $_POST['height'] : $op_fck['height'];

$skin[0]['skin'] = 'default';
$skin[0]['path'] = 'default';
$skin[1]['skin'] = 'office2003';
$skin[1]['path'] = 'office2003';
$skin[2]['skin'] = 'silver';
$skin[2]['path'] = 'silver';
$new_skin = isset($_POST['skin']) ? $_POST['skin'] : $op_fck['skin'];
$data['op']['skin'] = cs_dropdown('skin','path',$skin,$new_skin);

echo cs_subtemplate(__FILE__,$data,'fckeditor','options');

?>