<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('explorer');

function cs_abcode_tools($field) {
  
  global $cs_lang;
  $more = "onchange=\"javascript:abc_insert(this.form.cs_tools.options";
  $more .= "[this.form.cs_tools.selectedIndex].value + '(',')','".$field."');";
  $more .= "this.selectedIndex=0\"";

  $var = cs_html_select(1,'cs_tools',$more);
  $var .= cs_html_option('Tools',0);
  $var .= cs_html_option('cs_addons','cs_addons');
  $var .= cs_html_option('cs_checkdirs','cs_checkdirs');
  $var .= cs_html_option('cs_date','cs_date');
  $var .= cs_html_option('cs_datereal','cs_datereal');
  $var .= cs_html_option('cs_datepost','cs_datepost');
  $var .= cs_html_option('cs_dateselect','cs_dateselect');
  $var .= cs_html_option('cs_dropdown','cs_dropdown');
  $var .= cs_html_option('cs_filesize','cs_filesize');
  $var .= cs_html_option('cs_icon','cs_icon');
  $var .= cs_html_option('cs_link','cs_link');
  $var .= cs_html_option('cs_mail','cs_mail');
  $var .= cs_html_option('cs_pages','cs_pages');
  $var .= cs_html_option('cs_paths','cs_paths');
  $var .= cs_html_option('cs_sort','cs_sort');
  $var .= cs_html_option('cs_translate','cs_translate');
  $var .= cs_html_option('cs_upload','cs_upload');
  $var .= cs_html_select(0);
  
  return $var;
}

function cs_abcode_toolshtml($name) {
  
  global $cs_lang;
  $more = "onchange=\"javascript:abc_insert(this.form.cs_html.options";
  $more .= "[this.form.cs_html.selectedIndex].value + '(',')','".$name."');";
  $more .= "this.selectedIndex=0\"";
  
  $var = cs_html_select(1,'cs_html',$more);
  $var .= cs_html_option('HTML',0);
  $var .= cs_html_option('cs_html_br','cs_html_br');
  $var .= cs_html_option('cs_html_hr','cs_html_hr');
  $var .= cs_html_option('cs_html_img','cs_html_img');
  $var .= cs_html_option('cs_html_link','cs_html_link');
  $var .= cs_html_option('cs_html_select','cs_html_select');
  $var .= cs_html_option('cs_html_option','cs_html_option');
  $var .= cs_html_select(0);
  
  return $var;
}

function cs_abcode_toolshtml2($name) {
  
  global $cs_lang;
  $more = "onchange=\"javascript:abc_insert(this.form.cs_html2.options";
  $more .= "[this.form.cs_html2.selectedIndex].value + '(',')','".$name."');";
  $more .= "this.selectedIndex=0\"";
  
  $var = cs_html_select(1,'cs_html2',$more);
  $var .= cs_html_option('HTML - 2',0);
  $var .= cs_html_option('cs_html_anchor','cs_html_anchor');
  $var .= cs_html_option('cs_html_hr','cs_html_hr');
  $var .= cs_html_option('cs_html_mail','cs_html_mail');
  $var .= cs_html_option('cs_html_underline','cs_html_underline');
  $var .= cs_html_option('cs_html_big','cs_html_big');
  $var .= cs_html_option('cs_html_italic','cs_html_italic');
  $var .= cs_html_select(0);
  
  return $var;
}

function cs_abcode_sql($name) {
  
  global $cs_lang;
  $more = "onchange=\"javascript:abc_insert(this.form.cs_sql.options";
  $more .= "[this.form.cs_sql.selectedIndex].value + '(',')','".$name."');";
  $more .= "this.selectedIndex=0\"";
  
  $var = cs_html_select(1,'cs_sql',$more);
  $var .= cs_html_option('SQL',0);
  $var .= cs_html_option('cs_sql_connect','cs_sql_connect');
  $var .= cs_html_option('cs_sql_count','cs_sql_connect');
  $var .= cs_html_option('cs_sql_delete','cs_sql_delete');
  $var .= cs_html_option('cs_sql_escape','cs_sql_escape');
  $var .= cs_html_option('cs_sql_insert','cs_sql_insert');
  $var .= cs_html_option('cs_sql_insertid','cs_sql_insertid');
  $var .= cs_html_option('cs_sql_option','cs_sql_option');
  $var .= cs_html_option('cs_sql_query','cs_sql_query');
  $var .= cs_html_option('cs_sql_select','cs_sql_select');
  $var .= cs_html_option('cs_sql_update','cs_sql_update');
  $var .= cs_html_option('cs_sql_version','cs_sql_version');
  $var .= cs_html_select(0);
  
  return $var;
}