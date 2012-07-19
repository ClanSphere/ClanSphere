<?php

$cs_lang = cs_translate('clansphere');

function pasteError($err){
  $cs_err[1] = 'ERROR....';
  $cs_err[2] = $err;
    
  echo cs_abcode_clip($cs_err);
}

include_once('mods/clansphere/func.php');

//Total
if(!$space_total = disk_total_space($cs_main['def_path'])) {
  pasteError($cs_lang['err']);
  return;
}

//Free
$tmpvar = get_disk_free_space();
if (is_array($tmpvar)){
  $cs_err = $tmpvar;
}
else{
  $space_free = $tmpvar;
}

//Modul
$tmpvar = get_directorysize('/mods');
if(is_array($tmpvar)){
  $cs_err = $tmpvar;
}
else{
  $space_mods = $tmpvar;
}

//Upload
$tmpvar = get_directorysize('/uploads');
if(is_array($tmpvar)){
  $cs_err = $tmpvar;
}
else{
  $space_up = $tmpvar;
}

//Symbols
$tmpvar = get_directorysize('/symbols');
if(is_array($tmpvar)){
  $cs_err = $tmpvar;
}
else{
  $space_sym = $tmpvar;
}

//Templates
$tmpvar = get_directorysize('/templates');
if(is_array($tmpvar)){
  $cs_err = $tmpvar;
}
else{
  $space_temp = $tmpvar;
}

if(empty($space_total) or empty($space_free)) {
  $space_used = 0;
}
else {
  $space_used = $space_total - $space_free;
}
  
$perc_used = 0;
$perc_free = 0;
$perc_mods = 0;
$perc_up = 0;
$perc_sym = 0;
$perc_temp = 0;
$perc_all = 0;

if(!empty($space_total)) {        
  $perc_used = empty($space_used) ? 0 : round($space_used * 100 / $space_total);
  $perc_free = empty($space_free) ? 0 : round($space_free * 100 / $space_total);
  $perc_mods = empty($space_mods) ? 0 : round($space_mods * 100 / $space_total);
  $perc_up = empty($space_up) ? 0 : round($space_up * 100 / $space_total);
  $perc_sym = empty($space_sym) ? 0 : round($space_sym * 100 / $space_total);
  $perc_temp = empty($space_temp) ? 0 : round($space_temp * 100 / $space_total);
  $perc_all = $perc_used + $perc_free;
}

if(!empty($cs_err) && $cs_err[1] != '') {
  $data['lang']['body'] = cs_abcode_clip($cs_err);
}
else {
  $data['lang']['body'] = $cs_lang['body_storage'];
}

$data['storage']['space_total'] = cs_filesize($space_total);
$data['storage']['space_total_percent'] = $perc_all . ' %';
$data['storage']['space_free'] = cs_filesize($space_free);
$data['storage']['space_free_percent'] = $perc_free . ' %';
$data['storage']['space_used'] = cs_filesize($space_used);
$data['storage']['space_used_percent'] = $perc_used . ' %';
$data['storage']['space_mods'] = cs_filesize($space_mods);
$data['storage']['space_mods_percent'] = $perc_mods . ' %';
$data['storage']['space_sym'] = cs_filesize($space_sym);
$data['storage']['space_sym_percent'] = $perc_sym . ' %';
$data['storage']['space_up'] = cs_filesize($space_up);
$data['storage']['space_up_percent'] = $perc_up . ' %';
$data['storage']['space_temp'] = cs_filesize($space_temp);
$data['storage']['space_temp_percent'] = $perc_temp . ' %';

echo cs_subtemplate(__FILE__,$data,'clansphere','storage');