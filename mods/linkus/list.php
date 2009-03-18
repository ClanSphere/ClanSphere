<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('linkus');

$linkus_count = cs_sql_count(__FILE__,'linkus');
$data['head']['body'] = sprintf($cs_lang['count_all'], $linkus_count);

$data['linkus'] = cs_sql_select(__FILE__,'linkus','*',0,0,0,0);
$linkus_loop = count($data['linkus']);


for($run=0; $run<$linkus_loop; $run++) {
  
  $data['linkus'][$run]['name'] = cs_secure($data['linkus'][$run]['linkus_name']);
  $place = 'uploads/linkus/' .$data['linkus'][$run]['linkus_banner'];
  $mass = getimagesize($place);
  $data['linkus'][$run]['mass'] = cs_secure('('. $mass[0] .' x '. $mass[1] .')');

  $path = $_SERVER ["HTTP_HOST"] .dirname ($_SERVER ["SCRIPT_NAME"]);
  $url = $path . '/' . $place;
  $url = str_replace('//','/',$url);
  $code ='<a href="http://' .$data['linkus'][$run]['linkus_url']. '" onclick="window.open(\'' . $data['linkus'][$run]['linkus_url'] . '\'); return false">';
  $code .='<img src="http://' . $url . '"></a>';
  $data['linkus'][$run]['html_code'] = $code;

  $ab = '[url=http://' . $data['linkus'][$run]['linkus_url'] . ']';
  $ab .= '[img]http://' . $url . '[/img][/url]';
  $data['linkus'][$run]['abcode'] = $ab;
  
  $data['linkus'][$run]['run'] = $run;
}

echo cs_subtemplate(__FILE__,$data,'linkus','list');

?>