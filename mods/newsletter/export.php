<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('newsletter');

include_once 'mods/newsletter/functions.php';

$data = array();
$cs_nl = array();

$cs_nl['newsletter_to'] = '';
$cs_nl['users_id'] = $account['users_id'];

if(isset($_POST['submit'])) {

  $cs_nl['newsletter_to'] = $_POST['newsletter_to'];
  
  $error = '';

  if(empty($cs_nl['newsletter_to']))
    $error .= $cs_lang['no_to'] . cs_html_br(1);
}

if(!isset($_POST['submit'])) {
  $data['head']['body'] = $cs_lang['body_export'];
}
elseif(!empty($error)) {
  $data['head']['body'] = $error;
}

if(!empty($error) OR !isset($_POST['submit'])) {

  $data['nl'] = $cs_nl;

  $data['nl']['to_dropdown'] = cs_newsletter_to($cs_nl['newsletter_to']);

 echo cs_subtemplate(__FILE__,$data,'newsletter','export');

}
else {

  $mail_targets = cs_newsletter_emails($cs_nl['newsletter_to']);

  # disable browser / proxy caching
  header("Cache-Control: max-age=0, no-cache, no-store, must-revalidate");
  header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

  header("Content-Description: File Transfer");
  header("Content-Type: text/plain");
  header("Content-Disposition: attachment; filename=newsletter_export.ldif;");
  header("Content-Transfer-Encoding: binary");

  $ldif = '';
  if (!empty($mail_targets)) {
    foreach($mail_targets AS $target) {
      $ldif .= 'dn: mail=' . $target['email'] . "\n"
             . 'objectclass: top' . "\n"
             . 'objectclass: person' . "\n"
             . 'mail: ' . $target['email'] . "\n\n";
    }
  }
  die($ldif);
}