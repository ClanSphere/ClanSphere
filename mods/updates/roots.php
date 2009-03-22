<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('updates');
$update_server = "http://update.clansphere.net/"; 

$data = array();
$data['if']['details'] = FALSE;
$data['if']['update'] = FALSE;
$data['if']['update_check'] = FALSE;
$data['if']['no_updates'] = FALSE;
$data['if']['error'] = FALSE;

if(isset($_POST['agree'])) {   
  $value = cs_sql_escape($_POST['file']);
  cs_redirect('','updates','update','file='.$value);
} elseif(isset($_POST['cancel'])) {
  cs_redirect('','updates','roots');
} elseif(isset($_POST['details'])) { 
  $value = cs_sql_escape($_POST['file']);
  $info_file = file_get_contents($update_server.'infos/'.$value, "r");    
    
  preg_match("=\[number\](.*?)\[/number\]=si", $info_file, $num);
  preg_match("=\[name\](.*?)\[/name\]=si", $info_file, $name);  
  preg_match("=\[date\](.*?)\[/date\]=si", $info_file, $date);
  preg_match("=\[changelog\](.*?)\[/changelog\]=si", $info_file, $changes);

  $data['if']['details'] = TRUE;
  $data['details']['num_name'] = cs_secure($num[1].' - '.$name[1]);
  $data['details']['changes'] = cs_secure($changes[1],1,0);  
  $data['details']['file'] = $value;
  
} elseif(isset($_POST['update'])) { 
  $value = cs_sql_escape($_POST['file']);
  $info_file = file_get_contents($update_server.'infos/'.$value, 'r');    
  
  preg_match("=\[number\](.*?)\[/number\]=si", $info_file, $num);
  preg_match("=\[name\](.*?)\[/name\]=si", $info_file, $name);
  
  $data['if']['update'] = TRUE;
  $data['update']['num_name'] = cs_secure($num[1].' - '.$name[1]);
  $data['update']['file'] = $value;
  
} else {
  //Check for ZIP-Module in Apache
  if(extension_loaded('zip')) {
    $info_files = explode("?", file_get_contents($update_server.'update_check.php', 'r'));
    $info_files_count = (count($info_files)-1);
    unset($info_files[$info_files_count]); 
    rsort($info_files);
    
    if(!empty($info_files_count)) {
    $run = 0;
      foreach($info_files AS $value) {
        $info_file = file_get_contents($update_server.'infos/'.$value, "r");    
    
        preg_match("=\[number\](.*?)\[/number\]=si", $info_file, $num);
        preg_match("=\[name\](.*?)\[/name\]=si", $info_file, $name);  
        preg_match("=\[date\](.*?)\[/date\]=si", $info_file, $date);
        preg_match("=\[need\](.*?)\[/need\]=si", $info_file, $need);
        preg_match("=\[changelog\](.*?)\[/changelog\]=si", $info_file, $changes);
        
        $check_updatepack = cs_sql_count(__FILE__,'updates','updates_packet='.$num[1]);
        
        if($cs_main['version_id'] == $need[1] OR empty($need[1]) AND empty($check_updatepack)) {

      $data['if']['update_check'] = TRUE;
      $data['updatecheck'][$run]['num_name'] = cs_secure($num[1].' - '.$name[1]);
          $data['updatecheck'][$run]['changes'] = cs_secure(substr($changes[1],0,200).'...',1,0);  
      $data['updatecheck'][$run]['file'] = $value;
          $notice = 1;
      $run++;

        } elseif(empty($notice)) {
          $data['if']['no_updates'] = TRUE;
          $notice = 1;
        }   
      }
    } else {
      $data['if']['no_updates'] = TRUE;
    }
  } else {
    $data['if']['error'] = TRUE;
  }
}

echo cs_subtemplate(__FILE__,$data,'updates','roots');

?>