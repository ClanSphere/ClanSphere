<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('database');

$sql_content = '';
$modules = cs_checkdirs('mods');
$tables = 0;

foreach($modules as $mod) {

  if((isset($account['access_' . $mod['dir'] . '']) OR $mod['dir'] == 'captcha' OR $mod['dir'] == 'pictures') AND !empty($mod['tables'][0])) {
    foreach($mod['tables'] AS $table) {
      $tables++;
      $sql_content .= '{optimize} {pre}_' . $table . ";\n";
    }
  }
}
$sql_content = substr($sql_content,0,-1);

$data['action']['form'] = cs_url('database','import');

$matches[1] = $tables;
$matches[2] = '<textarea name="text" cols="50" rows="12" id="text">' . $sql_content . '</textarea>';
$data['optimize']['clip'] = cs_abcode_clip($matches);

echo cs_subtemplate(__FILE__,$data,'database','optimize');