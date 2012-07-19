<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');

if(isset($_POST['submit'])) {
  
  $save['cols'] = (int) $_POST['cols'];
  $save['rows'] = (int) $_POST['rows'];
  $save['thumbs'] = (int) $_POST['thumbs'];
  $save['quality'] = (int) $_POST['quality'];
  $save['width'] = (int) $_POST['width'];
  $save['height'] = (int) $_POST['height'];
  $save['size'] = (int) $_POST['size'] * 1024;
  $save['max_width'] = (int) $_POST['max_width'];
  $save['top_5_votes'] = (int) $_POST['top_5_votes'];
  $save['top_5_views'] = (int) $_POST['top_5_views'];
  $save['newest_5'] = (int) $_POST['newest_5'];
  $save['list_sort'] = (int) $_POST['list_sort'];
  $save['size2'] = (int) $_POST['size2'] * 1024;
  $save['max_files'] = (int) $_POST['max_files'];
  $save['max_folders'] = (int) $_POST['max_folders'];
  $save['lightbox'] = (int) $_POST['lightbox'];
  $save['max_navlist'] = (int) $_POST['max_navlist'];
  
  require_once 'mods/clansphere/func_options.php';
  
  cs_optionsave('gallery', $save);

  cs_redirect($cs_lang['changes_done'], 'options', 'roots');

} else {

  $data = array();

  $data['op'] = cs_sql_option(__FILE__,'gallery');
  
  $data['op']['size'] = $data['op']['size'] / 1024;
  $data['op']['size2'] = $data['op']['size2'] / 1024;
  
  $checked = 'checked="checked"';
  $data['check']['top_5_votes_0'] = empty($data['op']['top_5_votes']) ? $checked : '';
  $data['check']['top_5_votes_1'] = !empty($data['op']['top_5_votes']) ? $checked : '';
  $data['check']['top_5_views_0'] = empty($data['op']['top_5_views']) ? $checked : '';
  $data['check']['top_5_views_1'] = !empty($data['op']['top_5_views']) ? $checked : '';
  $data['check']['newest_5_0'] = empty($data['op']['newest_5']) ? $checked : '';
  $data['check']['newest_5_1'] = !empty($data['op']['newest_5']) ? $checked : '';


  $levels = 0;
  $var2 = '';
  while($levels < 2) {
    $data['op']['list_sort'] == $levels ? $sel = 1 : $sel = 0;
    $var2 .= cs_html_option($cs_lang['sort_' . $levels],$levels,$sel);
    $levels++;
  }
  $data['sort']['options'] = $var2;
 
  $levels = 0;
  $var = '';
  while($levels < 2) {
    $data['op']['lightbox'] == $levels ? $sel = 1 : $sel = 0;
    $var .= cs_html_option($cs_lang['light_' . $levels],$levels,$sel);
    $levels++;
  }
  $data['lightbox']['options'] = $var;

  echo cs_subtemplate(__FILE__,$data,'gallery','options');
}