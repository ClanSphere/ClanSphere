<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('contact');

$data = array('trash' => array());
$data['status']['msg'] = '';

if(isset($_POST['submit'])) {
  $domain = empty($_POST['blocklist_entry']) ? '' : trim($_POST['blocklist_entry']);
  $exists = cs_sql_count(__FILE__, 'trashmail', 'trashmail_entry = \'' . cs_sql_escape($domain) . '\'');
  if(!empty($domain) AND empty($exists)) {
    $trashmail_cells = array('trashmail_entry');
    $trashmail_save = array($domain);
    cs_sql_insert(__FILE__, 'trashmail', $trashmail_cells,$trashmail_save);
    $data['status']['msg'] = cs_icon('submit') . ' ' . $cs_lang['blocklist_success'];
  }
  else
    $data['status']['msg'] = cs_icon('error') . ' ' . $cs_lang['blocklist_exists'];
}
elseif(!empty($_GET['delete'])) {
  cs_sql_delete(__FILE__, 'trashmail', (int) $_GET['delete']);
  $data['status']['msg'] = cs_icon('submit') . ' ' . $cs_lang['blocklist_delete'];
}

$data['if']['status'] = empty($data['status']['msg']) ? 0 : 1;

$start = empty($_GET['start']) ? 0 : (int) $_GET['start'];
$cs_sort[1] = 'trashmail_entry DESC';
$cs_sort[2] = 'trashmail_entry ASC';
$sort = empty($_GET['sort']) ? 2 : (int) $_GET['sort'];
$order = $cs_sort[$sort];
$trash_count = cs_sql_count(__FILE__, 'trashmail');
$select = 'trashmail_id, trashmail_entry';
$cs_trash = cs_sql_select(__FILE__, 'trashmail', $select, 0, $order, $start, $account['users_limit']);
$trash_loop = count($cs_trash);

$data['head']['pages']  = cs_pages('contact','blocklist',$trash_count,$start,0,$sort);
$data['head']['sort_name'] = cs_sort('contact','blocklist',$start,0,1,$sort);

$data['head']['message'] = cs_getmsg();

for($run=0; $run<$trash_loop; $run++)
{
  $data['trash'][$run]['trashmail_id'] = $cs_trash[$run]['trashmail_id'];
  $data['trash'][$run]['trashmail_entry'] = cs_secure($cs_trash[$run]['trashmail_entry']);
}

echo cs_subtemplate(__FILE__,$data,'contact','blocklist');