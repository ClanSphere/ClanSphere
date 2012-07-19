<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clansphere');

global $com_lang, $cs_logs;

ksort($com_lang);
ksort($cs_main);
ksort($cs_logs);
ksort($account);

$com_run = 0;
$main_run = 0;
$log_run = 0;
$account_run = 0;

foreach($com_lang AS $key => $value) {
  $data['com'][$com_run]['var'] = 'com_lang["' . $key . '"]';
  $data['com'][$com_run]['value'] = $value;
  $com_run++;
}

foreach($cs_main AS $key => $value) {
  $data['main'][$main_run]['var'] = 'cs_main["' . $key . '"]';
  $data['main'][$main_run]['value'] = !is_array($value) ? htmlspecialchars($value) : implode("<br />", $value);
  $main_run++;
}

foreach($cs_logs AS $key => $value) {
  $data['log'][$log_run]['var'] = 'cs_logs["' . $key . '"]';
  $value = !is_array($value) ? htmlspecialchars($value) : htmlspecialchars(implode('', $value));
  $value = nl2br($value);
  $data['log'][$log_run]['value'] = $value;
  $log_run++;
}

foreach($account AS $key => $value) {
  $data['account'][$account_run]['var'] = 'account["' . $key . '"]';
  $data['account'][$account_run]['value'] = $value;
  $account_run++;
}

echo cs_subtemplate(__FILE__,$data,'clansphere','variables');