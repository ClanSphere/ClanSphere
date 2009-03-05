<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanshop');
$cs_post = cs_post('where,start,sort');
$cs_get = cs_get('where,start,sort');
$data = array();

$categories_id = empty($cs_get['where']) ? 0 : $cs_get['where'];
if (!empty($cs_post['where']))  $categories_id = $cs_post['where'];
$start = empty($cs_get['start']) ? 0 : $cs_get['start'];
if (!empty($cs_post['start']))  $start = $cs_post['start'];
$sort = empty($cs_get['sort']) ? 2 : $cs_get['sort'];
if (!empty($cs_post['sort']))  $sort = $cs_post['sort'];

$where = empty($categories_id) ? 0 : "categories_id = '" . $categories_id . "'";

$cs_sort[1] = 'lanshop_articles_name DESC';
$cs_sort[2] = 'lanshop_articles_name ASC';
$cs_sort[3] = 'lanshop_articles_price DESC';
$cs_sort[4] = 'lanshop_articles_price ASC';
$order = $cs_sort[$sort];
$lanshop_count = cs_sql_count(__FILE__,'lanshop_articles',$where);


$data['head']['count'] = $lanshop_count;
$data['head']['pages'] = cs_pages('lanshop','manage',$lanshop_count,$start,$categories_id,$sort);

$lanshopmod = "categories_mod='lanshop'";
$categories_data = cs_sql_select(__FILE__,'categories','*',$lanshopmod,'categories_name',0,0);
$data['head']['cat_dropdown'] = cs_dropdown('where','categories_name',$categories_data,$categories_id,'categories_id');
$data['head']['getmsg'] = cs_getmsg();

$data['sort']['name'] = cs_sort('lanshop','manage',$start,$categories_id,1,$sort);
$data['sort']['price'] = cs_sort('lanshop','manage',$start,$categories_id,3,$sort);

$select = 'lanshop_articles_name, lanshop_articles_price, lanshop_articles_id';
$data['articles'] = cs_sql_select(__FILE__,'lanshop_articles',$select,$where,$order,$start,$account['users_limit']);
$lanshop_loop = count($data['articles']);


for($run=0; $run<$lanshop_loop; $run++) {

	$data['articles'][$run]['id'] = $data['articles'][$run]['lanshop_articles_id'];
	$data['articles'][$run]['name'] = cs_secure($data['articles'][$run]['lanshop_articles_name']);
	$data['articles'][$run]['price'] = $data['articles'][$run]['lanshop_articles_price'] / 100 . ' ' . $cs_lang['cost'];

}

echo cs_subtemplate(__FILE__,$data,'lanshop','manage');

?>
