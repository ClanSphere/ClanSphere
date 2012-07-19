<?php
// ClanSphere 2010 - www.clansphere.net 
// $Id$

$cs_lang = cs_translate('messages');

$data = array();
$messages_id = (int) $_GET['id'];

$outbox = (empty($_GET['outbox']) AND empty($_POST['outbox'])) ? 'inbox' : 'outbox';

if (isset($_GET['confirm'])) {

  $query = $outbox == 'inbox' ? 
    'DELETE FROM {pre}_messages WHERE users_id_to = \''.$account['users_id'].'\' AND (' :
    'UPDATE {pre}_messages SET messages_show_sender = \'0\' WHERE users_id = \''.$account['users_id'].'\' AND (';

  $values = explode('-',$_GET['ids']);
  $count_values = count($values);

  for ($run = 0; $run < $count_values; $run++) {
    $id = (int) $values[$run];
    if ($run != 0)
      $query .= ' OR ';
    $query .= 'messages_id = \'' . $id . '\'';
  }
  $query .= ')';

  cs_sql_query(__FILE__,$query);

  cs_redirect($cs_lang['del_true'],'messages',$outbox);
} 
elseif (isset($_GET['cancel'])) {
  cs_redirect($cs_lang['del_false'],'messages',$outbox);
}
else {

  $values = $_POST;
  $ids = '';
  foreach ($values AS $key => $value) {
    if (strpos($key,'select_') === false)
      continue;
    $ids .= substr($key,7) . '-';
  }

  if (empty($ids)) {
    cs_redirect($cs_lang['no_selection'],'messages',$outbox);
  }
  else {
    $ids = substr($ids,0,-1);
    $addout = $outbox == 'outbox' ? '&amp;outbox=outbox' : '';

    $data['content']['head'] = $cs_lang['really_remove_selected'];
    $data['content']['bottom']  = cs_link($cs_lang['confirm'],'messages','multiremove','ids='.$ids.'&amp;confirm' . $addout);
    $data['content']['bottom'] .= ' - ';
    $data['content']['bottom'] .= cs_link($cs_lang['cancel'],'messages','multiremove','cancel' . $addout);
  }
}

echo cs_subtemplate(__FILE__,$data,'messages','multiremove');