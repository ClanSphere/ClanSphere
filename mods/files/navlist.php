<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('files');
$cs_option = cs_sql_option(__FILE__,'files');

$data = array();

$where = 'cat.categories_access <= ' . (int) $account['access_files'];
$join = 'files fls INNER JOIN {pre}_categories cat ON fls.categories_id = cat.categories_id';
$data['files'] = cs_sql_select(__FILE__,$join,'files_name, files_time, files_id',$where,'files_time DESC',0,$cs_option['max_navlist']);

if (!empty($data['files'])) {
  $files_loop = count($data['files']);
  for($run=0; $run<$files_loop; $run++) {
    $data['files'][$run]['date'] = cs_date('unix',$data['files'][$run]['files_time']);
    $data['files'][$run]['files_name'] = strlen($data['files'][$run]['files_name']) > $cs_option['max_headline'] ? substr($data['files'][$run]['files_name'], 0, $cs_option['max_headline']).'..' : $data['files'][$run]['files_name'];
  }

  echo cs_subtemplate(__FILE__,$data,'files','navlist');
}
else
  echo $cs_lang['no_data'];