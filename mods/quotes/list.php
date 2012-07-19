<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('quotes');

$cat_id = empty($_GET['where']) ? 0 : (int) $_GET['where'];
$where = empty($cat_id) ? '' : 'cat.categories_id = "' . $cat_id . '"';

$start = empty($_GET['start']) ? 0 : (int) $_GET['start'];
$cs_sort[1] = 'quotes_time DESC';
$cs_sort[2] = 'quotes_time ASC';
$cs_sort[3] = 'quotes_headline DESC';
$cs_sort[4] = 'quotes_headline ASC';
$sort = empty($_GET['sort']) ? 1 : (int) $_GET['sort'];
$order = $cs_sort[$sort];


$join = 'quotes qts INNER JOIN {pre}_categories cat ON qts.categories_id = cat.categories_id';
$data['head']['count'] = cs_sql_count(__FILE__,$join,$where,'quotes_id');
$data['head']['pages'] = cs_pages('quotes','list',$data['head']['count'],$start,$cat_id,$sort);
$quotesmod = "categories_mod = 'quotes' AND categories_access <= '" . $account['access_quotes'] . "'";
$categories_data = cs_sql_select(__FILE__,'categories','*',$quotesmod,'categories_name',0,0);
$data['head']['dropdown'] = cs_dropdown('where','categories_name',$categories_data,$cat_id,'categories_id');

$data['sort']['quotes_time'] = cs_sort('quotes','list',$start,$cat_id,1,$sort);
$data['sort']['quotes_headline'] = cs_sort('quotes','list',$start,$cat_id,3,$sort);

$select = 'qts.quotes_headline AS quotes_headline, qts.quotes_time AS quotes_time, qts.quotes_id AS quotes_id';
$cs_quotes = cs_sql_select(__FILE__,$join,$select,$where,$order,$start,$account['users_limit']);
$quotes_loop = count($cs_quotes);


for($run=0; $run<$quotes_loop; $run++) {

  $cs_quotes[$run]['quotes_time'] = cs_date('unix',$cs_quotes[$run]['quotes_time'],1);
  $sec_head = cs_secure($cs_quotes[$run]['quotes_headline']);
  $cs_quotes[$run]['quotes_headline'] = cs_link($sec_head,'quotes','view','id=' . $cs_quotes[$run]['quotes_id']);
}

$data['quotes'] = $cs_quotes;
echo cs_subtemplate(__FILE__,$data,'quotes','list');