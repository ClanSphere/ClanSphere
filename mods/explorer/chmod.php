<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('explorer');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['chmod'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc');

if(empty($_POST['submit'])) {
  if(empty($_GET['file'])) {
    echo $cs_lang['no_selection'] . ' ' . cs_link($cs_lang['back'],'explorer','roots');
    echo cs_html_roco(0);
    echo cs_html_table(0);
  } else {
    echo $cs_lang['grant_rights'];
    echo cs_html_roco(0);
    echo cs_html_table(0);
    echo cs_html_br(1);
    
    $chmod = substr(sprintf('%o', fileperms($_GET['file'])), -3);
    $temp = $chmod;
    
    $o_r = 0;
    $o_w = 0;
    $o_e = 0;
    
    if ($temp >= 400) {
      $o_r = 1;
      $temp -= 400;
    }
    if ($temp >= 200) {
      $o_w = 1;
      $temp -= 200;
    }
    if ($temp >= 100) {
      $o_e = 1;
      $temp -= 100;
    }
    
    $g_r = 0;
    $g_w = 0;
    $g_e = 0;
    
    if ($temp >= 40) {
      $g_r = 1;
      $temp -= 40;
    }
    if ($temp >= 20) {
      $g_w = 1;
      $temp -= 20;
    }
    if ($temp > 10) {
      $g_e = 1;
      $temp -= 10;
    }
    
    $p_r = 0;
    $p_w = 0;
    $p_e = 0;
    
    if ($temp >= 4) {
      $p_r = 1;
      $temp -= 4;
    }
    if ($temp >= 2) {
      $p_w = 1;
      $temp -= 2;
    }
    if ($temp >= 1) {
      $p_e = 1;
      $temp -= 1;
    }
    
    
    echo cs_html_form(1,'explorer_chmod','explorer','chmod');
    echo cs_html_table(1,'forum',1);
    
    echo cs_html_roco(1,'leftc');
    echo cs_icon('access') . $cs_lang['owner'];
    echo cs_html_roco(2,'leftb');
    echo cs_html_vote('owner_read',400,'checkbox',$o_r,"id=\"owner_read\" onclick=\"cs_chmod_CheckChange('owner_read',400)\"");
    echo ' '.$cs_lang['read'].cs_html_br(1);
    echo cs_html_vote('owner_write',200,'checkbox',$o_w,"id=\"owner_write\" onclick=\"cs_chmod_CheckChange('owner_write',200)\"");
    echo ' '.$cs_lang['write'].cs_html_br(1);
    echo cs_html_vote('owner_execute',100,'checkbox',$o_e,"id=\"owner_execute\" onclick=\"cs_chmod_CheckChange('owner_execute',100)\"");
    echo ' '.$cs_lang['execute'];
    echo cs_html_roco(0);
    
    echo cs_html_roco(1,'leftc');
    echo cs_icon('access') . $cs_lang['group'];
    echo cs_html_roco(2,'leftb');
    echo cs_html_vote('group_read',40,'checkbox',$g_r,"id=\"group_read\" onclick=\"cs_chmod_CheckChange('group_read',40)\"");
    echo ' '.$cs_lang['read'].cs_html_br(1);
    echo cs_html_vote('group_write',20,'checkbox',$g_w,"id=\"group_write\" onclick=\"cs_chmod_CheckChange('group_write',20)\"");
    echo ' '.$cs_lang['write'].cs_html_br(1);
    echo cs_html_vote('group_execute',10,'checkbox',$g_e,"id=\"group_execute\" onclick=\"cs_chmod_CheckChange('group_execute',10)\"");
    echo ' '.$cs_lang['execute'];
    echo cs_html_roco(0);
    
    echo cs_html_roco(1,'leftc');
    echo cs_icon('access') . $cs_lang['public'];
    echo cs_html_roco(2,'leftb');
    echo cs_html_vote('public_read',40,'checkbox',$p_r,"id=\"public_read\" onclick=\"cs_chmod_CheckChange('public_read',4)\"");
    echo ' '.$cs_lang['read'].cs_html_br(1);
    echo cs_html_vote('public_write',20,'checkbox',$p_w,"id=\"public_write\" onclick=\"cs_chmod_CheckChange('public_write',2)\"");
    echo ' '.$cs_lang['write'].cs_html_br(1);
    echo cs_html_vote('public_execute',10,'checkbox',$p_e,"id=\"public_execute\" onclick=\"cs_chmod_CheckChange('public_execute',1)\"");
    echo ' '.$cs_lang['execute'];
    echo cs_html_roco(0);
    
    echo cs_html_roco(1,'leftc');
    echo cs_icon('access') . $cs_lang['chmod'];
    echo cs_html_roco(2,'leftb');
    echo cs_html_input('chmod',$chmod,'text',0,0,'id="chmod" onchange="cs_chmod_TextChange()"');
    echo cs_html_roco(0);
    echo cs_html_roco(1,'leftc');
    echo cs_icon('ksysguard') . $cs_lang['options'];
    echo cs_html_roco(2,'leftb');
    echo cs_html_input('file',$_GET['file'],'hidden');
    echo cs_html_input('submit',$cs_lang['save'],'submit');
    echo cs_html_input('reset',$cs_lang['reset'],'reset');
    echo cs_html_roco(0);
    echo cs_html_table(0);
    echo cs_html_form(0);
  }
} else {
  $chmod = $_POST['chmod'];
  
  $count = strlen($chmod);
  $missing = 4 - $count;
  $new_chmod = '';
  
  for($x = 0; $x < $missing; $x++) {
    $new_chmod .= '0';
  }
  $new_chmod .= $chmod;
  $new_chmod = octdec($new_chmod);
  
  $dir = '';
  $single_dirs = explode('/',$_POST['file']);
  $count_dirs = count($single_dirs) - 1;
  for ($x = 0; $x < $count_dirs; $x++) {
    $dir .= $single_dirs[$x] . '/';
  }
  
  @chmod($_POST['file'],$new_chmod);
  
  $fileperms = octdec(substr(sprintf('%o', fileperms($_POST['file'])), -4));
  
  if ($new_chmod == $fileperms) {
    cs_redirect($cs_lang['success'],'explorer','roots','dir='.$dir);
  } else {
    cs_redirect($cs_lang['error_chmod'],'explorer','roots','dir='.$dir);
  }
  
  echo cs_html_roco(0);
  echo cs_html_table(0);
}

?>