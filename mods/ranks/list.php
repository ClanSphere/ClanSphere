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
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_list'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo sprintf($cs_lang['all'],$ranks_count);
echo cs_html_roco(2,'rightb');
echo cs_pages('ranks','list',$ranks_count,$start,0,$sort);
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

$select = 'ranks_id, ranks_name, ranks_url, ranks_img, ranks_code';
$cs_ranks = cs_sql_select(__FILE__,'ranks',$select,0,$order,$start,$account['users_limit']);
$ranks_loop = count($cs_ranks);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo cs_sort('ranks','list',$start,0,1,$sort);
echo $cs_lang['name'];
echo cs_html_roco(2,'headb');
echo $cs_lang['content'];
echo cs_html_roco(0);

for($run=0; $run<$ranks_loop; $run++) {

	echo cs_html_roco(1,'leftc');
  echo cs_secure($cs_ranks[$run]['ranks_name']);
	echo cs_html_roco(2,'leftc');
  if(!empty($cs_ranks[$run]['ranks_url']) AND !empty($cs_ranks[$run]['ranks_url'])) {
    $picture = cs_html_img($cs_ranks[$run]['ranks_img']);
	  echo cs_html_link('http://' . $cs_ranks[$run]['ranks_url'],$picture);
  }
  else {
    echo $cs_ranks[$run]['ranks_code'];
  }
	echo cs_html_roco(0);
}
echo cs_html_table(0);

?>
