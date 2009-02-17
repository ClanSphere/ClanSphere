<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('links');

$links_count = cs_sql_count(__FILE__,'links','links_sponsor=1');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,3);
echo $cs_lang['mod1'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo sprintf($cs_lang['all1'], $links_count);
echo cs_html_table(0);
echo cs_html_br(1);

$cs_links = cs_sql_select(__FILE__,'links','links_name,links_banner,links_info,links_url','links_sponsor = 1',0,0,0);
$links_loop = count($cs_links);

for($run=0; $run<$links_loop; $run++) {
        
  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'headb');
  echo cs_secure($cs_links[$run]['links_name']);
  $place = 'uploads/links/' .$cs_links[$run]['links_banner'];
  echo cs_html_roco(0);
  echo cs_html_roco(2,'leftc');
  $img = cs_html_img ($place,0,0,0,$cs_links[$run]['links_name']);
  $target = 'http://' .$cs_links[$run]['links_url'];
  echo cs_html_link($target,$img);
        echo cs_html_roco(0);
  echo cs_html_roco(4,'leftc');
        echo cs_secure($cs_links[$run]['links_info'],1,1);
        echo cs_html_roco(0);
        echo cs_html_table(0);
        echo cs_html_br(1);
}

?>