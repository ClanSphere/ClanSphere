<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('newsletter');
include('mods/newsletter/functions.php');

$required = array('users_id','newsletter_to','newsletter_subject','newsletter_time','newsletter_text');
if(!empty($_POST))
{
	$req = checkRequiredFields($_POST, $required);
	if(sizeof($req) == 0)
	{
		//print_r($_FILES);
		//print_r($_POST);
		//Hier pic uppen und array updaten :)
		save_send_mails($cs_lang, $_POST);
	}
	else
		addEditForm($cs_lang,0,$_POST,$req);
}
else
	addEditForm($cs_lang);

?>