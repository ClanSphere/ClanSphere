<?php
// ClanSphere 2008 - www.clansphere.net 
// $Id$

$cs_lang = cs_translate('messages');

$data = array();
$messages_id = (int) $_GET['id'];

if (isset($_GET['confirm'])) {
  
  $query = !isset($_GET['outbox']) ? 
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
echo $query;
  #cs_redirect($cs_lang['del_true'],'messages','inbox');
  
} elseif (isset($_GET['cancel'])) {
  $action = !isset($_GET['outbox']) ? 'inbox' : 'outbox';
  cs_redirect($cs_lang['del_false'],'messages',$action);
  
} else {
  
  $values = $_POST;
  $ids = '';
  foreach ($values AS $key => $value) {
    if (strpos($key,'select_') === false)
      continue;
    $ids .= substr($key,7) . '-';
  }

  if (empty($ids)) {

  cs_redirect($cs_lang['no_selection'],'messages','inbox');
    
  } else {
    
    $ids = substr($ids,0,-1);
    
    $outbox = empty($_POST['outbox']) ? '' : '&amp;outbox';
    
    $data['content']['head'] = $cs_lang['really_remove_selected'];
    $data['content']['bottom']  = cs_link($cs_lang['confirm'],'messages','multiremove','ids='.$ids.'&amp;confirm' . $outbox);
    $data['content']['bottom'] .= ' - ';
    $data['content']['bottom'] .= cs_link($cs_lang['cancel'],'messages','multiremove','cancel' . $outbox);
    
  }
}

echo cs_subtemplate(__FILE__,$data,'shoutbox','remove');

?>