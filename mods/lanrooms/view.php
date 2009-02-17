<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanrooms');

if(empty($_REQUEST['lanroomd_id'])) {
  $lanrooms_id = $_REQUEST['id'];
  settype($lanrooms_id,'integer');
  $lanroomd_id = 0;
}
else {
  $lanroomd_id = $_REQUEST['lanroomd_id'];
  settype($lanroomd_id,'integer');
  $lanrooms = cs_sql_select(__FILE__,'lanroomd','*',"lanroomd_id = '" . $lanroomd_id . "'");
  $lanrooms_id = $lanrooms['lanrooms_id'];
}

$cs_lanrooms = cs_sql_select(__FILE__,'lanrooms','*',"lanrooms_id = '" . $lanrooms_id . "'");

$data['lan']['body'] = cs_secure($cs_lanrooms['lanrooms_name']);

include('mods/lanrooms/functions.php');
$data['lan']['map'] = cs_lanroom('lanrooms','view',$lanrooms_id,$lanroomd_id);

echo cs_subtemplate(__FILE__,$data,'lanrooms','view');
?>