<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('joinus');

if(isset($_POST['submit'])) {

  $save = array();
  $save['vorname']     = (int) $_POST['vorname'];
  $save['surname']     = (int) $_POST['surname'];
  $save['place']      = (int) $_POST['place'];
  $save['country']    = (int) $_POST['country'];
  $save['icq']       = (int) $_POST['icq'];
  $save['jabber']       = (int) $_POST['jabber'];
  $save['game']       = (int) $_POST['game'];
  $save['squad']       = (int) $_POST['squad'];
  $save['webcon']     = (int) $_POST['webcon'];
  $save['lanact']     = (int) $_POST['lanact'];
  $save['more']       = (int) $_POST['more'];
  $save['max_usershome']   = (int) $_POST['max_usershome'];

  require_once 'mods/clansphere/func_options.php';
  cs_optionsave('joinus', $save);
  cs_redirect($cs_lang['success'], 'options', 'roots');
}

$data = array();
$data['op'] = cs_sql_option(__FILE__,'joinus');

$data['op']['vorname'] = empty($data['op']['vorname']) ? $data['op']['vorname_no'] = 'checked="checked"' : $data['op']['vorname_yes'] = 'checked="checked"';
$data['op']['surname'] = empty($data['op']['surname']) ? $data['op']['surname_no'] = 'checked="checked"' : $data['op']['surname_yes'] = 'checked="checked"';
$data['op']['place'] = empty($data['op']['place']) ? $data['op']['place_no'] = 'checked="checked"' : $data['op']['place_yes'] = 'checked="checked"';
$data['op']['country'] = empty($data['op']['country']) ? $data['op']['country_no'] = 'checked="checked"' : $data['op']['country_yes'] = 'checked="checked"';
$data['op']['icq'] = empty($data['op']['icq']) ? $data['op']['icq_no'] = 'checked="checked"' : $data['op']['icq_yes'] = 'checked="checked"';
$data['op']['jabber'] = empty($data['op']['jabber']) ? $data['op']['jabber_no'] = 'checked="checked"' : $data['op']['jabber_yes'] = 'checked="checked"';
$data['op']['game'] = empty($data['op']['game']) ? $data['op']['game_no'] = 'checked="checked"' : $data['op']['game_yes'] = 'checked="checked"';
$data['op']['squad'] = empty($data['op']['squad']) ? $data['op']['squad_no'] = 'checked="checked"' : $data['op']['squad_yes'] = 'checked="checked"';
$data['op']['webcon'] = empty($data['op']['webcon']) ? $data['op']['webcon_no'] = 'checked="checked"' : $data['op']['webcon_yes'] = 'checked="checked"';
$data['op']['lanact'] = empty($data['op']['lanact']) ? $data['op']['lanact_no'] = 'checked="checked"' : $data['op']['lanact_yes'] = 'checked="checked"';
$data['op']['more'] = empty($data['op']['more']) ? $data['op']['more_no'] = 'checked="checked"' : $data['op']['more_yes'] = 'checked="checked"';

echo cs_subtemplate(__FILE__,$data,'joinus','options');