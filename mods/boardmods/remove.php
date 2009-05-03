<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('boardmods');

$data = array();
$data['bm']['id'] = $_GET['id'];

if(isset($_POST['agree'])) {
  $id = $_POST['id'];
  cs_sql_delete(__FILE__,'boardmods',$id);
  cs_redirect($cs_lang['del_true'], 'boardmods');
}
elseif(isset($_POST['cancel'])) 
  cs_redirect($cs_lang['del_false'], 'boardmods');
else {
  $data['head']['body'] = sprintf($cs_lang['del_rly'],$data['bm']['id']);
  echo cs_subtemplate(__FILE__,$data,'boardmods','remove');
}
