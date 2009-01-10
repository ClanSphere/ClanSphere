<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('linkus');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_remove'];
echo cs_html_roco(0);

$linkus_form = 1;
$linkus_id = $_REQUEST['id'];
settype($linkus_id,'integer');
$linkus = cs_sql_select(__FILE__,'linkus','linkus_banner',"linkus_id = '" . $linkus_id . "'");
$banner = $linkus['linkus_banner'];

if(isset($_POST['agree'])) {
	$linkus_form = 0;
	cs_sql_delete(__FILE__,'linkus',$linkus_id);
	
	cs_unlink('linkus', $banner);
	
	cs_redirect($cs_lang['del_true'], 'linkus');
}

if(isset($_POST['cancel'])) 
  cs_redirect($cs_lang['del_false'], 'inkus');

if(!empty($linkus_form)) {

	echo cs_html_roco(1,'leftb');
	echo sprintf($cs_lang['del_rly'],$linkus_id);
	echo cs_html_roco(0);

	echo cs_html_roco(1,'centerc');
	echo cs_html_form(1,'linkus_remove','linkus','remove');
	echo cs_html_vote('id',$linkus_id,'hidden');
	echo cs_html_vote('agree',$cs_lang['confirm'],'submit');
	echo cs_html_vote('cancel',$cs_lang['cancel'],'submit');
	echo cs_html_form (0);
	echo cs_html_roco(0);
	echo cs_html_table(0);
}

?>
