<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('count');

if(isset($_POST['submit'])) {
  
  $save = array();
  $save['width'] = (int) $_POST['width'];
  $save['height'] = (int) $_POST['height'];
  $save['background'] = $_POST['background'];
  $save['textsize'] = $_POST['textsize'];
  $save['textcolor'] = $_POST['textcolor'];
  $save['textballoncolor'] = $_POST['textballoncolor'];
  $save['axescolor'] = $_POST['axescolor'];
  $save['indicatorcolor'] = $_POST['indicatorcolor'];
  $save['graphcolor1'] = $_POST['graphcolor1'];
  $save['graphcolor2'] = $_POST['graphcolor2'];
  $save['view'] = $_POST['view'];

  require_once 'mods/clansphere/func_options.php';
  
  cs_optionsave('count', $save);
  
  cs_redirect($cs_lang['changes_done'], 'options', 'roots');
  
} else {
  
  $data = array();
  
  $data['count'] = cs_sql_option(__FILE__,'count');
  
  $data['count']['stats'] = $data['count']['view'] == 'stats' ? 'selected="selected"' : '';
  $data['count']['amstats'] = $data['count']['view'] == 'amstats' ? 'selected="selected"' : '';

  echo cs_subtemplate(__FILE__,$data,'count','options');
}