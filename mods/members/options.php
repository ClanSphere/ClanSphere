<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('members');

$op_members = cs_sql_option(__FILE__,'members');

$data['lang']['mod'] = $cs_lang[$op_members['label']];


if (!empty($_POST['submit'])) {
  
  // Check for wrong input
  
  $error = '';
  
}

if (empty($_POST['submit']) || !empty($error)) {

  $data['lang']['body'] =  empty($error) ? $cs_lang['errors_here'] : $cs_lang['error_occured'] . $error;
  
  
  $data['url']['form'] = cs_url('members','options');

   if ($op_members['label'] == 'members') {
     $data['select']['members_select'] = 'selected="selected"'; 
   }
   else {
     $data['select']['members_select'] = '';
   }
   if ($op_members['label'] == 'employees') {
     $data['select']['employees_select'] = 'selected="selected"';
   }
   else {
     $data['select']['employees_select'] = '';
   }
   if ($op_members['label'] == 'teammates') {
     $data['select']['teammates_select'] = 'selected="selected"';
   }
   else {
     $data['select']['teammates_select'] = '';
   }
   if ($op_members['label'] == 'classmates') {
     $data['select']['classmates_select'] = 'selected="selected"';
   }
   else {
     $data['select']['classmates_select'] = '';
   }
   
   echo cs_subtemplate(__FILE__,$data,'members','options');
  
}
else {
  
  $opt_where = "options_mod = 'members' AND options_name = ";
  $def_cell = array('options_value');
  
  $def_cont = array($_POST['label']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'label'");
  
  cs_redirect($cs_lang['changes_done'],'members','options');
  
}

?>