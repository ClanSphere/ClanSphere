<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cups');

$cups_count = cs_sql_count(__FILE__,'cups');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,2);
echo $cs_lang['mod'] . ' - ' . $cs_lang['manage'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc');
echo cs_icon('editpaste') . cs_link($cs_lang['new_cup'],'cups','create');
echo cs_html_roco(2,'leftc');
echo cs_icon('contents') . $cs_lang['total'].': '.$cups_count;
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

echo cs_getmsg();

$cells = 'cups_id, games_id, cups_name, cups_start, cups_teams';
$select = cs_sql_select(__FILE__,'cups',$cells,'','cups_start ASC',0,0);

if (!empty($select)) {

	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'headb');
	echo $cs_lang['game'];
	echo cs_html_roco(2,'headb');
	echo $cs_lang['name'];
	echo cs_html_roco(3,'headb');
	echo $cs_lang['max_teams'];
	echo cs_html_roco(4,'headb');
	echo $cs_lang['teams'];
	echo cs_html_roco(5,'headb',0,4);
	echo $cs_lang['options'];
	echo cs_html_roco(0);
	
  $img_teams = cs_icon('kdmconfig');
	$img_edit = cs_icon('edit');
	$img_del = cs_icon('editdelete');
	$img_start = cs_icon('forward');
	
	foreach($select AS $cup) {
  	echo cs_html_roco(1,'leftb');
  	if(file_exists('uploads/games/' . $cup['games_id'] . '.gif')) {
  		echo cs_html_img('uploads/games/' . $cup['games_id'] . '.gif');
  	}
		echo cs_html_roco(2,'leftb');
		echo cs_link($cup['cups_name'],'cups','view','id='.$cup['cups_id']);
		echo cs_html_roco(3,'leftb');
		echo $cup['cups_teams'];
		echo cs_html_roco(4,'leftb');
		echo cs_sql_count(__FILE__,'cupsquads','cups_id = \''.$cup['cups_id'].'\'');
		echo cs_html_roco(5,'leftb');
		$matchcount = cs_sql_count(__FILE__,'cupmatches','cups_id = \''.$cup['cups_id'].'\'');
		echo empty($matchcount) && $cup['cups_start'] < cs_time() ?
    		cs_link($img_start,'cups','start','id='.$cup['cups_id'],0,$cs_lang['start']) : '-';
		echo cs_html_roco(6,'leftb');
    echo empty($matchcount) ?
        cs_link($img_teams,'cups','teams','where='.$cup['cups_id'],0,$cs_lang['teams']) : '-';
    echo cs_html_roco(7,'leftb');
		echo cs_link($img_edit,'cups','edit','id='.$cup['cups_id'],0,$cs_lang['edit']);	
		echo cs_html_roco(8,'leftb');
		echo cs_link($img_del,'cups','remove','id='.$cup['cups_id'],0,$cs_lang['remove']);
		echo cs_html_roco(0);
	}
	echo cs_html_table(0);
	
}

?>