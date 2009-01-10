<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('wars');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['remove'];
echo cs_html_roco(0);

$wars_form = 1;
$wars_id = $_REQUEST['id'];
settype($wars_id,'integer');

if(isset($_POST['agree'])) {
	$wars_form = 0;
	
	$wars = cs_sql_select(__FILE__,'wars','wars_pictures',"wars_id = '" . $wars_id . "'");
	$wars_string = $wars['wars_pictures'];
	$wars_pics = empty($wars_string) ? array() : explode("\n",$wars_string);
	foreach($wars_pics AS $pics) {
		cs_unlink('wars', 'picture-' . $pics);
		cs_unlink('wars', 'thumb-' . $pics);
	}
	
	cs_sql_delete(__FILE__,'wars',$wars_id);
  cs_sql_delete(__FILE__,'rounds',$wars_id,'wars_id');
  cs_sql_delete(__FILE__,'players',$wars_id,'wars_id');
  cs_redirect($cs_lang['del_true'], 'wars');
}

if(isset($_POST['cancel']))
  cs_redirect($cs_lang['del_false'], 'wars');

if(!empty($wars_form)) {

	echo cs_html_roco(1,'leftb');
  echo sprintf($cs_lang['remove_rly'],$wars_id);
	echo cs_html_roco(0);

	echo cs_html_roco(1,'centerc');
	echo cs_html_form(1,'wars_remove','wars','remove');
	echo cs_html_vote('id',$wars_id,'hidden');
	echo cs_html_vote('agree',$cs_lang['confirm'],'submit');
	echo cs_html_vote('cancel',$cs_lang['cancel'],'submit');
	echo cs_html_form (0);
	echo cs_html_roco(0);
	echo cs_html_table(0);
}

?>
