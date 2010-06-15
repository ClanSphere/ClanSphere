<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('notifymods');

$data = array();
$data['nm']['id'] = $_GET['id'];

if (isset($_POST['agree'])) {
  $id = $_POST['id'];
  cs_sql_delete(__FILE__,'notifymods',$id);
  cs_redirect($cs_lang['del_true'], 'notifymods');
}
else if (isset($_POST['cancel']))
  cs_redirect($cs_lang['del_false'], 'notifymods');
else {
  $data['head']['body'] = sprintf($cs_lang['del_rly'],$data['nm']['id']);
  echo cs_subtemplate(__FILE__,$data,'notifymods','remove');
}
