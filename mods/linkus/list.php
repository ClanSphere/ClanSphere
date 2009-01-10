<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('linkus');

$linkus_count = cs_sql_count(__FILE__,'linkus');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,3);
echo $cs_lang['mod'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo sprintf($cs_lang['count_all'], $linkus_count);
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

$cs_linkus = cs_sql_select(__FILE__,'linkus','*',0,0,0,0);
$linkus_loop = count($cs_linkus);
for($run=0; $run<$linkus_loop; $run++) {
       
  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'headb');
  echo cs_secure($cs_linkus[$run]['linkus_name']);
  $place = 'uploads/linkus/' .$cs_linkus[$run]['linkus_banner'];
  $mass = getimagesize($place);
  echo cs_secure('  ('. $mass[0] .' x '. $mass[1] .') ');
  echo cs_html_roco(0);
  echo cs_html_roco(1,'leftc');
  echo cs_html_img ($place);
  echo cs_html_roco(0);
  echo cs_html_roco(1,'leftc');
  echo $cs_lang['html'] . cs_html_br(1);
  $path = $_SERVER ["HTTP_HOST"] .dirname ($_SERVER ["SCRIPT_NAME"]);
  $url = $path . '/' . $place;
  $url = str_replace('//','/',$url);
  $code ='<a href="http://' .$cs_linkus[$run]['linkus_url']. '" target="_blank">';
  $code .='<img src="http://' . $url . '"></a>';
  echo cs_html_textarea('html_' . $run,$code,50,2,1);
  echo cs_html_br(1);
  echo $cs_lang['abcode'] . cs_html_br(1);
  $code = '[url=http://' . $cs_linkus[$run]['linkus_url'] . ']';
  $code .= '[img]http://' . $url . '[/img][/url]';
  echo cs_html_textarea('abcode_' . $run,$code,50,2,1);
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_br(1);
}
?>