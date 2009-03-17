<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('messages');
$data = array();

$cs_messages = cs_sql_option(__FILE__,'messages');


if(isset($_POST['submit'])) {
  
	$del_time = (int) $_POST['del_time'];
	$max_space = (int) $_POST['max_space'];
  
  $opt_where = 'options_mod=\'messages\' AND options_name=';
  $def_cell = array('options_value');
  $def_cont = array($del_time);
 cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . '\'del_time\'');
  $def_cont = array($max_space);
 cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . '\'max_space\'');

 cs_redirect($cs_lang['changes_done'],'messages','options');

}
else {

	$data['head']['getmsg'] = cs_getmsg();

  $data['op']['del_time'] = $cs_messages['del_time'];
  $data['op']['max_space'] = $cs_messages['max_space'];

 echo cs_subtemplate(__FILE__,$data,'messages','options');
}

?>