<?php
//CLANSPHERE.de CMS /mods/count/options.php
//Freitag, 8. Februar 2008 15:54:53

$cs_lang = cs_translate('count');

$op_count = cs_sql_option(__FILE__,'count');

if(isset($_POST['submit'])) {
  settype($_POST['width'],'integer');
  settype($_POST['height'],'integer');

  $opt_where = "options_mod = 'count' AND options_name = ";
  $def_cell = array('options_value');

  $def_cont = array($_POST['width']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'width'");

  $def_cont = array($_POST['height']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'height'");

  $def_cont = array($_POST['background']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'background'");

  $def_cont = array($_POST['textsize']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'textsize'");

  $def_cont = array($_POST['textcolor']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'textcolor'");

  $def_cont = array($_POST['textballoncolor']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'textballoncolor'");

  $def_cont = array($_POST['axescolor']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'axescolor'");

  $def_cont = array($_POST['indicatorcolor']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'indicatorcolor'");

  $def_cont = array($_POST['graphcolor1']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'graphcolor1'");

  $def_cont = array($_POST['graphcolor2']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'graphcolor2'");

  $def_cont = array($_POST['view']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'view'");
  
  cs_redirect($cs_lang['changes_done'],'count','options');
}
else {
  $data['lang']['getmsg'] = cs_getmsg();
  $data['url']['form'] = cs_url('count','options');
  
  if($op_count['view'] == 'stats') {
    $data['count']['stats'] = 'selected="selected"';
  }
  else {
    $data['count']['stats'] = '';
  }
  
  if($op_count['view'] == 'amstats') {
    $data['count']['amstats'] = 'selected="selected"';
  }
  else {
    $data['count']['amstats'] = '';
  }
  
  $data['count']['width']      = $op_count['width'];
  $data['count']['height']      = $op_count['height'];
  $data['count']['background']    = $op_count['background'];
  $data['count']['textsize']    = $op_count['textsize'];
  $data['count']['textcolor']    = $op_count['textcolor'];
  $data['count']['textballoncolor']  = $op_count['textballoncolor'];
  $data['count']['axescolor']    = $op_count['axescolor'];
  $data['count']['indicatorcolor']  = $op_count['indicatorcolor'];
  $data['count']['graphcolor1']    = $op_count['graphcolor1'];
  $data['count']['graphcolor2']    = $op_count['graphcolor2'];

  echo cs_subtemplate(__FILE__,$data,'count','options');
}
?>