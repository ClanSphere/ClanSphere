<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('explorer');

include_once 'mods/explorer/functions.php';

$target = empty($_REQUEST['file']) ? '' : $_REQUEST['file'];
$dir = cs_explorer_path($target, 'raw');
$lsd = cs_explorer_path($dir, 'escape');
$red_lsd = cs_explorer_path($dir, 'escape', 1);

$data = array();

if(empty($_POST['submit'])) {

  if(empty($dir)) {

    cs_redirect($cs_lang['no_selection'],'explorer','roots','dir=' . $red_lsd);

  } else {

    $chmod = substr(sprintf('%o', fileperms($dir)), -3);

    $data['var']['source'] = $dir;
    $data['var']['chmod'] = $chmod;
    $data['icn']['unknown'] = cs_html_img('symbols/files/filetypes/unknown.gif', 16, 16);

    $check = ' checked="checked"';
    $temp = $chmod;

    $rights = array();
    $rights['o_r'] = 400; $rights['o_w'] = 200; $rights['o_e'] = 100;
    $rights['g_r'] =  40; $rights['g_w'] =  20; $rights['g_e'] =  10;
    $rights['p_r'] =   4; $rights['p_w'] =   2; $rights['p_e'] =   1;
 
    foreach ($rights AS $name => $min) {
      if ($temp >= $min) {
        $temp -= $min;
        $data['check'][$name] = $check;
      } else
        $data['check'][$name] = '';
    }

    echo cs_subtemplate(__FILE__, $data, 'explorer', 'chmod');
  }
} else {

  $chmod = (int) $_POST['chmod'];

  $count = strlen($chmod);
  $missing = 4 - $count;
  $new_chmod = '';

  for($x = 0; $x < $missing; $x++)
    $new_chmod .= '0';

  $new_chmod .= $chmod;
  $new_chmod = octdec($new_chmod);

  @chmod($dir, $new_chmod);

  $fileperms = octdec(substr(sprintf('%o', fileperms($dir)), -4));
  $message = $new_chmod == $fileperms ? $cs_lang['success'] : $cs_lang['error_chmod'];

  cs_redirect($message, 'explorer','roots','dir=' . $red_lsd);
}