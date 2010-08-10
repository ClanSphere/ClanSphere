<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_ajax_mail($mail, $link = '', $service = 'mailto:')
{
  global $cs_main;
  $email = explode("@", $mail);
  $domain = empty($email[1]) ? array(0,1) : explode(".", $email[1]);
  $link = empty($link) ? $email[0] . ' (at) ' . $domain[0] . ' (dot) ' . $domain[1] : $link;
  $mail = $mail; # only difference between mail_func files
  $str = base64_encode($mail);

  return '<a href="#" onclick="$.get(\'' . $cs_main['php_self']['dirname'] . 'mods/ajax/mail.php?mail='
       . $str . '\', function(r) { window.location = \'' . $service . '\' + r; })">' . $link . '</a>';       
}