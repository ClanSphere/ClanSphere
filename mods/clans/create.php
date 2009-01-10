<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clans');

$op_clans = cs_sql_option(__FILE__,'clans');
$img_filetypes = array('gif','jpg','png');

if(isset($_POST['submit'])) {
  $cs_clans['clans_name'] = $_POST['clans_name'];
  $cs_clans['clans_short'] = $_POST['clans_short'];
  $cs_clans['clans_tag'] = $_POST['clans_tag'];  
  $cs_clans['clans_tagpos'] = $_POST['tag_pos'];  
  $cs_clans['clans_country'] = $_POST['clans_country'];  
  $cs_clans['clans_url'] = $_POST['clans_url'];
  $cs_clans['clans_since'] = cs_datepost('since','date');
  $cs_clans['clans_pwd'] = $_POST['clans_pwd'];
  $cs_clans['users_id'] = $_POST['users_id'];

  $error = 0;
  $errormsg = '';

  $img_size = getimagesize($_FILES['picture']['tmp_name']);
  if(!empty($_FILES['picture']['tmp_name']) AND empty($img_size) OR $img_size[2] > 3) {
    $message .= $cs_lang['ext_error'] . cs_html_br(1);
    $error++;
  }
  elseif(!empty($_FILES['picture']['tmp_name'])) {
    switch($img_size[2]) {
    case 1:
      $extension = 'gif'; break;
    case 2:
      $extension = 'jpg'; break;
    case 3:
      $extension = 'png'; break;
  }
    
  if($img_size[0]>$op_clans['max_width']) {
     $message .= $cs_lang['too_wide'] . cs_html_br(1);
     $error++;
  }
  
  if($img_size[1]>$op_clans['max_height']) { 
    $message .= $cs_lang['too_high'] . cs_html_br(1);
    $error++;
  }
  
  if($_FILES['picture']['size']>$op_clans['max_size']) { 
    $message .= $cs_lang['too_big'] . cs_html_br(1);
    $error++;
  }
}

if(empty($cs_clans['clans_name'])) {
  $error++;
  $errormsg .= $cs_lang['no_name'] . cs_html_br(1);
}

if(empty($cs_clans['clans_short'])) {
  $error++;
  $errormsg .= $cs_lang['no_short'] . cs_html_br(1);
}
  
$where = "clans_name = '" . cs_sql_escape($cs_clans['clans_name']) . "'";
$search = cs_sql_count(__FILE__,'clans',$where);

if(!empty($search)) {
  $error++;
  $errormsg .= $cs_lang['name_exists'] . cs_html_br(1);
  }
}
else {
  $cs_clans['clans_name'] = '';
  $cs_clans['clans_short'] = '';
  $cs_clans['clans_tag'] = '';
  $cs_clans['clans_tagpos'] = 0;
  $cs_clans['clans_country'] = 'fam';
  $cs_clans['clans_url'] = '';
  $cs_clans['clans_since'] = '';
  $cs_clans['clans_pwd'] = '';
  $cs_clans['users_id'] = 0;
	
  if(!empty($_GET['fightus'])) {
    $fightus_where = "fightus_id = '" . cs_sql_escape($_GET['fightus']) . "'";
    $cs_fightus = cs_sql_select(__FILE__,'fightus','*',$fightus_where);
    if(!empty($cs_fightus)) {
      $cs_clans['clans_name'] = $cs_fightus['fightus_clan'];
      $cs_clans['clans_short'] = $cs_fightus['fightus_short'];
      $cs_clans['clans_country'] = $cs_fightus['fightus_country'];
      $cs_clans['clans_url'] = $cs_fightus['fightus_url'];
    }
  }
}

if(!isset($_POST['submit'])) {
  $data['lang']['body'] = $cs_lang['fill_req'];
}

if(!empty($error)) {
  $data['lang']['body'] = $errormsg;
}

if(!empty($error) OR !isset($_POST['submit'])) {
  $data['lang']['mod'] = $cs_lang[$op_clans['label']];
  $data['url']['form'] = cs_url('clans','create');
  $data['clans']['name'] = $cs_clans['clans_name'];
  $data['clans']['short'] = $cs_clans['clans_short'];
  $data['clans']['tag'] = $cs_clans['clans_tag'];
  
  $el_id = 'country_1';
  $onc = "document.getElementById('" . $el_id . "').src='" . $cs_main['php_self']['dirname'] . "symbols/countries/' + this.form.";
  $onc .= "clans_country.options[this.form.clans_country.selectedIndex].value + '.png'";
  $data['clans']['country'] = cs_html_select(1,'clans_country',"onchange=\"" . $onc . "\"");
  include_once('lang/' . $account['users_lang'] . '/countries.php');
  foreach ($cs_country AS $short => $full) {
    $short == $cs_clans['clans_country'] ? $sel = 1 : $sel = 0;
    $data['clans']['country'] .= cs_html_option($full,$short,$sel);
  }
  
  $data['clans']['country'] .= cs_html_select(0) . ' ';
  $data['clans']['country'] .= cs_html_img('symbols/countries/' . $cs_clans['clans_country'] . '.png',11,16,'id="' . $el_id . '"');
  $data['clans']['url'] = $cs_clans['clans_url'];
  $data['clans']['since'] = cs_dateselect('since','date',$cs_clans['clans_since']);
  $data['clans']['pw'] = $cs_clans['clans_pwd'];

  $users_data = cs_sql_select(__FILE__,'users','users_nick,users_id',0,'users_nick',0,0);
  $users_data_loop = count($users_data);

  if(empty($users_data_loop)) {
    $data['users'] = '';
  }

  for($run=0; $run<$users_data_loop; $run++) {
    $data['users'][$run]['id'] = $users_data[$run]['users_id'];
    $data['users'][$run]['name'] = $users_data[$run]['users_nick'];
  }

  $matches[1] = $cs_lang['pic_infos'];
  $return_types = '';
  foreach($img_filetypes AS $add) {
    $return_types .= empty($return_types) ? $add : ', ' . $add;
  }
  $matches[2] = $cs_lang['max_width'] . $op_clans['max_width'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_height'] . $op_clans['max_height'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_size'] . cs_filesize($op_clans['max_size']) . cs_html_br(1);
  $matches[2] .= $cs_lang['filetypes'] . $return_types;
  $data['clans']['clip'] = cs_abcode_clip($matches);

  $data['clip']['plus'] = cs_html_img('symbols/clansphere/plus.gif',0,0,'id="img_pass"');
  echo cs_subtemplate(__FILE__,$data,'clans','create');
}
else {
  $clans_cells = array_keys($cs_clans);
  $clans_save = array_values($cs_clans);
  cs_sql_insert(__FILE__,'clans',$clans_cells,$clans_save);

  if(!empty($_FILES['picture']['tmp_name'])) {
  	$where = "clans_name = '" . cs_sql_escape($cs_clans['clans_name']) . "'";
  	$getid = cs_sql_select(__FILE__,'clans','clans_id',$where);
    $filename = 'picture-' . $getid['clans_id'] . '.' . $extension;
  	cs_upload('clans',$filename,$_FILES['picture']['tmp_name']);

    $cs_clans2['clans_picture'] = $filename;
    $clans2_cells = array_keys($cs_clans2);
    $clans2_save = array_values($cs_clans2);			
    cs_sql_update(__FILE__,'clans',$clans2_cells,$clans2_save,$getid['clans_id']);
  }
  
  if($account['access_wizard'] == 5) {

  cs_redirect($cs_lang['create_done'],'clans','manage');
  
    $wizard = cs_sql_count(__FILE__,'options',"options_name = 'done_clan' AND options_value = '1'");
    if(empty($wizard)) {
      $data['clans']['wizard'] = $cs_lang['wizard'] . ': ' . cs_link($cs_lang['show'],'wizard','roots') . ' - ' . cs_link($cs_lang['task_done'],'wizard','roots','handler=clan&amp;done=1');
	  
	  echo cs_subtemplate(__FILE__,$data,'clans','wizard');
  	}
  } else cs_redirect($cs_lang['create_done'],'clans');
}

?>