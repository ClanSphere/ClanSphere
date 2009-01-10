<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanpartys');

$select = 'lanpartys_name, lanpartys_start, lanpartys_location, lanpartys_maxguests, lanpartys_id';
$where = 'lanpartys_end > ' . cs_time();
$nav_lanparty = cs_sql_select(__FILE__,'lanpartys','*',$where,'lanpartys_start ASC');

if(empty($nav_lanparty)) {
	echo $cs_lang['no_upcoming_lan'];
}
else {
  $cs_lan_name = cs_secure($nav_lanparty['lanpartys_name']);
  $data['lanpartys']['name'] = cs_link($cs_lan_name,'lanpartys','view','id=' . $nav_lanparty['lanpartys_id']);
  $data['lanpartys']['date'] = cs_date('unix',$nav_lanparty['lanpartys_start']);
  $data['lanpartys']['location'] = cs_secure($nav_lanparty['lanpartys_location']);

  $bar = '';
  $status = '';
  $bar_count = array(1 => 0, 3 => 0, 4 => 0, 5 => 0);

  $where2 = "lanpartys_id = '" . $nav_lanparty['lanpartys_id'] . "'";
  $cs_languests = cs_sql_select(__FILE__,'languests','languests_status',$where2,0,0,0);
  $lgu_loop = count($cs_languests);
  
  for($run=0; $run<$lgu_loop; $run++) {
    $status = $cs_languests[$run]['languests_status'];
    $bar_count[$status]++;
  }
  
  $nav_lan['payed'] = $bar_count[3] + $bar_count[4];
  $bar_usage = $nav_lan['payed'] + $bar_count[1];

  if($bar_usage >= $nav_lanparty['lanpartys_maxguests']) {
    $nav_lan['signd'] = $nav_lanparty['lanpartys_maxguests'] - $nav_lan['payed'];
    $nav_lan['empty'] = 0;
  }
  else {
    $nav_lan['signd'] = $bar_count[1];
    $nav_lan['empty'] = $nav_lanparty['lanpartys_maxguests'] - $nav_lan['payed'] - $nav_lan['signd'];
  }
  
  if(!empty($nav_lan['payed'])) {
    $nav_lan['payed_perc'] = round($nav_lan['payed'] * 100 / $nav_lanparty['lanpartys_maxguests']);
    $bar_style = "style=\"height:12px;width:" . $nav_lan['payed_perc'] . "%\"";
    $bar .= cs_html_img('symbols/lanpartys/red.jpg',0,0,$bar_style);
  }

  if(!empty($nav_lan['signd'])) {
    $nav_lan['signd_perc'] = round($nav_lan['signd'] * 100 / $nav_lanparty['lanpartys_maxguests']);
	$bar_style = "style=\"height:12px;width:" . $nav_lan['signd_perc'] . "%\"";
	$bar .= cs_html_img('symbols/lanpartys/yellow.jpg',0,0,$bar_style);
  }
  
  if(!empty($nav_lan['empty'])) {
    $nav_lan['empty_perc'] = round($nav_lan['empty'] * 100 / $nav_lanparty['lanpartys_maxguests']);
	$bar_style = "style=\"height:12px;width:" . $nav_lan['empty_perc'] . "%\"";
	$bar .= cs_html_img('symbols/lanpartys/green.jpg',0,0,$bar_style);
  }	
	
  $bar = preg_replace("= \n=","",$bar);
  $data['lanpartys']['img'] = $bar;

  $data['lanpartys']['signd'] = ($nav_lan['signd'] + $nav_lan['payed']);
  $data['lanpartys']['payed'] = $nav_lan['payed'];
  $data['lanpartys']['empty'] = $nav_lan['empty'];
  $data['lanpartys']['all'] = $nav_lanparty['lanpartys_maxguests'];
	
  echo cs_subtemplate(__FILE__,$data,'lanpartys','navnext');
}
?>