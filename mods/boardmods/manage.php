<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('boardmods');

$categories_id = empty($_REQUEST['where']) ? 0 : $_REQUEST['where'];
settype($categories_id,'integer');
$where = empty($categories_id) ? 0 : 'categories_id = ' . cs_sql_escape($categories_id);

empty($_REQUEST['start']) ? $start = 0 : $start = $_REQUEST['start']; 
$cs_sort[1] = 'users_nick DESC';
$cs_sort[2] = 'users_nick ASC';
$sort = empty($_REQUEST['sort']) ? 2 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$boardmods_count = cs_sql_count(__FILE__,'boardmods',$where);

$data['head']['count'] = $boardmods_count;
$data['head']['pages'] = cs_pages('boardmods','manage',$boardmods_count,$start,$categories_id,$sort);

$categories_data = cs_sql_select(__FILE__,'categories','*',"categories_mod = 'boardmods'",'categories_name',0,0);
$data['head']['cat_dropdown'] = cs_dropdown('where','categories_name',$categories_data,$categories_id,'categories_id');

$data['head']['getmsg'] = cs_getmsg();

$data['sort']['users_nick'] = cs_sort('boardmods','manage',$start,$categories_id,1,$sort);

$from = 'boardmods brd INNER JOIN {pre}_users usr ON brd.users_id = usr.users_id'; 
$data['bm'] = cs_sql_select(__FILE__,$from,'boardmods_id, usr.users_id AS users_id, users_nick, users_active, users_delete, boardmods_modpanel, boardmods_edit, boardmods_del',$where,$order,$start,$account['users_limit']);
$boardmods_loop = count($data['bm']);

for($run=0; $run<$boardmods_loop; $run++) {

  $data['bm'][$run]['boardmods_user'] = cs_user($data['bm'][$run]['users_id'],$data['bm'][$run]['users_nick'],$data['bm'][$run]['users_active'], $data['bm'][$run]['users_delete']);
  $data['bm'][$run]['boardmods_modpanel'] = empty($data['bm'][$run]['boardmods_modpanel']) ? $cs_lang['no'] : $cs_lang['yes'];
  $data['bm'][$run]['boardmods_edit'] = empty($data['bm'][$run]['boardmods_edit']) ? $cs_lang['no'] : $cs_lang['yes'];
  $data['bm'][$run]['boardmods_del'] = empty($data['bm'][$run]['boardmods_del']) ? $cs_lang['no'] : $cs_lang['yes'];
  
  $data['bm'][$run]['url_edit'] = cs_url('boardmods','edit','id=' . $data['bm'][$run]['boardmods_id'],0,$cs_lang['edit']);
    $data['bm'][$run]['url_remove'] = cs_url('boardmods','remove','id=' . $data['bm'][$run]['boardmods_id'],0,$cs_lang['remove']);
}

echo cs_subtemplate(__FILE__,$data,'boardmods','manage');