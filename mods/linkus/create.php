<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('linkus');

$img_max['width'] = 470;
$img_max['height'] = 100;
$img_max['size'] = 256000;
$img_filetypes = array('image/png' => 'png','image/jpeg' => 'jpg','image/gif' => 'gif');

$linkus_error = 3; 
$linkus_form = 1;

$symbol = '';
$linkus_name = '';
$linkus_url = '';
$errormsg = '';


if(!empty($_POST['linkus_name'])) {
    $linkus_name = $_POST['linkus_name'];
    $linkus_error--;
}   
if(!empty($_POST['linkus_url'])) {
    $linkus_url = $_POST['linkus_url'];
    $linkus_error--;
} 
if(!empty($_FILES['symbol']['tmp_name'])) {
    $linkus_error--;
} 
  
  if(!empty($_FILES['symbol']['tmp_name'])) {
    $symbol_error = 1;
    $errormsg .= $cs_lang['ext_error'] . cs_html_br(1);
      foreach($img_filetypes AS $allowed => $new_ext) {
        if($allowed == $_FILES['symbol']['type']) {
          $errormsg = '';
          $symbol_error = 0;
          $extension = $new_ext;
        } 
      }
      $img_size = getimagesize($_FILES['symbol']['tmp_name']);
      if($img_size[0]>$img_max['width']) {
      $errormsg .= $cs_lang['too_wide'] . cs_html_br(1); 
        $symbol_error++;
      }
      if($img_size[1]>$img_max['height']) { 
      $errormsg .= $cs_lang['too_high'] . cs_html_br(1);
        $symbol_error++;
      }
      if($_FILES['symbol']['size']>$img_max['size']) {
      $errormsg .= $cs_lang['too_big'] . cs_html_br(1); 
        $symbol_error++;
      }
    }

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['head'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo $cs_lang['body_create'];
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);


if(isset($_POST['submit'])) {
    if(empty($linkus_error) AND $symbol_error == 0) {
        $linkus_form = 0;
        
    $linkus_cells = array('linkus_name','linkus_url');
    $linkus_save = array($linkus_name,$linkus_url);
    cs_sql_insert(__FILE__,'linkus',$linkus_cells,$linkus_save);
    
        
    if(!empty($_FILES['symbol']['tmp_name']) AND $symbol_error == 0) {
    $where = "linkus_name = '" . cs_sql_escape($linkus_name) . "'";
    $getid = cs_sql_select(__FILE__,'linkus','linkus_id',$where);
    $filename = $getid['linkus_id'] . '.' . $extension;
    cs_upload('linkus',$filename,$_FILES['symbol']['tmp_name']);
    }
    
    $linkus_cells = array('linkus_banner');
    $linkus_save = array($filename);
    cs_sql_update(__FILE__,'linkus',$linkus_cells,$linkus_save,$getid['linkus_id']);    
    
    cs_redirect($cs_lang['create_done'],'linkus');
    } else {
    
                echo cs_html_table(1,'forum',1);
		echo cs_html_roco(1,'leftc');
		echo cs_icon('important');
		echo $cs_lang['error_occurred'];
		echo ' - ';
		echo cs_secure ($linkus_error).' '.$cs_lang['error_count'];
		echo cs_html_roco(0);
		echo cs_html_roco(1,'leftc');
		echo $errormsg;
		echo cs_html_roco(0);
		echo cs_html_table(0);
		echo cs_html_br(1);
}
    
}


if(!empty($linkus_form)) {

    echo cs_html_form (1,'linkus_create','linkus','create',1);
    echo cs_html_table(1,'forum',1);
    echo cs_html_roco(1,'leftc');
    echo cs_icon('wp') . $cs_lang['name']. ' *';
    echo cs_html_roco(2,'leftb');
    echo cs_html_input('linkus_name',$linkus_name,'text',200,50);
    echo cs_html_roco(0); 
    
    echo cs_html_roco(1,'leftc');
    echo cs_icon('gohome') . $cs_lang['url']. ' *';
    echo cs_html_roco(2,'leftb');
    echo "http://";
    echo cs_html_input('linkus_url',$linkus_url,'text',200,50);
    echo cs_html_roco(0);
    
    echo cs_html_roco(1,'leftc');
    echo cs_icon('images') . $cs_lang['icon']. ' *';
    echo cs_html_roco(2,'leftb');
    echo cs_html_input('symbol',$symbol,'file');
    echo cs_html_br(2);
    $matches[1] = $cs_lang['pic_infos'];
	$return_types = '';
	foreach($img_filetypes AS $add => $value) {
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
    echo cs_html_vote('submit',$cs_lang['create'],'submit');
    echo cs_html_vote('reset',$cs_lang['reset'],'reset');
    echo cs_html_roco(0);
    echo cs_html_table(0);
    echo cs_html_form (0);
}

?>
