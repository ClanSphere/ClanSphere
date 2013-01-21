<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('history');
$cs_post = cs_post('id');
$cs_get = cs_get('id');

$history_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $history_id = $cs_post['id'];

$data = array();
$data['if']['preview'] = FALSE;

if(isset($_POST['submit']) OR isset($_POST['preview'])) {
  
  $history['history_text'] = empty($cs_main['rte_html']) ? $_POST['history_text'] : cs_abcode_inhtml($_POST['history_text'], 'add');
  
  if (!empty($_POST['history_newtime'])) {
    $history['history_time'] = cs_time();
    $newtime = 1;
  }
  
  $error = '';
  
  if(empty($history['history_text'])) {
    $error .= $cs_lang['no_text'] . cs_html_br(1); 
  }
  
} else {
  
  $history = cs_sql_select(__FILE__,'history','history_time, history_text, users_id',"history_id = '" . $history_id . "'");
  $newtime = 0;
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

  $data['preview']['text'] = cs_secure($history['history_text'],1,1,1,1);
}

if(!empty($error) OR !isset($_POST['submit']) OR isset($_POST['preview'])) {

  if(empty($cs_main['rte_html'])) {
    $data['if']['no_rte_html'] = 1;
    $data['history']['abcode_smileys'] = cs_abcode_smileys('history_text', 1);
    $data['history']['abcode_features'] = cs_abcode_features('history_text', 1, 1);
    $data['history']['text'] = $history['history_text'];
    $data['if']['rte_html'] = 0;
  }
  else {
    $data['if']['rte_html'] = 1;
    $data['if']['no_rte_html'] = 0;
    $data['history']['rte_html'] = cs_rte_html('history_text',$history['history_text']);
  }
  $data['history']['new_time'] = $newtime == 1 ? 'checked="checked"' : '';
  $data['history']['id'] = $history_id;
  
  echo cs_subtemplate(__FILE__,$data,'history','edit');
  
} else {
  $history_cells = array_keys($history);
  $history_save = array_values($history);
  cs_sql_update(__FILE__,'history',$history_cells,$history_save,$history_id);
  
  cs_redirect($cs_lang['changes_done'],'history');
}
