<?php
// ClanSphere 2010 - www.clansphere.net
// $Id: navlist.php 2266 2009-03-21 10:37:39Z duRiel $

$max = 0;

$select = 'ranks_url, ranks_img, ranks_code';
$data['ranks'] = cs_sql_select(__FILE__,'ranks',$select,0,$order,0,$max);
$ranks_loop = count($data['ranks']);

for($run = 0; $run < $ranks_loop; $run++) {

  $data['ranks'][$run]['picture'] = '';
  if(!empty($data['ranks'][$run]['ranks_url'])) {
    $picture = cs_html_img($data['ranks'][$run]['ranks_img']);
    $data['ranks'][$run]['picture'] = cs_html_link($data['ranks'][$run]['ranks_url'],$picture);
  } else {
    $data['ranks'][$run]['picture'] = $data['ranks'][$run]['ranks_code'];
  }
}

echo cs_subtemplate(__FILE__,$data,'ranks','navlist');
