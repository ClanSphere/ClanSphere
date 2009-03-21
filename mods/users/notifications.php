<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');

$data = array();
$data['lang'] = $cs_lang;

$notify_methods = array(  0 => 'no_notification',
                          1 => 'email_notification',
                          2 => 'pm_notification' );


if (isset($_POST['submit'])) {

  // Data => DB
  array_walk($_POST['data'], 'cs_int_walk');
  cs_sql_update(__FILE__, 'notifications', array_keys($_POST['data']), array_values($_POST['data']), 0, 'users_id = ' . $account['users_id']);
  
  // Redirect Output
  $data['link']['continue'] = cs_url('users', 'notifications');
  $data['lang']['head'] = $cs_lang['notifications'];
  
  // Output
  echo cs_subtemplate(__FILE__, $data, 'users', 'done');
  
} else {  

  // Get & Set notifications when necessary
  $db_data = cs_sql_select(__FILE__, 'notifications', '*', $account['users_id']);
  if ($data==NULL) {
    cs_sql_insert(__FILE__,'notifications', array('users_id'), array($account['users_id']));
    $db_data = cs_sql_select(__FILE__, 'notifications', '*', $account['users_id']);
  }
  
  $x=0; 
  foreach($db_data AS $key => $item)
  {
    if( $key == 'notifications_id' OR $key == 'users_id' )
      continue;

    // Get the translation for the notification
    $data['notifications'][$x]['lang'] = $cs_lang[$key];

    // Build dynamic notification dropdowns
    $data['notifications'][$x]['notify_methods'] = cs_html_select(1,"data[$key]");
    foreach( $notify_methods AS $nkey => $nitem )
      $data['notifications'][$x]['notify_methods'] .= cs_html_option($cs_lang[$nitem],$nkey,( ($nkey==$item) ? 'selected="selected"' : '' ) );    
    $data['notifications'][$x]['notify_methods'] .= cs_html_select(0);

    $x++;
  }
  
  // Output
  echo cs_subtemplate(__FILE__, $data, 'users', 'notifications');
}
?>