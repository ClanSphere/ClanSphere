<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('buddys');

$data = array();

$buddys_form = 1;
$buddys_id = $_REQUEST['id'];
settype($buddys_id,'integer');

if(isset($_POST['agree'])) {
  $data['if']['agree']  = TRUE;
  $data['if']['cancel'] = FALSE;
  $data['if']['form']   = FALSE;
  
  $buddys_form = 0;
  $buddy = cs_sql_select(__FILE__,'buddys','users_id',"buddys_id = '" . $buddys_id . "'");
  if($buddy['users_id'] == $account['users_id'] OR $account['access_buddys'] >= 5) {
    cs_sql_delete(__FILE__,'buddys',$buddys_id);
      cs_redirect($cs_lang['del_true'], 'buddys','center');
  }
  else {
    cs_redirect($cs_lang['del_false'], 'buddys','center');
  }

  $data['head']['msg'] = $msg;
}

if(isset($_POST['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'buddys','center');
}

if(!empty($buddys_form)) {

  $data['if']['agree']  = FALSE;
  $data['if']['cancel'] = FALSE;
  $data['if']['form']   = TRUE;
  
  $data['head']['buddy']  = sprintf($cs_lang['del_rly'],$buddys_id);
  $data['head']['id']     = $buddys_id;
  
}

echo cs_subtemplate(__FILE__,$data,'buddys','remove');

?>