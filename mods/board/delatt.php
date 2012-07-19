<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

$att_form = 1;
$att_id = $_REQUEST['id'];
settype($att_id,'integer');

if(isset($_POST['agree'])) {
  $att_form = 0;
  $select = 'users_id, boardfiles_name';
  $computer = cs_sql_select(__FILE__,'boardfiles',$select,'boardfiles_id = ' . $att_id);
  
  if($computer['users_id'] == $account['users_id'] OR $account['access_board'] >= 5) {       
    $file = $computer['boardfiles_name'];
    $extension = strlen(strrchr($file,"."));
    $name = strlen($file);
    $ext = substr($file,$name - $extension + 1,$name); 

    cs_unlink('board', $att_id . '.' . $ext, 'files');
    cs_sql_delete(__FILE__,'boardfiles',$att_id);  
  }
  cs_redirect($cs_lang['delatt_done'], 'board', 'attachments');
}

if(isset($_POST['cancel'])) {
  $att_form = 0;
  cs_redirect($cs_lang['delatt_done'], 'board', 'attachments');
}

if(!empty($att_form)) {
  $search_user = cs_sql_select(__FILE__,'boardfiles','users_id','boardfiles_id = ' . $att_id);
  
  if($search_user['users_id'] == $account['users_id'] OR $account['access_board'] >= 5) {      
    $data['if']['not_account'] = false;
    $data['if']['account'] = true;
    
    $data['lang']['body'] = sprintf($cs_lang['del_rly'],$att_id);
    $data['action']['form'] = cs_url('board','delatt');
    $data['att']['id'] = $att_id;
  }
  else {
    $data['if']['not_account'] = true;
    $data['if']['account'] = false;
  }
  
  echo cs_subtemplate(__FILE__,$data,'board','delatt');
}