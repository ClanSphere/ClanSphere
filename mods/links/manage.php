<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('links');

include 'mods/categories/functions.php';

empty($_REQUEST['start']) ? $start = 0 : $start = $_REQUEST['start'];
$cs_sort[1] = 'links_name DESC';
$cs_sort[2] = 'links_name ASC';
empty($_REQUEST['sort']) ? $sort = 1 : $sort = $_REQUEST['sort'];
$order = $cs_sort[$sort];
$links_count = cs_sql_count(__FILE__,'links');

$categories_id = empty($_POST['categories_id']) ? 0 : (int) $_POST['categories_id'];
$cells = 'categories_id, categories_name';
$categories_data = cs_sql_select(__FILE__,'categories',$cells,'categories_mod = \'links\'','categories_name',0,0);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,3);
echo $cs_lang['mod'] . ' - ' . $cs_lang['head'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo cs_icon('editpaste') . cs_link($cs_lang['new_link'],'links','create');
echo cs_html_roco(2,'leftb');
echo cs_icon('contents') . $cs_lang['all'] . $links_count;
echo cs_html_roco(2,'rightb');
echo cs_pages('links','manage',$links_count,0,$start,$sort);
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb',0,3);
echo cs_html_form(1,'categorie_select','links','manage');
echo $cs_lang['category'] . ' ';
echo cs_dropdown('categories_id','categories_name',$categories_data,$categories_id);
echo cs_html_vote('submit',$cs_lang['show'],'submit');
echo cs_html_form(0);
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

echo cs_getmsg();

$tables = 'links ln INNER JOIN {pre}_categories cat ON ln.categories_id = cat.categories_id';
$cells  = 'ln.links_name AS links_name, ln.links_url AS links_url, ln.links_stats AS links_stats, ';
$cells .= 'ln.links_id AS links_id, ln.categories_id AS categories_id, ';
$cells .= 'cat.categories_name AS categories_name';

$where = empty($categories_id) ? 0 : 'ln.categories_id = \''.$categories_id.'\'';

$cs_links = cs_sql_select(__FILE__,$tables,$cells,$where,$order,$start,$account['users_limit']);
$links_loop = count($cs_links);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo cs_sort('links','manage',$start,0,1,$sort);
echo $cs_lang['name'];
echo cs_html_roco(2,'headb');
echo $cs_lang['cat'];
echo cs_html_roco(3,'headb');
echo $cs_lang['url'];
echo cs_html_roco(4,'headb');
echo $cs_lang['stat'];
echo cs_html_roco(5,'headb',0,2);
echo $cs_lang['options'];
echo cs_html_roco(0);

$img_edit = cs_icon('edit',16,$cs_lang['edit']);
$img_del = cs_icon('editdelete',16,$cs_lang['remove']);
$secure_on = cs_secure($cs_lang['online'],1);
$secure_off = cs_secure($cs_lang['offline'],1);

for($run=0; $run<$links_loop; $run++) {

	echo cs_html_roco(1,'leftc');
	echo cs_secure($cs_links[$run]['links_name']);
	echo cs_html_roco(2,'leftc');
	echo cs_secure($cs_links[$run]['categories_name']);
	echo cs_html_roco(3,'leftc');
	echo cs_secure( '[url=http://'.$cs_links[$run]['links_url'].']'.substr($cs_links[$run]['links_url'], 0, 20).'[/url]',1);
	echo cs_html_roco(4,'leftc');
	if ($cs_links[$run]['links_stats'] == 'on')
    echo $secure_on;
  else
    echo $secure_off;
	echo cs_html_roco(5,'leftc');
	echo cs_link($img_edit,'links','edit','id=' . $cs_links[$run]['links_id'],0,$cs_lang['edit']);
  echo cs_html_roco(6,'leftc');
  echo cs_link($img_del,'links','remove','id=' . $cs_links[$run]['links_id'],0,$cs_lang['remove']);
	echo cs_html_roco(0);
}

echo cs_html_table(0);

?>
