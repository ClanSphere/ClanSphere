<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('count');

$op_count = cs_sql_option(__FILE__,'count');

$data = array();
$combine = array();
$archive = 0;
$comnr = 0;

$count_navall = cs_sql_count(__FILE__,'count');
$count_arcall = cs_sql_count(__FILE__,'count_archiv');

if ($op_count['view'] == 'stats') {

  $levels = 6;
  $count_archive = cs_sql_select(__FILE__,'count_archiv','count_month, count_num',0,'count_id DESC',0,0);
  
} elseif ($op_count['view'] == 'amstats') {
  
  $levels = empty($count_arcall) ? 1 : $count_arcall + 1;
  $count_archive = cs_sql_select(__FILE__,'count_archiv','count_month, count_num',0,'count_id ASC',0,0);

}

if(!empty($count_archive)) {
  foreach($count_archive AS $value) {
    $combine['' . $value['count_month'] . ''] = $value['count_num'];
    $archive += $value['count_num'];
  }
}

$tday = cs_datereal('d');
$tmonth = cs_datereal('n');
$tyear = cs_datereal('Y');
$daystart = mktime(0,0,0,$tmonth,$tday,$tyear);
$daystart = cs_timediff($daystart, 1);

$month = cs_sql_select(__FILE__, 'count_archiv', 'SUM(count_num) AS count', 'count_mode = "1"', 0, 0, 0);
$count_month = $month[0]['count'];

$count_navmon = cs_sql_count(__FILE__,'count') + $count_month;
$count_navday = cs_sql_count(__FILE__,'count','count_time > ' . $daystart);

$data['head']['all']  = number_format($count_navall + $archive,0,',','.');
$data['head']['month']  = number_format($count_navmon,0,',','.');
$data['head']['today']  = number_format($count_navday,0,',','.');

$mon = array(1 => $cs_lang['jan'], 2 => $cs_lang['feb'], 3 => $cs_lang['mar'], 4 => $cs_lang['apr'],
5 => $cs_lang['mai'], 6 => $cs_lang['jun'], 7 => $cs_lang['jul'], 8 => $cs_lang['aug'], 9 => $cs_lang['sept'],
10 => $cs_lang['okt'], 11 => $cs_lang['nov'], 12 => $cs_lang['dez']);

$comnr_max = 0;
$vyear = cs_datereal('Y');
$loopm = $tmonth - $levels + 1;
for($loopm = $loopm; $loopm < 1; $loopm = $loopm + 12) {
  $vyear--;
}

for($run=0; $run < $levels; $run++) {

  if($loopm > 12) {
    $loopm = $loopm - 12;
    $vyear++;
  }
  $days = date('t', mktime(0,0,0,$loopm,0,$vyear));
  if($loopm == cs_datereal('n') AND $vyear == cs_datereal('Y')) $days = cs_datereal('j');

  $mstar = mktime(0,0,0,$loopm,1,$vyear);
  $mend = mktime(0,0,0,($loopm + 1),1,$vyear);

  $comnr = isset($combine[$loopm . '-' . $vyear]) ? $combine[$loopm . '-' . $vyear] : 0;
  $comnr = $comnr + cs_sql_count(__FILE__,'count','count_time > ' . $mstar . ' AND count_time < ' . $mend);
  if($comnr > $comnr_max) {
    $comnr_max = $comnr;
  }

  $data['count'][$run]['year-mon']  = $vyear . ' - ' . $mon[$loopm];
  $data['count'][$run]['day']       = round($comnr / $days,0);
  $data['count'][$run]['count']     = $comnr;
  $loopm++;
}
$run = 0;
$count = $data['count'][0]['count'];
foreach($data['count'] AS $dc) {  
  
  if ($data['count'][$run]['count'] == 0){
    $data['count'][$run]['size'] = '-';
    $data['count'][$run]['diff'] = '-';
    $data['count'][$run]['barp_start'] = '';
    $data['count'][$run]['barp_end'] = '';
  }
  else {
    $data['count'][$run]['barp'] = round($data['count'][$run]['count'] / $comnr_max * 200);
    $data['count'][$run]['size'] = cs_html_img('symbols/clansphere/bar2.gif', 12, $data['count'][$run]['barp']);
  
    if (empty($data['count'][$run-1]['count'])) {
      $data['count'][$run]['diff'] = '-';
    }  
    else {
      $diff = empty($count) ? ($data['count'][$run]['count'] * 100) . '%' : round($data['count'][$run]['count'] / $count * 100 - 100,2) . '%';
      $data['count'][$run]['diff'] = substr($diff,0,1) == '-' ? str_replace('-', '- ', $diff) : '+ ' . $diff;
    }
  
    $data['count'][$run]['barp_start'] = cs_html_img('symbols/clansphere/bar1.gif',12,2);
    $data['count'][$run]['barp_end'] = cs_html_img('symbols/clansphere/bar3.gif',12,2);
  }  
  
  $count = $data['count'][$run]['count']; 
  $run++;
}

if ($op_count['view'] == 'stats'){
  echo cs_subtemplate(__FILE__,$data,'count','stats');
}
$run = 0;
if ($op_count['view'] == 'amstats'){
	$backup = $data['count'];
  
  echo cs_subtemplate(__FILE__,$data,'count','statshead');
unset($data['count']);
?>
<script type="text/javascript" src="<?php echo $cs_main['php_self']['dirname']; ?>mods/count/amline/swfobject.js"></script>
<div id="flashcontent">
<?php
echo cs_subtemplate(__FILE__,$data,'count','flash');
$data['count'] = $backup;
?>
</div>
<?php
echo "<script type=\"text/javascript\">\n
  //<![CDATA[\n
  var so = new SWFObject(\"" . $cs_main['php_self']['dirname'] . "mods/count/amline/amline.swf\", \"amline\", \"" . $op_count['width'] . "%\", \"" . $op_count['height'] . "px\", \"8\", \"#" . $op_count['background'] . "\");\n
  so.addVariable(\"path\", \"" . $cs_main['php_self']['dirname'] . "mods/count/amline/\");\n
  so.addVariable(\"chart_settings\",\"<settings><text_size>" . $op_count['textsize'] . "</text_size><text_color>" . $op_count['textcolor'] . "</text_color><redraw>true</redraw><background><color>#" . $op_count['background'] . "</color><alpha>100</alpha></background><scroller><enabled>true</enabled></scroller><grid><x><enabled>true</enabled><color>#" . $op_count['textcolor'] . "</color><dashed>true</dashed><dash_length>3</dash_length><approx_count>12</approx_count></x><y_left><enabled>true</enabled><color>#" . $op_count['textcolor'] . "</color></y_left><y_right><enabled>true</enabled><color>#" . $op_count['textcolor'] . "</color></y_right></grid><axes><x><color>" . $op_count['axescolor'] . "</color></x><y_left><color>#" . $op_count['axescolor'] . "</color><tick_length>10</tick_length></y_left><y_right><color>#" . $op_count['axescolor'] . "</color></y_right></axes><indicator><enabled>true</enabled><color>#" . $op_count['indicatorcolor'] . "</color><selection_color>#3972ad</selection_color><y_balloon_on_off>true</y_balloon_on_off></indicator><legend><y>380</y><text_color_hover>#" . $op_count['graphcolor1'] . "</text_color_hover></legend><labels><label><align>left</align><text_size>7</text_size><text></text></label></labels><graphs><graph gid='1'><axis>left</axis><title>Nominal</title><color>#" . $op_count['graphcolor1'] . "</color><color_hover>#" . $op_count['graphcolor1'] . "</color_hover><line_width>4</line_width><fill_alpha>30</fill_alpha><fill_color>#" . $op_count['graphcolor1'] . "</fill_color><balloon_color>#" . $op_count['graphcolor1'] . "</balloon_color><balloon_text_color>#" . $op_count['textballoncolor'] . "</balloon_text_color><bullet_color>#" . $op_count['graphcolor1'] . "</bullet_color><balloon_text>{value} " . $cs_lang['guest'] . "</balloon_text></graph><graph gid='2'><axis>left</axis><title>Nominal</title><color>#" . $op_count['graphcolor2'] . "</color><color_hover>#" . $op_count['graphcolor2'] . "</color_hover><line_width>4</line_width><fill_alpha>30</fill_alpha><fill_color>#" . $op_count['graphcolor2'] . "</fill_color><balloon_color>#" . $op_count['graphcolor2'] . "</balloon_color><balloon_text_color>#" . $op_count['textballoncolor'] . "</balloon_text_color><bullet_color>#" . $op_count['indicatorcolor'] . "</bullet_color><balloon_text>" . $cs_lang['daydif'] . " {value}</balloon_text></graph></graphs></settings>\");\n

  so.addVariable(\"chart_data\", \"<chart><series>";
$loop = 1;
for($run=0; $run < $levels; $run++) {
  echo "<value xid='" . $loop . "'>" . $data['count'][$run]['year-mon'] . "</value>";
  $loop++;
}
echo "</series><graphs><graph gid='1' title='" . $cs_lang['guest'] . "'>";
$loop = 1;
for($run=0; $run < $levels; $run++) {
  echo "<value xid='" . $loop . "'>" . $data['count'][$run]['count'] . "</value>";
  $loop++;
}
echo "</graph><graph gid='2' title='" . $cs_lang['daydif'] . "'>";
$loop = 1;
for($run=0; $run < $levels; $run++) {
  echo "<value xid='" . $loop . "'>" . $data['count'][$run]['day'] . "</value>";
  $loop++;
}
echo "</graph></graphs></chart>\");\n
  so.addVariable(\"preloader_color\", \"#" . $op_count['textcolor'] . "\");\n
  so.write(\"flashcontent\");\n
  //]]>\n
</script>\n";
}