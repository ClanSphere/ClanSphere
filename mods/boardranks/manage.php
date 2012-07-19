<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('boardranks');
$cs_post = cs_post('start,sort');
$cs_get = cs_get('start,sort');
$data = array();

$start = empty($cs_get['start']) ? 0 : $cs_get['start'];
if (!empty($cs_post['start']))  $start = $cs_post['start'];
$sort = empty($cs_get['sort']) ? 2 : $cs_get['sort'];
if (!empty($cs_post['sort']))  $sort = $cs_post['sort'];

$cs_sort[1] = 'boardranks_min DESC';
$cs_sort[2] = 'boardranks_min ASC';
$cs_sort[3] = 'boardranks_name DESC';
$cs_sort[4] = 'boardranks_name ASC';
$order = $cs_sort[$sort];
$boardranks_count = cs_sql_count(__FILE__,'boardranks');

$data['head']['count'] = $boardranks_count;
$data['head']['pages'] = cs_pages('boardranks','manage',$boardranks_count,$start,0,$sort);
$data['head']['getmsg'] = cs_getmsg();

$data['sort']['boardranks_min'] = cs_sort('boardranks','manage',$start,0,1,$sort);
$data['sort']['boardranks_name'] = cs_sort('boardranks','manage',$start,0,3,$sort);

$select = 'boardranks_id, boardranks_min, boardranks_name';
$cs_boardranks = cs_sql_select(__FILE__,'boardranks',$select,0,$order,$start,$account['users_limit']);
$boardranks_loop = count($cs_boardranks);


for($run=0; $run<$boardranks_loop; $run++) {

  $id = $cs_boardranks[$run]['boardranks_id'];

  $data['bora'][$run]['boardranks_min'] =  cs_secure($cs_boardranks[$run]['boardranks_min']);
  $data['bora'][$run]['boardranks_name'] =  cs_secure($cs_boardranks[$run]['boardranks_name']);

  $data['bora'][$run]['url_edit'] = cs_url('boardranks','edit','id=' . $id);
    $data['bora'][$run]['url_remove'] = cs_url('boardranks','remove','id=' . $id);

}

echo cs_subtemplate(__FILE__,$data,'boardranks','manage');
