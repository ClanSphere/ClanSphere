<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('modules');

if (!empty($_POST['submit'])) {

  $error = '';

  if (empty($_POST['modname']))
    $error .= cs_html_br(1) . $cs_lang['no_name'];
  if (empty($_POST['moddir']))
    $error .= cs_html_br(1) . $cs_lang['no_dir'];
  if (empty($_POST['modversion']))
    $error .= cs_html_br(1) . $cs_lang['no_version'];
  if (empty($_POST['creator']))
    $error .= cs_html_br(1) . $cs_lang['no_creator'];
  if (empty($_POST['team']))
    $error .= cs_html_br(1) . $cs_lang['no_team'];
  if (empty($_POST['homepage']))
    $error .= cs_html_br(1) . $cs_lang['no_homepage'];
  if (empty($_POST['description']))
    $error .= cs_html_br(1) . $cs_lang['no_description'];
  if (empty($_POST['icon']))
    $error .= cs_html_br(1) . $cs_lang['no_icon'];
  elseif (!file_exists('symbols/'.$cs_main['img_path'].'/16/'.$_POST['icon'].'.'.$cs_main['img_ext']))
    $error .= cs_html_br(1) . $cs_lang['icon_not_found'];

  if (empty($error)) {

    // Show
    $show = 'array(';
    for ($run = 0; $run < $_POST['showcount']; $run++) {
      if (!empty($_POST['show_'.$run]))
        $show .= '\''.$_POST['show_'.$run].'\' => '.$_POST['showaccess_'.$run];
      if ($run + 1 != $_POST['showcount'])
        $show .= ', ';
    }
    $show .= ')';

    // Tables
    $tables = 'array(';
    for ($run = 0; $run < $_POST['tablescount']; $run++) {
      if (!empty($_POST['table_'.$run]))
        $tables .= '\''.$_POST['table_'.$run].'\'';
      if ($run + 1 != $_POST['tablescount'])
        $tables .= ', ';
    }
    $tables .= ')';

    $categories = empty($_POST['categories']) ? 'FALSE' : 'TRUE';
    $protected = empty($_POST['protected']) ? 'FALSE' : 'TRUE';

    // info.php

    $infocontent  = '<?php'."\r\n";
    $infocontent .= '// ClanSphere 2010 - www.clansphere.net'."\r\n";
    $infocontent .= '// File created by mod modules'."\r\n\r\n";

    $infocontent .= '$cs_lang = cs_translate(\''.$_POST['moddir'].'\');'."\r\n\r\n";

    $infocontent .= '$mod_info[\'name\'] = $cs_lang[\'mod\']'.";\r\n";
    $infocontent .= '$mod_info[\'version\'] = \''.$_POST['modversion']."';\r\n";
    $infocontent .= '$mod_info[\'released\'] = \''.cs_datepost('release','date')."';\r\n";
    $infocontent .= '$mod_info[\'creator\'] = \''.$_POST['creator']."';\r\n";
    $infocontent .= '$mod_info[\'team\'] = \''.$_POST['team']."';\r\n";
    $infocontent .= '$mod_info[\'url\'] = \''.$_POST['homepage']."';\r\n";
    $infocontent .= '$mod_info[\'text\'] = $cs_lang[\'mod_info\'];'."\r\n";
    $infocontent .= '$mod_info[\'icon\'] = \''.$_POST['icon']."';\r\n";
    $infocontent .= '$mod_info[\'show\'] = '.$show.";\r\n";
    $infocontent .= '$mod_info[\'categories\'] = '.$categories.";\r\n";
    $infocontent .= '$mod_info[\'protected\'] = '.$protected.";\r\n";
    $infocontent .= '$mod_info[\'tables\'] = '.$tables.";\r\n\r\n";

    $infocontent .= '?>';

    $moddir = $cs_main['def_path'].'/mods/'.$_POST['moddir'];

    if (!mkdir($moddir,0777))
      $error .= cs_html_br(1) . $cs_lang['moddir_create_failed'];
    elseif (!$infofile = fopen($moddir.'/info.php','w'))
      $error .= cs_html_br(1) . $cs_lang['modinfo_create_failed'];
    elseif (!fwrite($infofile, $infocontent))
      $error .= cs_html_br(1) . $cs_lang['modinfo_write_failed'];
    else
      fclose($infofile);

    // Lang file

    $langinfocontent  = '<?php'."\r\n";
    $langinfocontent .= '// ClanSphere 2010 - www.clansphere.net'."\r\n";
    $langinfocontent .= '// File created by mod modules'."\r\n\r\n";

    $langinfocontent .= '$cs_lang[\'mod\'] = \''.$_POST['modname']."';\r\n";
    $langinfocontent .= '$cs_lang[\'mod_info\'] = \''.$_POST['description']."';\r\n\r\n";

    $langinfocontent .= '?>';

    if (!$langinfofile = fopen($cs_main['def_path'].'/lang/'.$account['users_lang'].'/'.$_POST['moddir'].'.php','w'))
      $error .= cs_html_br(1) . $cs_lang['modinfolang_create_failed'];
    elseif (!fwrite($langinfofile, $langinfocontent))
      $error .= cs_html_br(1) . $cs_lang['modinfolang_write_failed']; 
    else
      fclose($langinfofile);

    // SQL
    $query = 'ALTER TABLE {pre}_access ADD access_'.cs_sql_escape($_POST['moddir']).' int(2) NOT NULL default \'0\';';
    $query = cs_sql_replace($query);
    if (!cs_sql_query(__FILE__,$query)) {
      $error .= cs_html_br(1) . $cs_lang['sqlaccess_failed'];
    }
  }
}

if (empty($_POST['submit']) || !empty($error)) {
  $data['message']['lang'] = empty($error) ? nl2br($cs_lang['need_chmod']) : $cs_lang['error_occured'] . $error;

  // SQL Tables
  $_POST['tablescount'] = empty($_POST['tablescount']) ? 1 : (int) $_POST['tablescount'];
  $tablescount = empty($_POST['addtable']) ? $_POST['tablescount'] : $_POST['tablescount'] + 1;
  for ($run = 0; $run < $tablescount; $run++) {
    $data['tables'][$run]['run'] = $run;
    $data['tables'][$run]['value'] = empty($_POST['table_'.$run]) ? '' : $_POST['table_'.$run];
  }
  $data['value']['tablescount'] = $tablescount;

  // Show
  $_POST['showcount'] = empty($_POST['showcount']) ? 1 : (int) $_POST['showcount'];
  $showcount = empty($_POST['addshow']) ? $_POST['showcount'] : $_POST['showcount'] + 1;
  for ($run = 0; $run < $showcount; $run++) {
    $data['show'][$run]['run'] = $run;
    $data['show'][$run]['value'] = empty($_POST['show_'.$run]) ? '' : $_POST['show_'.$run];
    $data['show'][$run]['axx_value'] = empty($_POST['showaccess_'.$run]) ? '' : $_POST['showaccess_'.$run];
  }
  $data['value']['showcount'] = $showcount;

  $data['value']['modname'] = empty($_POST['modname']) ? '' : $_POST['modname'];
  $data['value']['moddir'] = empty($_POST['moddir']) ? '' : $_POST['moddir'];
  $data['value']['modversion'] = empty($_POST['modversion']) ? '' : $_POST['modversion'];
  $data['value']['description'] = empty($_POST['description']) ? '' : $_POST['description'];
  $var = cs_datepost('release','date');
  $data['value']['dateselect'] = empty($var) ? cs_datereal('Y-m-d') : $var;
  $data['value']['creator'] = empty($_POST['creator']) ? '' : $_POST['creator'];
  $data['value']['team'] = empty($_POST['team']) ? '' : $_POST['team'];
  $data['value']['homepage'] = empty($_POST['homepage']) ? '' : $_POST['homepage'];
  $data['value']['icon'] = empty($_POST['icon']) ? '' : $_POST['icon'];

  $clip[1] = $cs_lang['help'];
  $clip[2] = $cs_lang['helptext'];
  $data['help']['clip'] = cs_abcode_clip($clip);

  $sel = 'selected="selected"';

  $data['selected']['categories_no'] = empty($_POST['categories']) ? $sel : '';
  $data['selected']['categories_yes'] = empty($_POST['categories']) ? '' : $sel;

  $data['selected']['protected_no'] = empty($_POST['protected']) ? $sel : '';
  $data['selected']['protected_yes'] = empty($_POST['protected']) ? '' : $sel;

  $data['form']['url'] = cs_url('modules','create');
  $data['input']['dateselect'] = cs_dateselect('release','date',$data['value']['dateselect']);

  echo cs_subtemplate(__FILE__,$data,'modules','create');
}
else {
  cs_cache_clear();

  cs_redirect($cs_lang['create_done'],'modules','roots');
}