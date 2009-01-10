<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('links');

$categories_id = empty($_GET['id']) ? $_REQUEST['where'] : $_GET['id']; 
settype($categories_id,'integer');

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'links_name DESC';
$cs_sort[2] = 'links_name ASC';
$sort = empty($_REQUEST['sort']) ? 1 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$links_count = cs_sql_count(__FILE__,'links','categories_id =' .$categories_id);

$categories_data = cs_sql_select(__FILE__,'categories','*',"categories_id = '" . $categories_id . "'",'categories_name',0,0);
$categories_loop = count($categories_data);

for($run=0; $run<$categories_loop; $run++) {
echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,3);
echo cs_secure($cs_lang['mod'] . ' - ' . $categories_data[$run]['categories_name']);
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo cs_secure ($categories_data[$run]['categories_text']);
echo cs_html_roco(2,'rightb');
echo cs_pages('links','listcat',$links_count,$start,$categories_id,$sort);
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);
}

$cs_links = cs_sql_select(__FILE__,'links','*',"categories_id = '" . $categories_id . "'",$order,$start,$account['users_limit']);
$links_loop = count($cs_links);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo cs_sort('links','listcat',$start,$categories_id,1,$sort);
echo $cs_lang['name'];
echo cs_html_roco(2,'headb');
echo $cs_lang['url'];
echo cs_html_roco(3,'headb');
echo $cs_lang['stat'];
echo cs_html_roco(0);

for($run=0; $run<$links_loop; $run++) {

	echo cs_html_roco(1,'leftc');
	echo cs_link($cs_links[$run]['links_name'],'links','view','id=' . $cs_links[$run]['links_id']);
	echo cs_html_roco(2,'leftc');
	echo cs_html_link('http://' . $cs_links[$run]['links_url'],$cs_links[$run]['links_url']);
	echo cs_html_roco(3,'leftc');
	if ($cs_links[$run]['links_stats'] == 'on') {
        echo cs_secure($cs_lang['online'],1);
        } else {
        echo cs_secure($cs_lang['offline'],1);
        }     
       
	echo cs_html_roco(0);
}

echo cs_html_table(0);

?>