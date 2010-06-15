<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('comments');
$cs_post = cs_post('start,sort');
$cs_get = cs_get('start,sort');
$data = array();

$start = empty($cs_get['start']) ? 0 : $cs_get['start'];
if (!empty($cs_post['start']))  $start = $cs_post['start'];
$sort = empty($cs_get['sort']) ? 5 : $cs_get['sort'];
if (!empty($cs_post['sort']))  $sort = $cs_post['sort'];

$where = empty($_REQUEST['where']) ? 'news' : $_REQUEST['where'];
$cs_sort[1] = 'comments_id DESC';
$cs_sort[2] = 'comments_id ASC';
$cs_sort[3] = 'users_id DESC';
$cs_sort[4] = 'users_id ASC';
$cs_sort[5] = 'comments_time DESC';
$cs_sort[6] = 'comments_time ASC';
$order = $cs_sort[$sort];

$mdp = "comments_mod = '" . cs_sql_escape($where) . "'";
$comments_count = cs_sql_count(__FILE__,'comments',$mdp);

$data['head']['count'] = $comments_count;
$data['head']['pages'] = cs_pages('comments','manage',$comments_count,$start,$where,$sort);


$data['head']['mod_dropdown'] = cs_html_select(1,'where');
$check_sel = empty($where) ? $issel = 0 : $issel = 1;
$data['head']['mod_dropdown'] .= cs_html_option('----',0,0,$issel);
$modules = cs_checkdirs('mods');
foreach($modules as $mods) {
  if(!empty($mods['comments'])) {
  if(!empty($where)) {
    $mods['dir'] == $where ? $sel = 1 : $sel = 0;
  } else { $sel = 0; }
    $data['head']['mod_dropdown'] .=  cs_html_option($mods['name'],$mods['dir'],$sel);
  }
}
$data['head']['mod_dropdown'] .= cs_html_select(0);

$data['head']['getmsg'] = cs_getmsg();

$data['sort']['comments_id'] = cs_sort('comments','manage',$start,$where,1,$sort);
$data['sort']['users_id'] = cs_sort('comments','manage',$start,$where,3,$sort);
$data['sort']['comments_time'] = cs_sort('comments','manage',$start,$where,5,$sort);

$com_where = $mdp . " AND comments_mod != 'board'";
$select = 'comments_id, users_id, comments_time, comments_fid, comments_mod, comments_guestnick';
$data['com'] = cs_sql_select(__FILE__,'comments',$select,$com_where,$order,$start,$account['users_limit']);
$com_loop = count($data['com']);

for($run=0; $run<$com_loop; $run++) {
  
   $id = $data['com'][$run]['comments_id'];
  $data['com'][$run]['fid'] = $data['com'][$run]['comments_fid'];
  if(!empty($data['com'][$run]['users_id'])) {
    $cs_user = cs_sql_select(__FILE__,'users','users_nick, users_active, users_delete',"users_id = '" . $data['com'][$run]['users_id'] . "'");
    $data['com'][$run]['user'] = cs_user($data['com'][$run]['users_id'],$cs_user['users_nick'],$cs_user['users_active'], $cs_user['users_delete']);
  } else {
    $data['com'][$run]['user'] = $data['com'][$run]['comments_guestnick'];
  }

  $data['com'][$run]['date'] = cs_date('unix',$data['com'][$run]['comments_time'],1);
  
  $data['com'][$run]['url_view'] = cs_url('comments','view','id=' . $id);
  $data['com'][$run]['url_edit'] = cs_url('comments','edit','id=' . $id);
  $data['com'][$run]['url_remove'] = cs_url('comments','remove','id=' . $id);

}

echo cs_subtemplate(__FILE__,$data,'comments','manage');