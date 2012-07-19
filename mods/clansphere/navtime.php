<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clansphere');

$timezone = $account['users_timezone'] / 3600;
$zonename = $timezone >= 0 ? 'UTC +' . $timezone : 'UTC ' . $timezone;
$dst = '';

if(empty($account['users_dstime']) AND date('I',cs_time()) != '0' OR $account['users_dstime'] == 'on') {
  $dst = ' [' . $cs_lang['dstime'] . ']';
}

echo cs_date('unix',cs_time(),1) . ' ' . $cs_lang['using'] . ' ' . $zonename . $dst;