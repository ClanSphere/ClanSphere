<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('faq');

empty($_REQUEST['start']) ? $start = 0 : $start = $_REQUEST['start']; 
$cs_sort[1] = 'faq_question DESC';
$cs_sort[2] = 'faq_question ASC';
$cs_sort[3] = 'categories_id DESC';
$cs_sort[4] = 'categories_id ASC';
$sort = empty($_REQUEST['sort']) ? 4 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$faq_count = cs_sql_count(__FILE__,'faq');

$data['lang']['count'] = $faq_count;
$data['pages']['list'] = cs_pages('faq','manage',$faq_count,$start,0,$sort);

$data['lang']['getmsg'] = cs_getmsg();

$cs_faq = cs_sql_select(__FILE__,'faq','*',0,$order,$start,$account['users_limit']);
$faq_loop = count($cs_faq);
$data['sort']['question'] = cs_sort('faq','manage',$start,0,1,$sort);
$data['sort']['category'] = cs_sort('faq','manage',$start,0,3,$sort);

if(empty($faq_loop)) {
$data['faq'] = '';
}

for($run=0; $run<$faq_loop; $run++) {
  $data['faq'][$run]['question'] = cs_secure($cs_faq[$run]['faq_question']);

  $cs_faq_user = cs_sql_select(__FILE__,'users','users_nick, users_active, users_delete',"users_id = '" . $cs_faq[$run]['users_id'] . "'");

  $data['faq'][$run]['user'] = cs_user($cs_faq[$run]['users_id'],$cs_faq_user['users_nick'], $cs_faq_user['users_active'], $cs_faq_user['users_delete']);

  $cs_faq_categories = cs_sql_select(__FILE__,'categories','*',"categories_id = '" . $cs_faq[$run]['categories_id'] . "'");

  $data['faq'][$run]['cat'] = cs_secure($cs_faq_categories['categories_name']);

  $img_edit = cs_icon('edit');
  $data['faq'][$run]['edit'] = cs_link($img_edit,'faq','edit','id=' . $cs_faq[$run]['faq_id'],0,$cs_lang['edit']);
  $img_del = cs_icon('editdelete');
  $data['faq'][$run]['remove'] = cs_link($img_del,'faq','remove','id=' . $cs_faq[$run]['faq_id'],0,$cs_lang['remove']);
}

echo cs_subtemplate(__FILE__,$data,'faq','manage');