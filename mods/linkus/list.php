<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('linkus');

$linkus_count = cs_sql_count(__FILE__,'linkus');
$data['head']['body'] = sprintf($cs_lang['count_all'], $linkus_count);

$data['linkus'] = cs_sql_select(__FILE__,'linkus','*',0,0,0,0);
$linkus_loop = count($data['linkus']);

for($run = 0; $run < $linkus_loop; $run++) {
  
  $data['linkus'][$run]['name'] = cs_secure($data['linkus'][$run]['linkus_name']);
  $place = 'uploads/linkus/' . $data['linkus'][$run]['linkus_banner'];
  $mass = getimagesize($place);
  $data['linkus'][$run]['mass'] = cs_secure('('. $mass[0] .' x '. $mass[1] .')');
  $data['linkus'][$run]['banner'] = cs_html_img($place);

  $path = $cs_main['php_self']['website'] . $cs_main['php_self']['dirname'];
  $url = $path . $place;
  $code ='<a href="http://' .$data['linkus'][$run]['linkus_url']. '" target="_blank">';
  $code .='<img src="' . $url . '"></a>';
  $data['linkus'][$run]['html_code'] = htmlspecialchars($code, ENT_QUOTES, $cs_main['charset']);

  $ab = '[url=http://' . $data['linkus'][$run]['linkus_url'] . ']';
  $ab .= '[img]' . $url . '[/img][/url]';
  $data['linkus'][$run]['abcode'] = $ab;
  
  $data['linkus'][$run]['run'] = $run;
}

echo cs_subtemplate(__FILE__,$data,'linkus','list');