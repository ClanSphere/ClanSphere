<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

function cs_mail_prepare ($email, $title, $message, $from, $type, $options) {

  global $cs_main;
  $nl = "\n";
  $mail = array();

  $subject = $options['def_org'] . ' - ' . $title;
  $type = empty($type) ? 'text/plain' : $type;

  if($type == 'text/plain') {
    $subject = html_entity_decode($subject, ENT_NOQUOTES, $cs_main['charset']);
    $message = html_entity_decode($message, ENT_NOQUOTES, $cs_main['charset']);
  }

  $mail['subject'] = '=?' . $cs_main['charset'] . '?B?' . base64_encode($subject) . '?=';
  $mail['message'] = chunk_split(base64_encode($message));
  $mail['from'] = empty($from) ? $options['def_mail'] : $from;
  $mail['to'] = $email;

  $mail['headers'] = "MIME-Version: 1.0" . $nl;
  $mail['headers'] .= "Content-Type: " . $type . "; charset=" . $cs_main['charset'] . $nl;
  $mail['headers'] .= "Content-Transfer-Encoding: base64" . $nl;
  $mail['headers'] .= "X-Mailer: ClanSphere" . $nl;

  return $mail;
}

function cs_mail_send ($mail) {

  @ini_set('sendmail_from', $mail['from']);
  $result = mail($mail['to'], $mail['subject'], $mail['message'], $mail['headers']) ? true : false;
  return $result;
}

function cs_mail_smtp ($mail, $options) {

  $timeout = 10;
  $smtp_con = fsockopen($options['smtp_host'], $options['smtp_port'], $errno, $errstr, $timeout);

  if(!empty($errno)) {
      cs_error(__FILE__, 'cs_mail_smtp - ' . $errno . ' - ' . $errstr);
      return false;
  }
  else {
    $nl = "\n";
    $mail_data = "To: " . $mail['to'] . "\nFrom: " . $mail['from'] . "\nSubject: ";
    $mail_data .= $mail['subject'] . "\n" . $mail['headers'] . "\n\n" . $mail['message'] . "\n.";
    stream_set_timeout($smtp_con, $timeout);

    $log = 'response: ' . fread($smtp_con, 2048);
    fwrite($smtp_con, 'AUTH LOGIN' . $nl);
    $log .= 'login: ' . fread($smtp_con, 2048);
    fwrite($smtp_con, base64_encode($options['smtp_user']) . $nl);
    $log .= 'user: ' . fread($smtp_con, 2048);
    fwrite($smtp_con, base64_encode($options['smtp_pw']) . $nl);
    $log .= 'pw: ' . fread($smtp_con, 2048);
    fwrite($smtp_con, 'HELO ' . $_SERVER['SERVER_ADDR'] . $nl);
    $log .= 'helo: ' . fread($smtp_con, 2048);
    fwrite($smtp_con, 'MAIL FROM: ' . $mail['from'] . $nl);
    $log .= 'from: ' . fread($smtp_con, 2048);
    fwrite($smtp_con, 'RCPT TO:' . $mail['to'] . $nl);
    $log .= 'to: ' . fread($smtp_con, 2048);
    fwrite($smtp_con, 'DATA' . $nl);
    $log .= 'data: ' . fread($smtp_con, 2048);
    fwrite($smtp_con, $mail_data . $nl);
    $log .= 'headers: ' . fread($smtp_con, 2048);
    fwrite($smtp_con, 'QUIT' . $nl);
    $log .= 'quit: ' . fread($smtp_con, 2048);

    global $cs_logs;
    static $num = 0;
    $num++;
    $log = 'MAIL ' . $num . "\n" . $log;
    $cs_logs['sql'][__FILE__] = isset($cs_logs['sql'][__FILE__]) ? $cs_logs['sql'][__FILE__] . $log : $log;

    return true;
  }
}