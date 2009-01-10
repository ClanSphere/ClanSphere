<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('news');

$data = array();
$data['head']['mod'] = $cs_lang['mod'];
$data['head']['action'] = $cs_lang['options'];
$data['head']['topline'] = $cs_lang['options_info'];

if(isset($_POST['submit'])) {

	settype($_POST['max_width'],'integer');
	settype($_POST['max_height'],'integer');
	settype($_POST['max_size'],'integer');
	settype($_POST['max_navlist'],'integer');
	settype($_POST['max_recent'],'integer');
	settype($_POST['def_public'],'integer');
	/* ABCode */
	settype($_POST['features'],'integer');
	settype($_POST['smileys'],'integer');
  settype($_POST['clip'],'integer');
  settype($_POST['html'],'integer');
  settype($_POST['php'],'integer');

  $abcode = array($_POST['features'],$_POST['smileys'],$_POST['clip'],$_POST['html'],$_POST['php']);
  $abcode = implode(",",$abcode);

  $opt_where = "options_mod = 'news' AND options_name = ";
  $def_cell = array('options_value');
  $def_cont = array($_POST['max_width']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'max_width'");
  $def_cont = array($_POST['max_height']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'max_height'");
  $def_cont = array($_POST['max_size']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'max_size'");
  $def_cont = array($_POST['max_navlist']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'max_navlist'");
  $def_cont = array($_POST['max_recent']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'max_recent'");
  $def_cont = array($_POST['def_public']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'def_public'");
  $def_cont = array($_POST['rss_title']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'rss_title'");
  $def_cont = array($_POST['rss_description']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'rss_description'");
  $def_cont = array($abcode);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'abcode'");

	$data['head']['topline'] = $cs_lang['changes_done'];
}

$op_news = cs_sql_option(__FILE__,'news');

$data['op']['max_width'] = $op_news['max_width'];
$data['op']['max_height'] = $op_news['max_height'];
$data['op']['max_size'] = $op_news['max_size'];
$data['op']['max_navlist'] = $op_news['max_navlist'];
$data['op']['max_recent'] = $op_news['max_recent'];
$data['op']['rss_title'] = $op_news['rss_title'];
$data['op']['rss_description'] = $op_news['rss_description'];
$data['op']['public_no'] = empty($op_news['def_public']) ? ' checked="checked"' : '';
$data['op']['public_yes'] = empty($op_news['def_public']) ? '' : ' checked="checked"';
/* ABcode*/
$abcode = explode(",",$op_news['abcode']);
$data['op']['features'] = empty($abcode[0]) ? '' : 'checked="checked"';
$data['op']['smileys'] = empty($abcode[1]) ? '' : 'checked="checked"';
$data['op']['clip'] = empty($abcode[2]) ? '' : 'checked="checked"';
$data['op']['html'] = empty($abcode[3]) ? '' : 'checked="checked"';
$data['op']['php'] = empty($abcode[4]) ? '' : 'checked="checked"';


echo cs_subtemplate(__FILE__,$data,'news','options');

?>