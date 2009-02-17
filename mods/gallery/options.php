<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');

$cs_gallery = cs_sql_option(__FILE__,'gallery');
$gallery_form = 1;
echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['options'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo $cs_lang['body_opt'];
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);
echo cs_getmsg();

if(isset($_POST['submit']))
{
  $gallery_form = 0;
  $opt_where = 'options_mod=\'gallery\' AND options_name=';
  $def_cell = array('options_value');
  $def_cont = array($_POST['cols']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . '\'cols\'');
  $def_cont = array($_POST['rows']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . '\'rows\'');
  #$def_cont = array($_POST['xpics']);
  #cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . '\'xpics\'');
  $def_cont = array($_POST['thumbs']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . '\'thumbs\'');
  $def_cont = array($_POST['quality']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . '\'quality\'');
  $def_cont = array($_POST['width']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . '\'width\'');
  $def_cont = array($_POST['height']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . '\'height\'');
  $def_cont = array($_POST['size'] * 1024);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . '\'size\'');
  $def_cont = array($_POST['max_width']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . '\'max_width\'');
  $def_cont = array($_POST['top_5_votes']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . '\'top_5_votes\'');
  $def_cont = array($_POST['top_5_views']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . '\'top_5_views\'');
  $def_cont = array($_POST['newest_5']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . '\'newest_5\'');
  $def_cont = array($_POST['list_sort']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . '\'list_sort\'');
  $def_cont = array($_POST['size2'] * 1024);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . '\'size2\'');
  $def_cont = array($_POST['max_files']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . '\'max_files\'');
  $def_cont = array($_POST['max_folders']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . '\'max_folders\'');
  $def_cont = array($_POST['lightbox']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . '\'lightbox\'');

  cs_redirect($cs_lang['changes_done'],'gallery','options');
}

if(!empty($gallery_form))
{
  echo cs_html_form (1,'gallery_edit','gallery','options');
  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'headb',0,2);
  echo $cs_lang['mod'];
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('insert_table_row');
  echo $cs_lang['opt_row'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('cols',$cs_gallery['cols'],'text',1,4);
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('insert_table_col');
  echo $cs_lang['opt_col'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('rows',$cs_gallery['rows'],'text',1,4);
  echo cs_html_roco(0);

  /*
  echo cs_html_roco(1,'leftc');
  echo cs_icon('xpaint');
  echo $cs_lang['opt_pic'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('xpics',$cs_gallery['xpics'],'hidden',2,4);
  echo cs_html_roco(0);
  */

  echo cs_html_roco(1,'leftc');
  echo cs_icon('xpaint');
  echo $cs_lang['opt_max_wight'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('max_width',$cs_gallery['max_width'],'text',4,4);
  echo $cs_lang['pixel'];
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('thumbnail');
  echo $cs_lang['opt_tb'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('thumbs',$cs_gallery['thumbs'],'text',3,4);
  echo $cs_lang['pixel'];
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('thumbnail');
  echo $cs_lang['opt_tq'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('quality',$cs_gallery['quality'],'text',3,4);
  echo "%";
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('resizecol');
  echo $cs_lang['opt_pic_mb'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('width',$cs_gallery['width'],'text',4,4);
  echo $cs_lang['pixel'];
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('resizerow');
  echo $cs_lang['opt_pic_mh'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('height',$cs_gallery['height'],'text',4,4);
  echo $cs_lang['pixel'];
  echo cs_html_roco(0);

  $size = $cs_gallery['size'] / 1024;

  echo cs_html_roco(1,'leftc');
  echo cs_icon('fileshare');
  echo $cs_lang['opt_pic_ms'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('size',$size,'text',4,4);
  echo "kb";
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('Volume Manager');
  echo $cs_lang['top_votes'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_select(1,'top_5_votes');
  $levels = 0;
  while($levels < 2)
  {
    $cs_gallery['top_5_votes'] == $levels ? $sel = 1 : $sel = 0;
    echo cs_html_option($cs_lang['show_' . $levels],$levels,$sel);
    $levels++;
  }
  echo cs_html_select(0);
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('image');
  echo $cs_lang['top_views'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_select(1,'top_5_views');
  $levels = 0;
  while($levels < 2)
  {
    $cs_gallery['top_5_views'] == $levels ? $sel = 1 : $sel = 0;
    echo cs_html_option($cs_lang['show_' . $levels],$levels,$sel);
    $levels++;
  }
  echo cs_html_select(0);
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('xchat');
  echo $cs_lang['newest_pics'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_select(1,'newest_5');
  $levels = 0;
  while($levels < 2)
  {
    $cs_gallery['newest_5'] == $levels ? $sel = 1 : $sel = 0;
    echo cs_html_option($cs_lang['show_' . $levels],$levels,$sel);
    $levels++;
  }
  echo cs_html_select(0);
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('playlist');
  echo $cs_lang['list_sort'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_select(1,'list_sort');
  $levels = 0;
  while($levels < 2)
  {
    $cs_gallery['list_sort'] == $levels ? $sel = 1 : $sel = 0;
    echo cs_html_option($cs_lang['sort_' . $levels],$levels,$sel);
    $levels++;
  }
  echo cs_html_select(0);
  echo cs_html_roco(0);
  
  echo cs_html_roco(1,'leftc');
  echo cs_icon('thumbnail');
  echo $cs_lang['lightbox'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_select(1,'lightbox');
  $levels = 0;
  while($levels < 3)
  {
    $cs_gallery['lightbox'] == $levels ? $sel = 1 : $sel = 0;
    echo cs_html_option($cs_lang['light_' . $levels],$levels,$sel);
    $levels++;
  }
  echo cs_html_select(0);
  echo cs_html_roco(0);
  
  

  echo cs_html_roco(1,'headb',0,2);
  echo $cs_lang['usergallery'];
  echo cs_html_roco(0);

  $size_2 = $cs_gallery['size2'] / 1024;

  echo cs_html_roco(1,'leftc');
  echo cs_icon('fileshare');
  echo $cs_lang['opt_pic_ms'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('size2',$size_2,'text',4,4);
  echo 'kb';
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('xpaint');
  echo $cs_lang['opt_max_files'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('max_files',$cs_gallery['max_files'],'text',4,4);
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('folder_yellow');
  echo $cs_lang['max_cats'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('max_folders',$cs_gallery['max_folders'],'text',4,4);
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('ksysguard');
  echo $cs_lang['options'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_vote('id',1,'hidden');
  echo cs_html_vote('submit',$cs_lang['edit'],'submit');
  echo cs_html_vote('reset',$cs_lang['reset'],'reset');
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_form (0);
}
?>