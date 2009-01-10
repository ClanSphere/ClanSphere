<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cash');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_remove'];
echo cs_html_roco(0);

$cash_form = 1;
$cash_id = $_REQUEST['id'];

if(isset($_POST['agree'])) {
	$cash_form = 0;
	cs_sql_delete(__FILE__,'cash',$cash_id);
	cs_redirect($cs_lang['del_true'], 'cash');
}

if(isset($_POST['cancel'])) 
  cs_redirect($cs_lang['del_false'], 'cash');

if(!empty($cash_form)) {

	echo cs_html_roco(1,'leftb');
	echo sprintf($cs_lang['del_rly'],$cash_id);
	echo cs_html_roco(0);

	echo cs_html_roco(1,'centerc');
	echo cs_html_form(1,'cash_remove','cash','remove');
	echo cs_html_vote('id',$cash_id,'hidden');
	echo cs_html_vote('agree',$cs_lang['confirm'],'submit');
	echo cs_html_vote('cancel',$cs_lang['cancel'],'submit');
	echo cs_html_form (0);
	echo cs_html_roco(0);
	echo cs_html_table(0);
}

?>
