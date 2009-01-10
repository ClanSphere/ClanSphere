<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('linkus');

empty($_REQUEST['start']) ? $start = 0 : $start = $_REQUEST['start'];
$cs_sort[1] = 'linkus_name DESC';
$cs_sort[2] = 'linkus_name ASC';  
$cs_sort[3] = 'linkus_banner DESC';
$cs_sort[4] = 'linkus_banner ASC';
empty($_REQUEST['sort']) ? $sort = 2 : $sort = $_REQUEST['sort'];
$order = $cs_sort[$sort];
$linkus_count = cs_sql_count(__FILE__,'linkus');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,3);
echo $cs_lang['mod'] . ' - ' . $cs_lang['head'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo cs_icon('editpaste') . cs_link($cs_lang['new_banner'],'linkus','create');
echo cs_html_roco(2,'leftb');
echo cs_icon('contents') . $cs_lang['all'] . $linkus_count;
echo cs_html_roco(2,'rightb');
echo cs_pages('linkus','manage',$linkus_count,$start,0,$sort);
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

echo cs_getmsg();

$cs_linkus = cs_sql_select(__FILE__,'linkus','*',0,$order,$start,$account['users_limit']);
$linkus_loop = count($cs_linkus);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo cs_sort('linkus','manage',$start,0,1,$sort);
echo $cs_lang['name'];
echo cs_html_roco(2,'headb');
echo cs_sort('linkus','manage',$start,0,3,$sort);
echo $cs_lang['banner'];
echo cs_html_roco(2,'headb');
echo $cs_lang['mass'];
echo cs_html_roco(4,'headb',0,2);
echo $cs_lang['options'];
echo cs_html_roco(0);

for($run=0; $run<$linkus_loop; $run++) {

	echo cs_html_roco(1,'leftc');
	echo cs_secure($cs_linkus[$run]['linkus_name']);
	echo cs_html_roco(2,'leftc');
        echo cs_secure($cs_linkus[$run]['linkus_banner']);
        echo cs_html_roco(3,'leftc');
        $place = 'uploads/linkus/' .$cs_linkus[$run]['linkus_banner'];
        $mass = getimagesize($place);
        echo cs_secure($mass[0] .' x '. $mass[1]);
	echo cs_html_roco(4,'leftc');
        $img_edit = cs_icon('edit');
	echo cs_link($img_edit,'linkus','edit','id=' . $cs_linkus[$run]['linkus_id'],0,$cs_lang['edit']);
        echo cs_html_roco(5,'leftc');
	$img_del = cs_icon('editdelete');
        echo cs_link($img_del,'linkus','remove','id=' . $cs_linkus[$run]['linkus_id'],0,$cs_lang['remove']);
	echo cs_html_roco(0);
}

echo cs_html_table(0);

?>
