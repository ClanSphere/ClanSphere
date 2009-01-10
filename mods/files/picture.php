<?php
$cs_lang = cs_translate('files');

$cs_files_id = empty($_REQUEST['where']) ? $_GET['id'] : $_REQUEST['where'];
settype($cs_file_id,'integer');

$img_max['width'] = 1280;
$img_max['height'] = 1024;
$img_max['size'] = 204800;
$img_filetypes = array('gif','jpg','png');

$file = cs_sql_select(__FILE__,'files','files_previews',"files_id = '" . $cs_files_id . "'");
$file_string = $file['files_previews'];
$file_pics = empty($file_string) ? array() : explode("\n",$file_string);
$file_next = count($file_pics) + 1;

$error = 0;
$message = '';

if(!empty($_GET['delete'])) {
  $target = $_GET['delete'] - 1;
  cs_unlink('files', 'picture-' . $file_pics[$target]);
  cs_unlink('files', 'thumb-' . $file_pics[$target]);
  $file_pics[$target] = FALSE;
  $file_pics = array_filter($file_pics);
  $file_string = implode("\n",$file_pics);
  $cells = array('files_previews');
  $content = array($file_string);
  cs_sql_update(__FILE__,'files',$cells,$content,$cs_files_id);
}
elseif(!empty($_POST['submit'])) {
  
  $img_size = getimagesize($_FILES['picture']['tmp_name']);
  if(empty($img_size) OR $img_size[2] > 3) {

    $message .= $cs_lang['ext_error'] . cs_html_br(1);
		$error++;
  }
  if($img_size[0]>$img_max['width']) {

    $message .= $cs_lang['too_wide'] . cs_html_br(1);
  	$error++;
  }
  if($img_size[1]>$img_max['height']) { 

  	$message .= $cs_lang['too_high'] . cs_html_br(1);
  	$error++;
  }
  if($_FILES['picture']['size']>$img_max['size']) { 

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
    $target = $cs_files_id . '-' . $file_next . '.' . $ext;
    $picture_name = 'picture-' . $target;
    $thumb_name = 'thumb-' . $target;
    if(cs_resample($_FILES['picture']['tmp_name'], 'uploads/files/' . $thumb_name, 80, 200) 
    AND cs_upload('files', $picture_name, $_FILES['picture']['tmp_name'])) {

      $cells = array('files_previews');
      $content = empty($file_string) ? array($target) : array($file_string . "\n" . $target);
      cs_sql_update(__FILE__,'files',$cells,$content,$cs_files_id);

		
		cs_redirect($cs_lang['success'],'files','picture','id=' . $cs_files_id);
    }
    else {
        $message .= $cs_lang['up_error'];
        $error++;
    }
  }
}

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo 'Files' . ' - ' . $cs_lang['head_picture'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
if(!empty($message)) {
  echo $message;
}
elseif(empty($_GET['delete'])) {
  echo $cs_lang['body_picture'];
}
else {
  echo $cs_lang['remove_done'];
}
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);
echo cs_getmsg();
  
if(!empty($error) OR empty($_POST['submit'])) {
  echo cs_html_form(1,'files_picture','files','picture',1);
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
	$matches[2] = $cs_lang['max_width'] . $img_max['width'] . ' px' . cs_html_br(1);
	$matches[2] .= $cs_lang['max_height'] . $img_max['height'] . ' px' . cs_html_br(1);
	$matches[2] .= $cs_lang['max_size'] . cs_filesize($img_max['size']) . cs_html_br(1);
	$matches[2] .= $cs_lang['filetypes'] . $return_types;
	echo cs_abcode_clip($matches);
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('ksysguard') . $cs_lang['options'];
  echo cs_html_roco(2,'leftb');
	echo cs_html_vote('where',$cs_files_id,'hidden');
  echo cs_html_vote('submit',$cs_lang['save'],'submit');
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_form(0);
  echo cs_html_br(1);

  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'leftc',0,0,'140px');
  echo cs_icon('images') . $cs_lang['current'];
  echo cs_html_roco(2,'leftb');
  if(empty($file_string)) {
    echo $cs_lang['nopic'];
  }
  else {
    $run = 1;
    foreach($file_pics AS $pic) {
    $link = cs_html_img('uploads/files/thumb-' . $pic);
    echo cs_html_link('uploads/files/picture-' . $pic,$link) . ' ';
    $set = 'id=' . $cs_files_id . '&amp;delete=' . $run++;
    echo cs_link($cs_lang['remove'],'files','picture',$set);
    echo cs_html_br(2);
    }
  }
  echo cs_html_roco(0);
  echo cs_html_table(0);
}

?>
