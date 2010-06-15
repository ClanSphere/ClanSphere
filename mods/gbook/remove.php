<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gbook');
$cs_post = cs_post('id');
$cs_get = cs_get('id');
$data = array();

$gbook_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $gbook_id = $cs_post['id'];
if(!empty($_POST['from'])) $from = $_POST['from'];
elseif(!empty($_GET['from'])) $from = $_GET['from'];
$from = cs_secure($from, 0, 0, 0, 0, 0);
if($from == 'users') {
  $selid = cs_sql_select(__FILE__,'gbook','gbook_users_id',"gbook_id = '" . $gbook_id . "'",0,0);
  $action = 'users';
  $more = 'id=' . $selid['gbook_users_id'];
}else{
  $action = $from;
  $more = '';
}


if(isset($_POST['submit'])) {
  cs_sql_delete(__FILE__,'gbook',$gbook_id);
  cs_redirect($cs_lang['del_true'],'gbook',$action,$more);
}

if(isset($_POST['cancel']))
  cs_redirect($cs_lang['del_false'],'gbook',$action,$more);

else {

  $data['head']['body'] = sprintf($cs_lang['del_rly'],$gbook_id);
  $data['hidden']['from'] = $from;
  $data['hidden']['id'] = $gbook_id;
  
  echo cs_subtemplate(__FILE__,$data,'gbook','remove');
}