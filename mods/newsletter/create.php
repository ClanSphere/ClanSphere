<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('newsletter');

include_once 'mods/newsletter/functions.php';

$data = array();
$cs_nl = array();

$cs_nl['newsletter_subject'] = '';
$cs_nl['newsletter_to'] = '';
$cs_nl['newsletter_text'] = '';
$cs_nl['newsletter_time'] = cs_time();
$cs_nl['users_id'] = $account['users_id'];

if(isset($_POST['submit'])) {

  $cs_nl['newsletter_subject'] = $_POST['newsletter_subject'];
  $cs_nl['newsletter_to'] = $_POST['newsletter_to'];
  $cs_nl['newsletter_text'] = $_POST['newsletter_text'];
  
  $error = '';

  if(empty($cs_nl['newsletter_subject']))
    $error .= $cs_lang['no_subject'] . cs_html_br(1);
  if(empty($cs_nl['newsletter_to']))
    $error .= $cs_lang['no_to'] . cs_html_br(1);
  if(empty($cs_nl['newsletter_text']))
    $error .= $cs_lang['no_text'] . cs_html_br(1);
}

if(!isset($_POST['submit'])) {
  $data['head']['body'] = $cs_lang['require'];
}
elseif(!empty($error)) {
  $data['head']['body'] = $error;
}

if(!empty($error) OR !isset($_POST['submit'])) {

  $data['nl'] = $cs_nl;

  $data['nl']['to_dropdown'] = cs_newsletter_to($cs_nl['newsletter_to']);

 echo cs_subtemplate(__FILE__,$data,'newsletter','create');

}
else {

  $mail_targets = cs_newsletter_emails($cs_nl['newsletter_to']);

  $count_mails = 0;
  if (!empty($mail_targets)) {
    foreach($mail_targets as $value) {
      cs_mail($value['email'],$cs_nl['newsletter_subject'],$cs_nl['newsletter_text']);
      $count_mails++;
    }
  }
  $cells = array_keys($cs_nl);
  $values = array_values($cs_nl);
  cs_sql_insert(__FILE__,'newsletter',$cells,$values);
  
  cs_redirect(sprintf($cs_lang['successfull'],$count_mails),'newsletter');
}