<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_mail_prepare ($email, $title, $message, $from, $type, $options) {

  global $cs_main;
  $mail = array();

  # mail content
  $nl = "\n";

  $subject = $options['def_org'] . ' - ' . $title;
  $type = empty($type) ? 'text/plain' : $type;

  if($type == 'text/plain') {
    # add mail signature if available
    static $signature = '';
    if(empty($signature) AND file_exists('uploads/imprint/mailsig.txt'))
      $signature = $nl . $nl . file_get_contents('uploads/imprint/mailsig.txt');
    $message .= $signature;

    $subject = html_entity_decode($subject, ENT_NOQUOTES, $cs_main['charset']);
    $message = html_entity_decode($message, ENT_NOQUOTES, $cs_main['charset']);
  }

  $mail['subject'] = '=?' . $cs_main['charset'] . '?B?' . base64_encode($subject) . '?=';
  $mail['message'] = chunk_split(base64_encode($message));
  $mail['from'] = empty($from) ? $options['def_mail'] : $from;
  $mail['to'] = $email;

  $mail['headers'] = "From: " . $mail['from'] . $nl;
  $mail['headers'] .= "Return-Path: " . $mail['from'] . $nl;
  $mail['headers'] .= "Reply-To: " . $mail['from'] . $nl;
  $mail['headers'] .= "Content-Type: " . $type . "; charset=" . $cs_main['charset'] . $nl;
  $mail['headers'] .= "Content-Transfer-Encoding: base64" . $nl;
  $mail['headers'] .= "MIME-Version: 1.0" . $nl;
  $mail['headers'] .= "X-Mailer: ClanSphere" . $nl;

  return $mail;
}

function cs_mail_send ($mail) {

  @ini_set('sendmail_from', $mail['from']);
  $result = mail($mail['to'], $mail['subject'], $mail['message'], $mail['headers']) ? true : false;
  return $result;
}

function cs_mail_smtp ($mail, $options) {

  # mail content
  $nl = "\n";
  # smtp following rfc 821
  $nl_con = "\r\n";

  $timeout = 10;
  $smtp_con = fsockopen($options['smtp_host'], $options['smtp_port'], $errno, $errstr, $timeout);

  if(!empty($errno)) {
      cs_error(__FILE__, 'cs_mail_smtp - ' . $errno . ' - ' . $errstr);
      return false;
  }
  else {

    $host = empty($_SERVER['SERVER_ADDR']) ? $_SERVER['LOCAL_ADDR'] : $_SERVER['SERVER_ADDR'];

    $mail_top =  $mail['headers'] . "To: " . $mail['to'] . $nl . "Subject: " . $mail['subject'];
    $mail_data = $mail_top . $nl . $nl . $mail['message'] . $nl_con . ".";

    $mail_com = array('helo' => 'HELO ' . $host,
                      'login' => 'AUTH LOGIN',
                      'user' => base64_encode($options['smtp_user']),
                      'pw' => base64_encode($options['smtp_pw']),
                      'from' => 'MAIL FROM:' . $mail['from'],
                      'to' => 'RCPT TO:' . $mail['to'],
                      'data' => 'DATA',
                      'response' => $mail_data,
                      'quit' => 'QUIT');

    stream_set_timeout($smtp_con, $timeout);

    global $cs_logs;
    if(empty($cs_logs['sql'][__FILE__]))
      $cs_logs['sql'][__FILE__] = '';
    static $num = 0;
    $num++;
    $log = 'MAIL ' . $num . "\n";
    $log .= 'connect: ' . fread($smtp_con, 2048);
    $cs_logs['sql'][__FILE__] .= $log;

    foreach($mail_com AS $com_info => $command) {

      fwrite($smtp_con, $command . $nl_con);
      $read = fread($smtp_con, 2048);
      $code = (int) substr($read, 0, 3);
      $cs_logs['sql'][__FILE__] .=  $com_info . ': ' . $read;

      if($code >= 400) {
        cs_error($com_info, 'cs_mail_smtp - Bad status code: ' . substr($read, 0, -2));
        return false;
      }
    }

    return true;
  }
}