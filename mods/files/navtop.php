<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('files');
$cs_get = cs_get('catid');
$cs_option = cs_sql_option(__FILE__,'files');
$data = array();

$join = 'files fls INNER JOIN {pre}_categories cat ON fls.categories_id = cat.categories_id';
$select = 'files_name, files_time, files_count, files_id';
$where = 'cat.categories_access <= ' . (int) $account['access_files'];
if(!empty($cs_get['catid'])) {
  $where .= ' AND cat.categories_id = ' . $cs_get['catid'];
}
$order = 'files_count DESC';
$data['files'] = cs_sql_select(__FILE__,$join,$select,$where,$order,0,$cs_option['max_navtop']);

if (!empty($data['files'])) {
  for($run=0; $run<count($data['files']); $run++) {
    $data['files'][$run]['date'] = cs_date('unix',$data['files'][$run]['files_time']);
    $data['files'][$run]['files_name'] = strlen($data['files'][$run]['files_name']) > $cs_option['max_headline_navtop'] ? cs_substr($data['files'][$run]['files_name'], 0, $cs_option['max_headline_navtop']).'..' : $data['files'][$run]['files_name'];
    $data['files'][$run]['count'] = $run+1;
  }
  echo cs_subtemplate(__FILE__,$data,'files','navtop');
}
else {
  echo $cs_lang['no_data'];
}