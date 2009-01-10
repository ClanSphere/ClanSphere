<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_remove'];
echo cs_html_roco(0);

$events_form = 1;
$events_id = $_REQUEST['id'];

if(isset($_POST['agree'])) {
	$events_form = 0;
	cs_sql_delete(__FILE__,'events',$events_id);
	cs_redirect($cs_lang['del_true'], 'events');
}

if(isset($_POST['cancel'])) 
  cs_redirect($cs_lang['del_false'], 'events');

if(!empty($events_form)) {

	echo cs_html_roco(1,'leftb');
	echo sprintf($cs_lang['del_rly'],$events_id);
	echo cs_html_roco(0);

	echo cs_html_roco(1,'centerc');
	echo cs_html_form(1,'events_remove','events','remove');
	echo cs_html_vote('id',$events_id,'hidden');
	echo cs_html_vote('agree',$cs_lang['confirm'],'submit');
	echo cs_html_vote('cancel',$cs_lang['cancel'],'submit');
	echo cs_html_form (0);
	echo cs_html_roco(0);
	echo cs_html_table(0);
}

?>
