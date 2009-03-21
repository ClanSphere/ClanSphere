<?php
// ClanSphere 2009 - www.clansphere.net
// Id: create.php (Sun Nov 23 18:14:33 CET 2008) fAY-pA!N

$cs_lang = cs_translate('history');

$data = array();
$data['if']['preview'] = FALSE;

if(isset($_POST['submit']) OR isset($_POST['preview'])) {
  
  $history['history_text'] = $_POST['history_text'];
  $history['history_time'] = cs_time();
  $history['users_id'] = $account['users_id'];
  
  if(!empty($cs_main['fckeditor'])) {
    $history['history_text'] = '[html]' . $_POST['history_text'] . '[/html]';
  }
  
  $error = '';
  
  if(empty($history['history_text'])) {
    $error .= $cs_lang['no_text'] . cs_html_br(1); 
  }
  
} else {
  $history['history_text'] = '';
  $history['history_time'] = '';
  $history['users_id'] = 0;
}

if(!isset($_POST['submit']) AND !isset($_POST['preview'])) {
  $data['head']['body'] = $cs_lang['body'];
} elseif(!empty($error)) {
  $data['head']['body'] = $error;
} elseif(isset($_POST['preview'])) {
  $data['head']['body'] = $cs_lang['preview'];
}
  
if(isset($_POST['preview']) AND empty($error)) {
  $data['if']['preview'] = TRUE;
  
  $data['preview']['date'] = cs_date('unix',$history['history_time'],1);

  $cs_user = cs_sql_select(__FILE__,'users','users_nick, users_active',"users_id = '" . $history['users_id'] . "'");
  $data['preview']['user'] = cs_user($history['users_id'],$cs_user['users_nick'],$cs_user['users_active']);
    
  if(!empty($cs_main['fckeditor'])) {
    $history['history_text'] = '[html]' . $_POST['history_text'] . '[/html]';
  }
  $data['preview']['text'] = cs_secure($history['history_text'],1,1,1,1);
}

if(!empty($error) OR !isset($_POST['submit']) OR isset($_POST['preview'])) {

  if(empty($cs_main['fckeditor'])) {
    $data['if']['no_fck'] = 1;
    $data['history']['abcode_smileys'] = cs_abcode_smileys('history_text');
    $data['history']['abcode_features'] = cs_abcode_features('history_text');
    $data['history']['text'] = $history['history_text'];
    $data['if']['fck'] = 0;
  }
  else {
    $data['if']['fck'] = 1;
    $data['if']['no_fck'] = 0;
    $data['history']['fck_editor'] = cs_fckeditor('history_text',$history['history_text']);
  }
  
  echo cs_subtemplate(__FILE__,$data,'history','create');
  
} else {
  $history_cells = array_keys($history);
  $history_save = array_keys($history);
  cs_sql_insert(__FILE__,'history',$history_cells,$history_save);
  
  cs_redirect($cs_lang['create_done'],'history');
}

?>
