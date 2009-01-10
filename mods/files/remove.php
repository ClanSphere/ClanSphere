<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('files');

$files_id = $_REQUEST['id'];
$files_form = 1;

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['remove'];
echo cs_html_roco(0);

if(isset($_POST['agree'])) {
	$files_form = 0;
	
	$previews = cs_sql_select(__FILE__,'files','files_previews',"files_id = '" . $files_id . "'");
	$file_string = $previews['files_previews'];
	$file_pics = empty($file_string) ? array() : explode("\n",$file_string);
	foreach($file_pics AS $pics) {
		cs_unlink('files', 'picture-' . $pics);
		cs_unlink('files', 'thumb-' . $pics);
	}
	
	cs_sql_delete(__FILE__,'files',$files_id);
	$query = "DELETE FROM {pre}_comments WHERE comments_mod='files' AND ";
	$query .= "comments_fid='" . $files_id . "'";
	cs_sql_query(__FILE__,$query);
	$query = "DELETE FROM {pre}_voted WHERE voted_mod='files' AND ";
	$query .= "voted_fid='" . $files_id . "'";
	cs_sql_query(__FILE__,$query);

	cs_redirect($cs_lang['del_true'], 'files');
}

if(isset($_POST['cancel'])) {
	$files_form = 0;
	cs_redirect($cs_lang['del_false'], 'files');
}

if(!empty($files_form)) {

	echo cs_html_roco(1,'leftb');
	echo sprintf($cs_lang['del_rly'],$files_id);
	echo cs_html_roco(0);

	echo cs_html_roco(1,'centerc');
	echo cs_html_form(1,'files_remove','files','remove');
	echo cs_html_vote('id',$files_id,'hidden');
	echo cs_html_vote('agree',$cs_lang['confirm'],'submit');
	echo cs_html_vote('cancel',$cs_lang['cancel'],'submit');
	echo cs_html_form (0);
	echo cs_html_roco(0);
	echo cs_html_table(0);
}
?>