<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clansphere');

$data = array();
$select = 'metatags_id, metatags_name, metatags_content';
$where = 'metatags_active = 1';
$order = 'metatags_name';
$cs_metatags = cs_sql_select(__FILE__,'metatags',$select,$where,$order,0,0, 'metatags');
$metatags_loop = count($cs_metatags);
  
for($run = 0; $run < $metatags_loop; $run++) {
  $cs_metatags[$run]['name'] = $cs_metatags[$run]['metatags_name'];
  $cs_metatags[$run]['content'] = $cs_metatags[$run]['metatags_content'];
}

$data['metatags'] = $cs_metatags;

echo cs_subtemplate(__FILE__,$data,'clansphere','navmeta');