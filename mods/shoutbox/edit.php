<?php
// ClanSphere 2010 - www.clansphere.net 
// $Id$

$cs_lang = cs_translate('shoutbox');
$data = array();

if(!empty($_POST['submit'])) {
  $shoutbox_id = (int) $_POST['id'];
  $error = '';
  
  if(empty($_POST['name'])) {
    $error .= cs_html_br(1) . '- ' . $cs_lang['no_name'];
  }
  
  if(empty($_POST['message2'])) {
    $error .= cs_html_br(1) . '- ' . $cs_lang['no_text'];
  }
  
  if(empty($error)) {
    $cs_shoutbox = array();
    $cs_shoutbox['shoutbox_name'] = $_POST['name'];
    $cs_shoutbox['shoutbox_text'] = $_POST['message2'];
    
    if (isset($_POST['refresh'])) {
      $cs_shoutbox['shoutbox_date'] = cs_time();
  }
    
    $cells = array_keys($cs_shoutbox);
    $values = array_values($cs_shoutbox);
    
    cs_sql_update(__FILE__,'shoutbox',$cells,$values,$shoutbox_id);
    
    cs_redirect($cs_lang['changes_done'], 'shoutbox') ;
  }
}

if(empty($_POST['submit']) || !empty($error)) {
  $shoutbox_id = empty($error) ? (int) $_GET['id'] : $shoutbox_id;
  $cells = 'shoutbox_name, shoutbox_text';
  $cs_shoutbox = cs_sql_select(__FILE__,'shoutbox',$cells, 'shoutbox_id = \''.$shoutbox_id.'\'');
  
  $data['head']['text'] = empty($error) ? $cs_lang['errors_here'] : $cs_lang['error_occured'] . $error;
  $data['url']['form'] = cs_url('shoutbox','edit');
  
  $data['value']['nick'] = empty($error) ? $cs_shoutbox['shoutbox_name'] : $_POST['name'];
  $data['value']['text'] = empty($error) ? $cs_shoutbox['shoutbox_text'] : $_POST['message2'];
  $data['value']['id'] = $shoutbox_id;
  
  echo cs_subtemplate(__FILE__,$data,'shoutbox','edit'); 
}