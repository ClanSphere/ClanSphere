<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('links');

$cs_links_id = $_GET['id'];
settype($cs_links_id,'integer');

$cs_links = cs_sql_select(__FILE__,'links','*',"links_id = '" . $cs_links_id . "'");

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,3);
echo $cs_lang['mod'] . ' - ' . $cs_lang['head1'];
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('kedit') .$cs_lang['name'];
echo cs_html_roco(2,'leftb',0,2);
echo cs_secure ($cs_links['links_name']);
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('gohome') .$cs_lang['url'];
echo cs_html_roco(2,'leftb',0,2);
echo cs_html_link('http://' . $cs_links['links_url'],$cs_links['links_url']);
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('multimedia') . $cs_lang['status'];
echo cs_html_roco(2,'leftb',0,2);
if ($cs_links['links_stats'] == 'on') {
        echo cs_secure($cs_lang['online'],1);
        } else {
        echo cs_secure($cs_lang['offline'],1);
        }     
echo cs_html_roco(0);

if(!empty($cs_links['links_banner'])) {
echo cs_html_roco(1,'leftc',0,2);
$place = 'uploads/links/' .$cs_links['links_banner'];
echo cs_html_img($place);
echo cs_html_roco(0); 
}

echo cs_html_roco(1,'headb',0,2);
echo $cs_lang['info']; 
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc',0,2);
echo cs_secure ($cs_links['links_info'],1,1,1,1);
echo cs_html_roco(0);

echo cs_html_table(0);

?>