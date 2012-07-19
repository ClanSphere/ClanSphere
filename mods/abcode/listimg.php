<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('abcode');

$name = empty($_GET['name']) ? '' : $_GET['name'];
$name = preg_replace('/[^\w]/s','',$name);

$where = "abcode_func = 'img'";
$cs_abcode = cs_sql_select(__FILE__,'abcode','*',$where,'abcode_pattern ASC',0,0);
$abcode_loop = count($cs_abcode);

for($run=0; $run<$abcode_loop; $run++) {
  $data['abcode'][$run]['pattern'] = cs_secure($cs_abcode[$run]['abcode_pattern']);
  $img = cs_secure($cs_abcode[$run]['abcode_pattern'],1,1);
  $url = "javascript:abc_insert_list('".$cs_abcode[$run]['abcode_pattern']."','','".$name."')";
  $data['abcode'][$run]['result'] = cs_html_link($url,$img,0);
}
echo cs_subtemplate(__FILE__,$data,'abcode','listimg');