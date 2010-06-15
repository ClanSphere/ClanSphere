<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('files');

$max = 4;
$wordmax = 13;
$data = array();

$data['files'] = cs_sql_select(__FILE__,'files','files_name, files_time, files_id',0,'files_time DESC',0,$max);

if (!empty($data['files'])) {
  $files_loop = count($data['files']);
  for($run=0; $run<$files_loop; $run++) {
    $data['files'][$run]['date'] = cs_date('unix',$data['files'][$run]['files_time']);
    $data['files'][$run]['files_name'] = strlen($data['files'][$run]['files_name']) > $wordmax ? substr($data['files'][$run]['files_name'], 0, $wordmax).'..' : $data['files'][$run]['files_name'];
  }
  echo cs_subtemplate(__FILE__,$data,'files','navlist');
  
} else {

  echo $cs_lang['no_data'];
  
}