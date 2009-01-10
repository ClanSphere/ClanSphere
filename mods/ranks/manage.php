<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('ranks');

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'ranks_name DESC';
$cs_sort[2] = 'ranks_name ASC';
$sort = empty($_REQUEST['sort']) ? 2 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$ranks_count = cs_sql_count(__FILE__,'ranks');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,3);
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_manage'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo cs_icon('editpaste') . cs_link($cs_lang['new_rank'],'ranks','create');
echo cs_html_roco(2,'leftb');
echo cs_icon('contents') . $cs_lang['total'] . ': ' . $ranks_count;
echo cs_html_roco(2,'rightb');
echo cs_pages('ranks','manage',$ranks_count,$start,0,$sort);
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

echo cs_getmsg();

$select = 'ranks_id, ranks_name';
$cs_ranks = cs_sql_select(__FILE__,'ranks',$select,0,$order,$start,$account['users_limit']);
$ranks_loop = count($cs_ranks);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo cs_sort('ranks','manage',$start,0,1,$sort);
echo $cs_lang['name'];
echo cs_html_roco(2,'headb',0,2);
echo $cs_lang['options'];
echo cs_html_roco(0);

for($run=0; $run<$ranks_loop; $run++) {

	echo cs_html_roco(1,'leftc');
  echo cs_secure($cs_ranks[$run]['ranks_name']);
	echo cs_html_roco(2,'leftc');
  $img_edit = cs_icon('edit',16,$cs_lang['edit']);
	echo cs_link($img_edit,'ranks','edit','id=' . $cs_ranks[$run]['ranks_id'],0,$cs_lang['edit']);
  echo cs_html_roco(3,'leftc');
	$img_del = cs_icon('editdelete',16,$cs_lang['remove']);
  echo cs_link($img_del,'ranks','remove','id=' . $cs_ranks[$run]['ranks_id'],0,$cs_lang['remove']);
	echo cs_html_roco(0);
}
echo cs_html_table(0);

?>
