<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('wars');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['delete_round'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc');

if (!empty($_POST['submit'])) {
	
	$roundid = (int) $_POST['id'];
	
	$warid = cs_sql_select(__FILE__,'rounds','wars_id','rounds_id = \''.$roundid.'\'');
	
	cs_sql_delete(__FILE__,'rounds',$roundid);
	
	cs_redirect($cs_lang['del_true'],'wars','rounds','id='.$warid['wars_id']);

} else {
	
	echo $cs_lang['really_delete'];
	echo cs_html_roco(0);
	echo cs_html_roco(1,'centerb');
	echo cs_html_form(1,'roundsremove','wars','roundsremove');
	echo cs_html_vote('id',$_GET['id'],'hidden');
	echo cs_html_vote('submit',$cs_lang['confirm'],'submit');
	echo cs_html_form(0);

}

echo cs_html_roco(0);
echo cs_html_table(0);

?>