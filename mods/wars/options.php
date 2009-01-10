<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('wars');

if(isset($_POST['submit'])) {

	settype($_POST['max_width'],'integer');
	settype($_POST['max_height'],'integer');
	settype($_POST['max_size'],'integer');
	settype($_POST['max_navlist'],'integer');

  $opt_where = "options_mod = 'wars' AND options_name = ";
  $def_cell = array('options_value');
  $def_cont = array($_POST['max_width']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'max_width'");
  $def_cont = array($_POST['max_height']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'max_height'");
  $def_cont = array($_POST['max_size']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'max_size'");
  $def_cont = array($_POST['max_navlist']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'max_navlist'");
  
  $lang = substr($account['users_lang'],0,2);
  if (!file_exists('uploads/wars/news_' . $lang . '.txt')) $lang = 'de';
  
  $text = $_POST['news_text'];
  
  $fp = fopen('uploads/wars/news_' . $lang . '.txt','w');
  fwrite($fp, $text);
  fclose($fp);

  cs_redirect($cs_lang['success'],'wars','options');
}
else {
	
	$data = array();
	
	$data['head']['message'] = cs_getmsg();
	
	$data['op'] = cs_sql_option(__FILE__,'wars');
	$pholders = array();
	$pholders['{SQUADNAME}'] = $cs_lang['op_squadname'];
	$pholders['{SQUADURL}'] = $cs_lang['op_squadurl'];
	$pholders['{OPPONENTNAME}'] = $cs_lang['op_opponentname'];
	$pholders['{SCORE_1}'] = $cs_lang['op_score1'];
	$pholders['{SCORE_2}'] = $cs_lang['op_score2'];
	$pholders['{MATCH_URL}'] = $cs_lang['op_matchurl'];
	$pholders['{CAT_NAME}'] = $cs_lang['op_catname'];
	
	$lang = substr($account['users_lang'],0,2);
	if (!file_exists('uploads/wars/news_' . $lang . '.txt')) $lang = 'de';
	
	$data['news']['text'] = file_get_contents('uploads/wars/news_' . $lang . '.txt');
	
	$data['pholders'] = array();
	foreach ($pholders AS $holder => $meaning) $data['pholders'][] = array('holder' => $holder, 'meaning' => $meaning); 
	
	echo cs_subtemplate(__FILE__,$data,'wars','options');
	
}

?>