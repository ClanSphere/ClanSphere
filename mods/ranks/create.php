<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('ranks');

if(isset($_POST['submit'])) {

  $cs_ranks['ranks_name'] = $_POST['ranks_name'];
  $cs_ranks['ranks_url'] = $_POST['ranks_url'];
  $cs_ranks['ranks_img'] = $_POST['ranks_img'];
  $cs_ranks['ranks_code'] = $_POST['ranks_code'];

	$error = 0;
  $errormsg = '';

  if(empty($cs_ranks['ranks_name'])) {
    $error++;
    $errormsg .= $cs_lang['no_name'] . cs_html_br(1);
  }
	if(empty($cs_ranks['ranks_url']) AND empty($cs_ranks['ranks_code'])) {
    $error++;
    $errormsg .= $cs_lang['no_url'] . cs_html_br(1);
  }
	if(empty($cs_ranks['ranks_img']) AND empty($cs_ranks['ranks_code'])) {
    $error++;
    $errormsg .= $cs_lang['no_img'] . cs_html_br(1);
  }
  
  $where = "ranks_name = '" . cs_sql_escape($cs_ranks['ranks_name']) . "'";
  $search = cs_sql_count(__FILE__,'ranks',$where);
  if(!empty($search)) {
    $error++;
    $errormsg .= $cs_lang['rank_exists'] . cs_html_br(1);
  }
}
else {
  $cs_ranks['ranks_name'] = '';
  $cs_ranks['ranks_url'] = '';
  $cs_ranks['ranks_img'] = 'http://';
  $cs_ranks['ranks_code'] = '';
}

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_create'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc');
if(!isset($_POST['submit'])) {
  echo $cs_lang['body_create'];
}
elseif(!empty($error)) {
  echo $errormsg;
}
else {
  echo $cs_lang['create_done'];
}
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

if(!empty($error) OR !isset($_POST['submit'])) {

  echo cs_html_form(1,'ranks_create','ranks','create',1);
  echo cs_html_table(1,'forum',1);
  
  echo cs_html_roco(1,'leftc');
	echo cs_icon('playlist') . $cs_lang['name'] . ' *';
	echo cs_html_roco(2,'leftb');
  echo cs_html_input('ranks_name',$cs_ranks['ranks_name'],'text',80,40);
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('gohome') . $cs_lang['url'] . ' *';
  echo cs_html_roco(2,'leftb');
  echo 'http://' . cs_html_input('ranks_url',$cs_ranks['ranks_url'],'text',80,50);
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('images') . $cs_lang['img'] . ' *';
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('ranks_img',$cs_ranks['ranks_img'],'text',80,50);
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
	echo cs_icon('html') . $cs_lang['code'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_textarea('ranks_code',$cs_ranks['ranks_code'],'50','12');
  echo cs_html_br(2);
  echo $cs_lang['code_info'];
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('ksysguard') . $cs_lang['options'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_vote('submit',$cs_lang['create'],'submit');
  echo cs_html_vote('reset',$cs_lang['reset'],'reset');
  echo cs_html_roco(0);

  echo cs_html_table(0);
  echo cs_html_form(0);
}
else {

  $ranks_cells = array_keys($cs_ranks);
  $ranks_save = array_values($cs_ranks);
  cs_sql_insert(__FILE__,'ranks',$ranks_cells,$ranks_save);
	
	cs_redirect($cs_lang['create_done'],'ranks');
}

?>