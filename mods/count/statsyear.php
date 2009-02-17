<?php
//CLANSPHERE.de CMS /mods/count/statsyear.php
//Freitag, 8. Februar 2008 15:53:46

$cs_lang = cs_translate('count');
$op_count = cs_sql_option(__FILE__,'count');

$data = array();
$combine = array();
$archive = 0;
$comnr = 0;
$levels = 12;
$mon = 1;

$where = empty($_REQUEST['where']) ? $_GET['year'] : $_REQUEST['where'];
settype($where,'integer');
$year = 'count_month like "%'.strtolower($where).'%"';

$data['head']['year']  = $where;

$count_navall = cs_sql_count(__FILE__,'count');
$count_arcall = cs_sql_count(__FILE__,'count_archiv',$year);
  
for($run=0; $run<$levels; $run++) {
  $is_mon = 'count_month = "' . $mon . '-' .$where .'"';
  $count_archive = cs_sql_select(__FILE__,'count_archiv','*',$is_mon,0,0,1);
  $mon++;
  $count_archive['count_num'] = empty($count_archive['count_num']) ? '0' : $count_archive['count_num'];
}

$tday = cs_datereal('d');
$tmonth = cs_datereal('n');
$tyear = cs_datereal('Y');
$daystart = mktime(0,0,0,$tmonth,$tday,$tyear);
$monthstart = mktime(0,0,0,$tmonth,1,$tyear);
$count_navmon = cs_sql_count(__FILE__,'count','count_time > ' . $monthstart);
$count_navday = cs_sql_count(__FILE__,'count','count_time > ' . $daystart);

$mon = array(1 => $cs_lang['jan'], 2 => $cs_lang['feb'], 3 => $cs_lang['mar'], 4 => $cs_lang['apr'],
5 => $cs_lang['mai'], 6 => $cs_lang['jun'], 7 => $cs_lang['jul'], 8 => $cs_lang['aug'], 9 => $cs_lang['sept'],
10 => $cs_lang['okt'], 11 => $cs_lang['nov'], 12 => $cs_lang['dez']);

$comnr_max = 0;
$vyear = cs_datereal('Y');
$loopm = $tmonth - $levels - 2;
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
  $comnr = isset($combine[$loopm]) ? $combine[$loopm] : 0;
  $comnr = $comnr + cs_sql_count(__FILE__,'count','count_time > ' . $mstar . ' AND count_time < ' . $mend);
    if($comnr > $comnr_max) {
    $comnr_max = $comnr;
    }
  $data['count'][$run]['year-mon']  = $mon[$loopm];
  $data['count'][$run]['day']       = round($comnr / $days,0);
  $data['count'][$run]['count']     = $comnr;
  $loopm++;
}

echo cs_subtemplate(__FILE__,$data,'count','statsyear');
?>
<script type="text/javascript" src="<?php echo $cs_main['php_self']['dirname']; ?>mods/count/amline/swfobject.js"></script>
<div id="flashcontent">
<?
echo cs_subtemplate(__FILE__,$data,'count','flash');
?>
</div>
<?
echo "\n <script type=\"text/javascript\">\n
    //<![CDATA[\n
    var so = new SWFObject(\"" . $cs_main['php_self']['dirname'] . "mods/count/amline/amline.swf\", \"amline\", \"" . $op_count['width'] . "%\", \"" . $op_count['height'] . "px\", \"8\", \"#" . $op_count['background'] . "\");\n
    so.addVariable(\"path\", \"" . $cs_main['php_self']['dirname'] . "mods/count/amline/\");\n
    so.addVariable(\"chart_settings\",\"<settings><text_size>" . $op_count['textsize'] . "</text_size><text_color>" . $op_count['textcolor'] . "</text_color><redraw>true</redraw><background><color>#" . $op_count['background'] . "</color><alpha>100</alpha></background><scroller><enabled>true</enabled></scroller><grid><x><enabled>true</enabled><color>#" . $op_count['textcolor'] . "</color><dashed>true</dashed><dash_length>3</dash_length><approx_count>12</approx_count></x><y_left><enabled>true</enabled><color>#" . $op_count['textcolor'] . "</color></y_left><y_right><enabled>true</enabled><color>#" . $op_count['textcolor'] . "</color></y_right></grid><axes><x><color>" . $op_count['axescolor'] . "</color></x><y_left><color>#" . $op_count['axescolor'] . "</color><tick_length>10</tick_length></y_left><y_right><color>#" . $op_count['axescolor'] . "</color></y_right></axes><indicator><enabled>true</enabled><color>#" . $op_count['indicatorcolor'] . "</color><selection_color>#3972ad</selection_color><y_balloon_on_off>true</y_balloon_on_off></indicator><legend><y>380</y><text_color_hover>#" . $op_count['graphcolor1'] . "</text_color_hover></legend><labels><label><align>left</align><text_size>7</text_size><text></text></label></labels><graphs><graph gid='1'><axis>left</axis><title>Nominal</title><color>#" . $op_count['graphcolor1'] . "</color><color_hover>#" . $op_count['graphcolor1'] . "</color_hover><line_width>4</line_width><fill_alpha>30</fill_alpha><fill_color>#" . $op_count['graphcolor1'] . "</fill_color><balloon_color>#" . $op_count['graphcolor1'] . "</balloon_color><balloon_text_color>#" . $op_count['textballoncolor'] . "</balloon_text_color><bullet_color>#" . $op_count['graphcolor1'] . "</bullet_color><balloon_text>{value} " . $cs_lang['visitors'] . "</balloon_text></graph><graph gid='2'><axis>left</axis><title>Nominal</title><color>#" . $op_count['graphcolor2'] . "</color><color_hover>#" . $op_count['graphcolor2'] . "</color_hover><line_width>4</line_width><fill_alpha>30</fill_alpha><fill_color>#" . $op_count['graphcolor2'] . "</fill_color><balloon_color>#" . $op_count['graphcolor2'] . "</balloon_color><balloon_text_color>#" . $op_count['textballoncolor'] . "</balloon_text_color><bullet_color>#" . $op_count['indicatorcolor'] . "</bullet_color><balloon_text>" . $cs_lang['average'] . " {value}</balloon_text></graph></graphs></settings>\");\n

    so.addVariable(\"chart_data\", \"<chart><series>";

$loop = 1;
for($run=0; $run < $levels; $run++) {
  echo "<value xid='" . $loop . "'>" . $data['count'][$run]['year-mon'] . "</value>";
  $loop++;
}
echo "</series><graphs><graph gid='1' title='" . $cs_lang['guest'] . "'>";
$loop = 1;
$mon = 1;
for($run2=0; $run2 < $levels; $run2++) {
  $is_mon = 'count_month = "' . $mon . '-' .$where .'"';
  $days = date('t', mktime(0,0,0,$loop,0,$where));
  if($loop == cs_datereal('n') AND $where == cs_datereal('Y')) $days = cs_datereal('j');
  $mstar = mktime(0,0,0,$loop,1,$where);
  $mend = mktime(0,0,0,($loop + 1),1,$where);
  $comnr = cs_sql_count(__FILE__,'count','count_time > ' . $mstar . ' AND count_time < ' . $mend);
  $count_archive = cs_sql_select(__FILE__,'count_archiv','*',$is_mon,0,0,1);
  $count_archive['count_num'] = empty($count_archive['count_num']) ? '0' : $count_archive['count_num'];

  $countall = $comnr + $count_archive['count_num'];
  echo "<value xid='" . $loop . "'>" . $countall . "</value>";
  $loop++;
  $mon++;
}
echo "</graph><graph gid='2' title='" . $cs_lang['daydif'] . "'>";

$loop = 1;
$loopa = 1;
$mon = 1;
for($run3=0; $run3 < $levels; $run3++) {
    $is_mon = 'count_month = "' . $mon . '-' .$where .'"';
  $days = date('t', mktime(0,0,0,$loop,0,$where));
  if($loop == cs_datereal('n') AND $where == cs_datereal('Y')) $days = cs_datereal('j');
  $mstar = mktime(0,0,0,$loop,1,$where);
  $mend = mktime(0,0,0,($loop + 1),1,$where);
  $comnr = cs_sql_count(__FILE__,'count','count_time > ' . $mstar . ' AND count_time < ' . $mend);
  $count = cs_sql_select(__FILE__,'count_archiv','*',$is_mon,0,0,1);
    $countall = $count['count_num'] + $comnr;
  $aaa  = round($countall / $days,0);
  echo "<value xid='" . $loopa . "'>" . $aaa . "</value>";
  $mon++;
  $loop++;
  $loopa++;
}
echo  "</graph></graphs></chart>\");\n
    so.addVariable(\"preloader_color\", \"#FFFFFF\");\n
    so.write(\"flashcontent\");\n
      //]]>\n
\n </script>\n";
?>