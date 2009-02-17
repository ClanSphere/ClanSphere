<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$id = $_REQUEST['id'];

$users_id = $account['users_id'];
$abonements_cells = array('users_id','threads_id');
$abonements_save = array($users_id,$id);
cs_sql_insert(__FILE__,'abonements',$abonements_cells,$abonements_save);
  
header('location:' . $_SERVER['PHP_SELF'] . '?mod=board&action=thread&where=' .$id);

?>