<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('files');

$max = 4;

$cs_files = cs_sql_select(__FILE__,'files','files_name, files_id, files_count',0,'files_count DESC',0,$max);

if (!empty($cs_files)) {

  $data = array();
  $count = 1;
  $count_files = count($cs_files);
  for ($run = 0; $run < $count_files; $run++) {
    $cs_files[$run]['count'] = $count;
    $cs_files[$run]['url'] = cs_url('files','view','where='.$cs_files[$run]['files_id']);
    $count++;
  }
  
  $data['files'] = $cs_files;
  
  echo cs_subtemplate(__FILE__,$data,'files','navtop');
  
} else {

  echo $cs_lang['no_data'];
  
}

?>