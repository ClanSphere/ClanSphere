<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('wars');

if(isset($_POST['submit'])) {
  
  $save = array();
  $save['max_width'] = (int) $_POST['max_width'];
  $save['max_height'] = (int) $_POST['max_height'];
  $save['max_size'] = (int) $_POST['max_size'];
  $save['max_navlist'] = (int) $_POST['max_navlist'];
  
  require 'mods/clansphere/func_options.php';
  
  cs_optionsave('wars', $save);
  
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