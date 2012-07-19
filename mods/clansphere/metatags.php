<?php

$cs_lang = cs_translate('clansphere');

$data['if']['done'] = false;
  
if($account['access_wizard'] == 5) {
  $wizard = cs_sql_count(__FILE__,'options',"options_name = 'done_meta' AND options_value = '1'");
  if(empty($wizard)) {
    $data['if']['done'] = true;
    $data['lang']['link_2'] = cs_link($cs_lang['show'],'wizard','roots') . ' - ' . cs_link($cs_lang['task_done'],'wizard','roots','handler=meta&amp;done=1');
  }
}

if(isset($_POST['submit'])) {
  $errormsg = '';
  $error = '0';
  
  if(empty($_POST['description'])) {
    $active_description = '0';
  }
  else {
    $active_description = '1';
  }
  
  if(empty($_POST['keywords'])) {
    $active_keywords = '0';
  }
  else {
    $active_keywords = '1';
  }
  
  if(empty($_POST['language'])) {
    $active_language = '0';
  }
  else {
    $active_language = '1';
  }
  
  if(empty($_POST['author'])) {
    $active_author = '0';
  }
  else {
    $active_author = '1';
  }
  
  if(empty($_POST['designer'])) {
    $active_designer = '0';
  }
  else {
    $active_designer = '1';
  }
  
  if(empty($_POST['publisher'])) {
    $active_publisher = '0';
  }
  else {
    $active_publisher = '1';
  }

  $check_description = strlen($_POST['description']);
  
  if($check_description > '200') {
    $errormsg .= sprintf($cs_lang['too_many_chars'], $cs_lang['description']) . cs_html_br(1);
    $error++;
  }
  
  $check_description = strlen($_POST['keywords']);
  
  if($check_description > '200') {
    $errormsg .= sprintf($cs_lang['too_many_chars'], $cs_lang['keywords']) . cs_html_br(1);
    $error++;
  }
  
  $check_description = strlen($_POST['language']);
  
  if($check_description > '200') {
    $errormsg .= sprintf($cs_lang['too_many_chars'], $cs_lang['languages']) . cs_html_br(1);
    $error++;
  }
  
  $check_description = strlen($_POST['author']);
  
  if($check_description > '200') {
    $errormsg .= sprintf($cs_lang['too_many_chars'], $cs_lang['author']) . cs_html_br(1);
    $error++;
  }

  $check_description = strlen($_POST['designer']);
  
  if($check_description > '200') {
    $errormsg .= sprintf($cs_lang['too_many_chars'], $cs_lang['designer']) . cs_html_br(1);
    $error++;
  }
  
  $check_description = strlen($_POST['publisher']);
  
  if($check_description > '200') { $errormsg .= sprintf($cs_lang['too_many_chars'], $cs_lang['publisher']) . cs_html_br(1);
    $error++;
  }
  
  if(!empty($error)) {
    $data['head']['action'] = $cs_lang['metatags'];
    $data['head']['error'] = $errormsg;
    echo cs_subtemplate(__FILE__,$data,'clansphere','error');
  }
  
  if(empty($error)) {
    $opt_where = "metatags_name = ";
    $def_cell = array('metatags_content','metatags_active');
    $def_cont = array($_POST['description'], $active_keywords);
  cs_sql_update(__FILE__,'metatags',$def_cell,$def_cont,0,$opt_where . "'description'");
    $def_cont = array($_POST['keywords'], $active_keywords);
  cs_sql_update(__FILE__,'metatags',$def_cell,$def_cont,0,$opt_where . "'keywords'");
    $def_cont = array($_POST['language'], $active_language);
  cs_sql_update(__FILE__,'metatags',$def_cell,$def_cont,0,$opt_where . "'language'");
    $def_cont = array($_POST['author'], $active_author);
  cs_sql_update(__FILE__,'metatags',$def_cell,$def_cont,0,$opt_where . "'author'");
    $def_cont = array($_POST['designer'], $active_designer);
  cs_sql_update(__FILE__,'metatags',$def_cell,$def_cont,0,$opt_where . "'designer'");
    $def_cont = array($_POST['publisher'], $active_publisher);
  cs_sql_update(__FILE__,'metatags',$def_cell,$def_cont,0,$opt_where . "'publisher'");
    $def_cont = array($_POST['robots'], '1');
  cs_sql_update(__FILE__,'metatags',$def_cell,$def_cont,0,$opt_where . "'robots'");
    $def_cont = array($_POST['distribution'], '1');
  cs_sql_update(__FILE__,'metatags',$def_cell,$def_cont,0,$opt_where . "'distribution'");
  
  $data['head']['action'] = $cs_lang['metatags'];
  $data['link']['continue'] = cs_url('clansphere','system');
  
  cs_cache_delete('metatags');
  
  cs_redirect($cs_lang['success'], 'clansphere', 'system');
  
  }
} 
else {
  $sel = 'selected="selected"';

  $select = 'metatags_id, metatags_name, metatags_content';
  $where = '';
  $order = 'metatags_name';
  $cs_metatags = cs_sql_select(__FILE__,'metatags',$select,$where,$order,0,0);
  $count_metatags = count($cs_metatags);

  for($run = 0; $run < $count_metatags; $run++)
  $data['metatags'][$cs_metatags[$run]['metatags_name']] = $cs_metatags[$run]['metatags_content'];
  $data['selected']['robots_all'] = $data['metatags']['robots'] != 'index,follow' ? '' : $sel;
  $data['selected']['robots_no'] = $data['metatags']['robots'] == 'index,follow' ? '' : $sel;
  $data['selected']['distribution_global'] = $data['metatags']['distribution'] != 'global' ? '' : $sel;
  $data['selected']['distribution_intern'] = $data['metatags']['distribution'] == 'global' ? '' : $sel;

  echo cs_subtemplate(__FILE__,$data,'clansphere','metatags');
}