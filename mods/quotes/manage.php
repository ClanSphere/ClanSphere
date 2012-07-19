<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('quotes');

$categories_id = empty($_REQUEST['where']) ? 0 : $_REQUEST['where'];
settype($categories_id,'integer');
$where = empty($categories_id) ? 0 : "categories_id = '" . $categories_id . "'";

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'quotes_headline DESC';
$cs_sort[2] = 'quotes_headline ASC';
$cs_sort[3] = 'quotes_time DESC';
$cs_sort[4] = 'quotes_time ASC';
$sort = empty($_REQUEST['sort']) ? 3 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$quotes_count = cs_sql_count(__FILE__,'quotes',$where);

$data = array();

$data['url']['form'] = cs_url('quotes','manage');

$data['lang']['all'] = $cs_lang['total'].': ';
$data['head']['count'] = $quotes_count;
$data['head']['pages'] = cs_pages('quotes','manage',$quotes_count,$start,$categories_id,$sort);

$data['head']['message'] = cs_getmsg();

$quotesmod = "categories_mod = 'quotes'";
$categories_data = cs_sql_select(__FILE__,'categories','*',$quotesmod,'categories_name',0,0);
$data['head']['dropdown'] = cs_dropdown('where','categories_name',$categories_data,$categories_id,'categories_id');

$from = 'quotes qts LEFT JOIN {pre}_users usr ON qts.users_id = usr.users_id';
$select = 'qts.quotes_headline AS quotes_headline, qts.users_id AS users_id, usr.users_nick AS users_nick, usr.users_active AS users_active, usr.users_delete AS users_delete, qts.quotes_time AS quotes_time, qts.quotes_id AS quotes_id';

$cs_quotes = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);
$quotes_loop = count($cs_quotes);

$data['sort']['quotes_headline'] = cs_sort('quotes','manage',$start,$categories_id,1,$sort);
$data['sort']['quotes_time'] = cs_sort('quotes','manage',$start,$categories_id,3,$sort);

for($run=0; $run<$quotes_loop; $run++) {

  $cs_quotes[$run]['quotes_headline'] = cs_secure($cs_quotes[$run]['quotes_headline']);
  $cs_quotes[$run]['url_edit'] = cs_url('quotes','edit','id='.$cs_quotes[$run]['quotes_id']);
  $cs_quotes[$run]['url_remove'] = cs_url('quotes','remove','id='.$cs_quotes[$run]['quotes_id']);
  $cs_quotes[$run]['url_user'] = cs_user($cs_quotes[$run]['users_id'],$cs_quotes[$run]['users_nick'],$cs_quotes[$run]['users_active'],$cs_quotes[$run]['users_delete']);
  $cs_quotes[$run]['url_quote'] = cs_url('quotes','view','id=' . $cs_quotes[$run]['quotes_id']);
  $cs_quotes[$run]['quotes_time'] = cs_date('unix',$cs_quotes[$run]['quotes_time'],1);
  
}

$data['quotes'] = $cs_quotes;

echo cs_subtemplate(__FILE__,$data,'quotes','manage');
