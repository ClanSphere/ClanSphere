<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('updates');
$update_server = "http://update.clansphere.de/"; 

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,2);
echo 'ClanSphere - ' .$cs_lang['mod'];
echo cs_html_roco(0); 
echo cs_html_roco(1,'leftb',0,2);
echo $cs_lang['mod_text'];
echo cs_html_roco(0); 
echo cs_html_table(0); 
echo cs_html_br(1);

if(isset($_POST['agree'])) {   
  $value = cs_sql_escape($_POST['file']);
  cs_redirect('','updates','update','file='.$value);
} elseif(isset($_POST['details'])) { 
  $value = cs_sql_escape($_POST['file']);
  $info_file = file_get_contents($update_server.'infos/'.$value, "r");    
    
  preg_match("=\[number\](.*?)\[/number\]=si", $info_file, $num);
  preg_match("=\[name\](.*?)\[/name\]=si", $info_file, $name);  
  preg_match("=\[date\](.*?)\[/date\]=si", $info_file, $date);
  preg_match("=\[changelog\](.*?)\[/changelog\]=si", $info_file, $changes);
    
  echo cs_html_form(1,'roots','updates','roots');
  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'headb');
  echo $cs_lang['packet'].' '.cs_secure('#'.$num[1].' - '.$name[1]);
  echo cs_html_roco(0);  
  echo cs_html_roco(1,'leftb');
  echo cs_secure($changes[1],1,0);  
  echo cs_html_roco(0); 
  echo cs_html_roco(1,'rightc');
  echo cs_html_vote("file", $value, "hidden"); 
  echo cs_html_vote("", $cs_lang['back'], "submit");
  echo cs_html_vote("update", $cs_lang['update'], "submit");
  echo cs_html_roco(0);
  echo cs_html_table(0); 
  echo cs_html_form(0);
  echo cs_html_br(1); 
  
} elseif(isset($_POST['update'])) { 
  $value = cs_sql_escape($_POST['file']);
  $info_file = file_get_contents($update_server.'infos/'.$value, 'r');    
  
  preg_match("=\[number\](.*?)\[/number\]=si", $info_file, $num);
  preg_match("=\[name\](.*?)\[/name\]=si", $info_file, $name);
  
  echo cs_html_form(1,'roots','updates','roots');
  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'headb');
  echo $cs_lang['notification_update'].' '.cs_secure('#'.$num[1].' - '.$name[1]);
  echo cs_html_roco(0);  
  echo cs_html_roco(1,'centerb');
  echo cs_html_textarea('',$cs_lang['notice'],200,10,'readonly');
  echo cs_html_roco(0); 
  echo cs_html_roco(1,'centerc');
  echo cs_html_vote('file', $value, 'hidden'); 
  echo cs_html_vote('agree', $cs_lang['agree'], 'submit');
  echo cs_html_vote('', $cs_lang['disagree'], 'submit');
  echo cs_html_roco(0);
  echo cs_html_table(0); 
  echo cs_html_form(0);
  echo cs_html_br(1); 
  
} else {
  //Check for ZIP-Module in Apache
  if(extension_loaded('zip')) {
    $info_files = explode("?", file_get_contents($update_server.'update_check.php', 'r'));
    $info_files_count = (count($info_files)-1);
    unset($info_files[$info_files_count]); 
    rsort($info_files);
    
    if(!empty($info_files_count)) {   
      foreach($info_files AS $value) { 
        $info_file = file_get_contents($update_server.'infos/'.$value, "r");    
    
        preg_match("=\[number\](.*?)\[/number\]=si", $info_file, $num);
        preg_match("=\[name\](.*?)\[/name\]=si", $info_file, $name);  
        preg_match("=\[date\](.*?)\[/date\]=si", $info_file, $date);
        preg_match("=\[need\](.*?)\[/need\]=si", $info_file, $need);
        preg_match("=\[changelog\](.*?)\[/changelog\]=si", $info_file, $changes);
        
        $check_updatepack = cs_sql_count(__FILE__,'updates','updates_packet='.$num[1]);
        
        if($cs_main['version_id'] == $need[1] OR empty($need[1]) AND empty($check_updatepack)) {
          echo cs_html_form(1,'roots','updates','roots');
          echo cs_html_table(1,'forum',1);
          echo cs_html_roco(1,'headb');
          echo $cs_lang['packet'].' '.cs_secure('#'.$num[1].' - '.$name[1]);
          echo cs_html_roco(0);  
          echo cs_html_roco(1,'leftb');
          echo cs_secure(substr($changes[1],0,200).'...',1,0);  
          echo cs_html_br(2);
          echo cs_html_big(1).$cs_lang['complete_changelog'].cs_html_big(0);
          echo cs_html_roco(0); 
          echo cs_html_roco(1,'rightc'); 
          echo cs_html_vote('file', $value, 'hidden');
          echo cs_html_vote('details', $cs_lang['details'], 'submit');
          echo cs_html_vote('update', $cs_lang['update'], 'submit');
          echo cs_html_roco(0);
          echo cs_html_table(0); 
          echo cs_html_form(0);
          echo cs_html_br(1);
          $notice = 1;
        } elseif(empty($notice)) {
          echo cs_html_table(1,'forum',1); 
          echo cs_html_roco(1,'headb');
          echo $cs_lang['notification'];
          echo cs_html_roco(0);
          echo cs_html_roco(1,'leftb');
          echo $cs_lang['no_updates']; 
          echo cs_html_roco(0); 
          echo cs_html_table(0); 
          $notice = 1;
        }   
      }
    } else {
      echo cs_html_table(1,'forum',1); 
      echo cs_html_roco(1,'headb');
      echo $cs_lang['notification'];
      echo cs_html_roco(0);
      echo cs_html_roco(1,'leftb');
      echo $cs_lang['no_updates']; 
      echo cs_html_roco(0); 
      echo cs_html_table(0); 
    }
  } else {
    echo cs_html_table(1,'forum',1); 
    echo cs_html_roco(1,'headb');
    echo $cs_lang['error'];
    echo cs_html_roco(0);
    echo cs_html_roco(1,'leftb');
    echo $cs_lang['not_avaible']; 
    echo cs_html_br(2);
    echo cs_html_link('http://de3.php.net/manual/en/book.zip.php', 'http://de3.php.net/manual/en/book.zip.php');
    echo cs_html_roco(0); 
    echo cs_html_table(0);
  }
}
?>