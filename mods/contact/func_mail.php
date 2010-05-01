<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

function cs_mail_prepare ($email, $title, $message, $from, $type, $options) {

  global $cs_main;
  $nl = "\r\n";
  $mail = array();

  $subject = $options['def_org'] . ' - ' . $title;
  $type = empty($type) ? 'text/plain' : $type;

  if($type == 'text/plain') {
    $subject = html_entity_decode($subject, ENT_NOQUOTES, $cs_main['charset']);
    $message = html_entity_decode($message, ENT_NOQUOTES, $cs_main['charset']);
  }

  $mail['subject'] = '=?' . $cs_main['charset'] . '?B?' . base64_encode($subject) . '?=';
  $mail['message'] = $message;
  $mail['from'] = empty($from) ? $options['def_mail'] : $from;
  $mail['to'] = $email;

  $mail['headers'] = "Reply-To: " . $mail['from'] . $nl;
  $mail['headers'] .= "Content-type: " . $type . "; charset=" . $cs_main['charset'] . $nl;
  $mail['headers'] .= "MIME-Version: 1.0" . $nl;
  $mail['headers'] .= "X-Mailer: PHP/" . phpversion() . $nl;

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
    $nl = "\r\n";
    $mail_data = "To: " . $mail['to'] . "\nFrom: " . $mail['from'] . "\nSubject: ";
    $mail_data .= $mail['subject'] . "\n" . $mail['headers'] . "\n\n" . $mail['message'] . "\n.\n";
    stream_set_timeout($smtp_con, $timeout);

    $log = 'response: ' . fgets($smtp_con);
    fwrite($smtp_con, 'AUTH LOGIN' . $nl);
    $log .= 'login: ' . fgets($smtp_con);
    fwrite($smtp_con, base64_encode($options['smtp_user']) . $nl);
    $log .= 'user: ' . fgets($smtp_con);
    fwrite($smtp_con, base64_encode($options['smtp_pw']) . $nl);
    $log .= 'pw: ' . fgets($smtp_con);
    fwrite($smtp_con, 'HELO ' . $_SERVER['SERVER_ADDR'] . $nl);
    $log .= 'helo: ' . fgets($smtp_con);
    fwrite($smtp_con, 'MAIL FROM: ' . $mail['from'] . $nl);
    $log .= 'from: ' . fgets($smtp_con);
    fwrite($smtp_con, 'RCPT TO:' . $mail['to'] . $nl);
    $log .= 'to: ' . fgets($smtp_con);
    fwrite($smtp_con, 'DATA' . $nl);
    $log .= 'data: ' . fgets($smtp_con);
    fwrite($smtp_con, $mail_data . $nl);
    $log .= 'headers: ' . fgets($smtp_con);
    fwrite($smtp_con, 'QUIT' . $nl);
    $log .= 'quit: ' . fgets($smtp_con);

    global $cs_logs;
    static $num = 0;
    $num++;
    $log = 'MAIL ' . $num . "\n" . $log;
    $cs_logs['sql'][__FILE__] = isset($cs_logs['sql'][__FILE__]) ? $cs_logs['sql'][__FILE__] . $log : $log;

    return true;
  }
}