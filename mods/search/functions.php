<?PHP
// ClanSphere 2008 - www.clansphere.net
// $Id$

function cs_search($mod) {
	$cs_lang = cs_translate('search');
	$text = '';
	echo cs_html_form (1,'search_functions','search','list');
	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'headb',0,2);
	echo $cs_lang['mod'];
	echo cs_html_roco(0);
	echo cs_html_roco(1,'leftc');
	echo cs_icon('kedit');
	echo $cs_lang['text']. ' *';
	echo cs_html_roco(2,'leftc');
	echo cs_html_input('text',$text,'text',200,50);
	echo cs_html_vote('where',$mod,'hidden');
	echo cs_html_vote('submit',$cs_lang['search'],'submit');
	echo cs_html_vote('reset',$cs_lang['reset'],'reset');
	echo cs_html_roco(0);
	echo cs_html_table(0);
	echo cs_html_form(0);
}
?>