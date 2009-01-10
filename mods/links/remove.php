<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('links');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_remove'];
echo cs_html_roco(0);

$links_form = 1;
$links_id = $_REQUEST['id'];
settype($links_id,'integer');

if(isset($_POST['agree'])) {
	$links_form = 0;
	$banner = cs_sql_select(__FILE__,'links','links_banner',"links_id = '" . $links_id . "'");
	if(!empty($banner['links_banner'])) {
	  cs_unlink('links', $banner['links_banner']);
	}
	cs_sql_delete(__FILE__,'links',$links_id);
	cs_redirect($cs_lang['del_true'], 'links');
}

if(isset($_POST['cancel'])) 
  cs_redirect($cs_lang['del_false'], 'links');

if(!empty($links_form)) {

	echo cs_html_roco(1,'leftb');
	echo sprintf($cs_lang['del_rly'],$links_id);
	echo cs_html_roco(0);

	echo cs_html_roco(1,'centerc');
	echo cs_html_form(1,'links_remove','links','remove');
	echo cs_html_vote('id',$links_id,'hidden');
	echo cs_html_vote('agree',$cs_lang['confirm'],'submit');
	echo cs_html_vote('cancel',$cs_lang['cancel'],'submit');
	echo cs_html_form (0);
	echo cs_html_roco(0);
	echo cs_html_table(0);
}

?>
