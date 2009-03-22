<?php
// ClanSphere 2009 - www.clansphere.net
// Id: boardranks.php (Fri Dec  5 17:27:09 CET 2008) fAY-pA!N

$cs_lang = cs_translate('count');
$op_count = cs_sql_option(__FILE__,'count');

$data = array();
$combine = array();
$archive = 0;
$like1 = '2004';
$like2 = '2004';
$i = 0;
echo cs_subtemplate(__FILE__,$data,'count','statsall');

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

while ($like2 < 2010) {

$year2 = 'count_month like "%'.strtolower($like2).'%"';

$count_navall = cs_sql_count(__FILE__,'count');
$count_arcall = cs_sql_count(__FILE__,'count_archiv',$year2);

if (empty($count_arcall)){
   $a = 0;
   $b = $like1;
}else{
   $a = 5;
   $b = $like1 + $a;
}

while ($like1 < $b) { 

$year1 = 'count_month like "%'.strtolower($like1).'%"';

$count_archive = cs_sql_select(__FILE__,'count_archiv','*',$year1,0,0,0);

if(!empty($count_archive)) {
  foreach($count_archive AS $value) {
    $combine['' . $value['count_month'] . ''] = $value['count_num'];
    $archive = $archive + $value['count_num'];
  }
  echo "<value xid='" . $like1 . "'>" . $like1 . "</value>";
}
$archive = 0;
$like1++;
}
$like2++;
}

echo "</series><graphs><graph gid='1' title='" . $cs_lang['guest'] . "'>";

$like1 = '2004';
$like2 = '2004';

while ($like2 < 2010) {

$year2 = 'count_month like "%'.strtolower($like2).'%"';

$count_navall = cs_sql_count(__FILE__,'count');
$count_arcall = cs_sql_count(__FILE__,'count_archiv',$year2);

if (empty($count_arcall)){
   $a = 0;
   $b = $like1;
}else{
   $a = 5;
   $b = $like1 + $a;
}

while ($like1 < $b) { 

$year1 = 'count_month like "%'.strtolower($like1).'%"';

$count_archive = cs_sql_select(__FILE__,'count_archiv','*',$year1,0,0,0);

if(!empty($count_archive)) {
  foreach($count_archive AS $value) {
    $combine['' . $value['count_month'] . ''] = $value['count_num'];
    $archive = $archive + $value['count_num'];
  }
  echo "<value xid='" . $like1 . "'>" . $archive . "</value>";
}
$archive = 0;
$like1++;
}
$like2++;
}

echo  "</graph></graphs></chart>\");\n
    so.addVariable(\"preloader_color\", \"#FFFFFF\");\n
    so.write(\"flashcontent\");\n
    //]]>\n
</script>\n";
?>
