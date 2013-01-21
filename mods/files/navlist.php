<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('files');
$cs_get = cs_get('catid');
$cs_option = cs_sql_option(__FILE__,'files');
$data = array();

$join = 'files fls INNER JOIN {pre}_categories cat ON fls.categories_id = cat.categories_id';
$select = 'files_name, files_time, files_id';
$where = 'cat.categories_access <= ' . (int) $account['access_files'];
if(!empty($cs_get['catid'])) {
  $where .= ' AND cat.categories_id = ' . $cs_get['catid'];
}
$order = 'files_time DESC';
$data['files'] = cs_sql_select(__FILE__,$join,$select,$where,$order,0,$cs_option['max_navlist']);

if (!empty($data['files'])) {
  $files_loop = count($data['files']);
  for($run=0; $run<$files_loop; $run++) {
    $data['files'][$run]['date'] = cs_date('unix',$data['files'][$run]['files_time']);
    $data['files'][$run]['files_name'] = strlen($data['files'][$run]['files_name']) > $cs_option['max_headline'] ? cs_substr($data['files'][$run]['files_name'], 0, $cs_option['max_headline']).'..' : $data['files'][$run]['files_name'];
  }

  echo cs_subtemplate(__FILE__,$data,'files','navlist');
}
else {
  echo $cs_lang['no_data'];
}