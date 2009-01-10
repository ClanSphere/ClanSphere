<?php

$cs_lang = cs_translate('servers');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_remove'];
echo cs_html_roco(0);

$servers_form = 1;
$servers_id = $_REQUEST['id'];

if(isset($_POST['agree'])) {
	$servers_form = 0;
	cs_sql_delete(__FILE__,'servers',$servers_id);
	include_once('mods/servers/rss.php');
	cs_redirect($cs_lang['del_true'], 'servers');
}

if(isset($_POST['cancel']))
  cs_redirect($cs_lang['del_false'], 'servers');

if(!empty($servers_form)) {

	echo cs_html_roco(1,'leftb');
	echo sprintf($cs_lang['del_rly'],$servers_id);
	echo cs_html_roco(0);

	echo cs_html_roco(1,'centerc');
	echo cs_html_form(1,'servers_remove','servers','remove');
	echo cs_html_vote('id',$servers_id,'hidden');
	echo cs_html_vote('agree',$cs_lang['confirm'],'submit');
	echo cs_html_vote('cancel',$cs_lang['cancel'],'submit');
	echo cs_html_form (0);
	echo cs_html_roco(0);
	echo cs_html_table(0);
}

?>
