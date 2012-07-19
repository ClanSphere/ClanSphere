<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('partner');
$data['partner'] = array();
$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'partner_priority DESC';
$cs_sort[2] = 'partner_priority ASC';
$cs_sort[3] = 'partner_name DESC';
$cs_sort[4] = 'partner_name ASC';
$cs_sort[5] = 'categories_name DESC, partner_priority ASC';
$cs_sort[6] = 'categories_name ASC, partner_priority ASC';
$sort = empty($_REQUEST['sort']) ? 1 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$partner_count = cs_sql_count(__FILE__,'partner');
  
$data['head']['total'] = $partner_count;
$data['head']['pages'] = cs_pages('partner','manage',$partner_count,$start,0,$sort);
  
$data['head']['message'] = cs_getmsg();  
  
$data['sort']['priority'] = cs_sort('partner','manage',$start,0,1,$sort);
$data['sort']['name'] = cs_sort('partner','manage',$start,0,3,$sort);
$data['sort']['category'] = cs_sort('partner','manage',$start,0,5,$sort);

$select = 'prt.partner_id AS partner_id, prt.partner_name AS partner_name, prt.partner_priority AS partner_priority, cat.categories_name AS categories_name';
$from = 'partner prt INNER JOIN {pre}_categories cat ON prt.categories_id = cat.categories_id ';
$cs_partner = cs_sql_select(__FILE__,$from,$select,0,$order,$start,$account['users_limit']);
$partner_loop = count($cs_partner);
  
for($run=0; $run<$partner_loop; $run++) {
    
  $data['partner'][$run]['name'] = cs_secure($cs_partner[$run]['partner_name']);
  $data['partner'][$run]['categories_name'] = cs_secure($cs_partner[$run]['categories_name']);
  $data['partner'][$run]['priority'] = cs_secure($cs_partner[$run]['partner_priority']);
  $data['partner'][$run]['url_delete'] = cs_url('partner','remove','id='.$cs_partner[$run]['partner_id']);
  $data['partner'][$run]['url_edit'] = cs_url('partner','edit','id='.$cs_partner[$run]['partner_id']);
    
  }
  
echo cs_subtemplate(__FILE__,$data,'partner','manage');