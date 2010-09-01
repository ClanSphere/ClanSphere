<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_trashmail($eMail) {

  $tMail = cs_sql_select(__FILE__,'trashmail','trashmail_entry',0,0,0,0);
  for($i=0; $i<count($tMail); $i++) {
    if(stristr($eMail, $tMail[$i]['trashmail_entry']) !== FALSE) {
      return true;
    }
  }
  return false;
}