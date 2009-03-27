<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('files');

$max = 4;

$data = array();

$data['files'] = cs_sql_select(__FILE__,'files','files_name, files_id',0,'files_time DESC',0,$max);

if (!empty($data['files'])) {
  
  echo cs_subtemplate(__FILE__,$data,'files','navlist');
  
} else {

  echo $cs_lang['no_data'];
  
}

?>