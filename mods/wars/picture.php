<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('wars');

$cs_wars_id = empty($_REQUEST['where']) ? $_GET['id'] : $_REQUEST['where'];
settype($cs_wars_id,'integer');

$op_wars = cs_sql_option(__FILE__,'wars');
$img_filetypes = array('gif','jpg','png');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,2);
echo $cs_lang['mod'] . ' - ' . $cs_lang['pictures'];
echo cs_html_roco(0);

$war = cs_sql_select(__FILE__,'wars','wars_pictures',"wars_id = '" . $cs_wars_id . "'");
$war_string = $war['wars_pictures'];
$war_pics = empty($war_string) ? array() : explode("\n",$war_string);
$war_next = count($war_pics) + 1;

$error = 0;
$message = '';

if(!empty($_GET['delete'])) {
  $target = $_GET['delete'] - 1;
  cs_unlink('wars', 'picture-' . $war_pics[$target]);
  cs_unlink('wars', 'thumb-' . $war_pics[$target]);
  $war_pics[$target] = FALSE;
  $war_pics = array_filter($war_pics);
  $war_string = implode("\n",$war_pics);
  $cells = array('wars_pictures');
  $content = array($war_string);
  cs_sql_update(__FILE__,'wars',$cells,$content,$cs_wars_id);
}
elseif(!empty($_POST['submit'])) {
  
  $img_size = getimagesize($_FILES['picture']['tmp_name']);
  if(empty($img_size) OR $img_size[2] > 3) {

    $message .= $cs_lang['ext_error'] . cs_html_br(1);
		$error++;
  }
  if($img_size[0]>$op_wars['max_width']) {

    $message .= $cs_lang['too_wide'] . cs_html_br(1);
  	$error++;
  }
  if($img_size[1]>$op_wars['max_height']) { 

  	$message .= $cs_lang['too_high'] . cs_html_br(1);
  	$error++;
  }
  if($_FILES['picture']['size']>$op_wars['max_size']) { 

  	$message .= $cs_lang['too_big'] . cs_html_br(1);
  	$error++;
  }

  if(empty($error)) {

    switch($img_size[2]) {
    case 1:
      $ext = 'gif'; break;
    case 2:
      $ext = 'jpg'; break;
    case 3:
      $ext = 'png'; break;
    }
    $target = $cs_wars_id . '-' . $war_next . '.' . $ext;
    $picture_name = 'picture-' . $target;
    $thumb_name = 'thumb-' . $target;
    if(cs_resample($_FILES['picture']['tmp_name'], 'uploads/wars/' . $thumb_name, 80, 200) 
    AND cs_upload('wars', $picture_name, $_FILES['picture']['tmp_name'])) {

      $cells = array('wars_pictures');
      $content = empty($war_string) ? array($target) : array($war_string . "\n" . $target);
      cs_sql_update(__FILE__,'wars',$cells,$content,$cs_wars_id);

		
		cs_redirect($cs_lang['success'],'wars','picture','id=' . $cs_wars_id);
    }
    else {
        $message .= $cs_lang['up_error'];
        $error++;
    }
  }
}
if(!empty($error) OR empty($_POST['submit'])) {

  if(!empty($message)) {
  	echo cs_html_roco(1,'leftb',0,2);
    echo $message;
  }
  elseif(empty($_GET['delete'])) {
  	echo cs_html_roco(1,'leftb');
    echo $cs_lang['body_picture'];
  	echo cs_html_roco(2,'rightb');
		echo cs_link($cs_lang['manage'],'wars','manage');
  }
  else {
  	echo cs_html_roco(1,'leftb',0,2);
    echo $cs_lang['remove_done'];
  }
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_br(1);
  echo cs_getmsg();
  echo cs_html_form(1,'wars_picture','wars','picture',1);
  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'leftc',0,0,'140px');
  echo cs_icon('download') . $cs_lang['upload'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('picture','','file');
	echo cs_html_br(2);
	$matches[1] = $cs_lang['pic_infos'];
	$return_types = '';
	foreach($img_filetypes AS $add) {
		$return_types .= empty($return_types) ? $add : ', ' . $add;
	}
	$matches[2] = $cs_lang['max_width'] .': '. $op_wars['max_width'] . ' px' . cs_html_br(1);
	$matches[2] .= $cs_lang['max_height'] .': '. $op_wars['max_height'] . ' px' . cs_html_br(1);
	$matches[2] .= $cs_lang['max_size'] .': '. cs_filesize($op_wars['max_size']) . cs_html_br(1);
	$matches[2] .= $cs_lang['filetypes'] . $return_types;
	echo cs_abcode_clip($matches);
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('ksysguard') . $cs_lang['options'];
  echo cs_html_roco(2,'leftb');
	echo cs_html_vote('where',$cs_wars_id,'hidden');
  echo cs_html_vote('submit',$cs_lang['save'],'submit');
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_form(0);
  echo cs_html_br(1);

  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'leftc',0,0,'140px');
  echo cs_icon('images') . $cs_lang['current'];
  echo cs_html_roco(2,'leftb');
  if(empty($war_string)) {
    echo $cs_lang['nopic'];
  }
  else {
    $run = 1;
    foreach($war_pics AS $pic) {
    $link = cs_html_img('uploads/wars/thumb-' . $pic);
    echo cs_html_link('uploads/wars/picture-' . $pic,$link) . ' ';
    $set = 'id=' . $cs_wars_id . '&amp;delete=' . $run++;
    echo cs_link($cs_lang['remove'],'wars','picture',$set);
    echo cs_html_br(2);
    }
  }
  echo cs_html_roco(0);
  echo cs_html_table(0);
}

?>