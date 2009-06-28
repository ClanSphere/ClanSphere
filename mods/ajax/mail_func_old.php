<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

function cs_ajax_mail($mail, $link = '', $service = 'mailto:')
{
	global $cs_main;
  $email = explode("@", $mail);
  $domain = empty($email[1]) ? array(0,1) : explode(".", $email[1]);
  $link = empty($link) ? $email[0] . ' (at) ' . $domain[0] . ' (dot) ' . $domain[1] : $link;
  $str = base64_encode($mail);

  return '<a href="#" onclick="cs_ajax_request(\''. $cs_main['php_self']['dirname']
       . 'mods/ajax/mail.php?mail=' . $str . '\',function(http_request){window.location=\''
       . $service . '\'+http_request.responseText;})">' . $link . '</a>';
}