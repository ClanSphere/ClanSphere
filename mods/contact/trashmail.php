<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_trashmail($email) {

  $parts = explode('@', $email, 2);
  if(empty($parts[1]))
    return false;
  else {
    $where = "trashmail_entry = '" . strtolower(cs_sql_escape($parts[1])) . "'";
    $check = cs_sql_count(__FILE__, 'trashmail', $where);
    return (empty($check)) ? false : true;
  }
}