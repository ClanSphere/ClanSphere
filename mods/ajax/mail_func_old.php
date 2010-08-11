<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_ajax_mail($mail, $link = '', $service = 'mailto:')
{
  global $cs_main;
  $mail_lnk = empty($link) ? str_replace(array('@', '.'), array(' (at) ', ' (dot) '), $mail) : $link;
  $mail_bin = $mail; # only difference between mail_func files
  $mail_str = base64_encode($mail_bin);

  return '<a href="#" onclick="$.get(\'' . $cs_main['php_self']['dirname'] . 'mods/ajax/mail.php?mail='
       . $mail_str . '\', function(r) { window.location = \'' . $service . '\' + r; })">' . $mail_lnk . '</a>';       
}