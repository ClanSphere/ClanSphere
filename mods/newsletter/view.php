<?php
$cs_lang = cs_translate('newsletter');

$newsletter_id=$_REQUEST['id'];
settype($newsletter_id,'integer');

$from = 'newsletter nwl INNER JOIN {pre}_users usr ON nwl.users_id = usr.users_id ';
$select = 'nwl.newsletter_id AS newsletter_id, nwl.newsletter_subject AS newsletter_subject, nwl.newsletter_time AS newsletter_time, nwl.newsletter_text AS newsletter_text, nwl.newsletter_to AS newsletter_to, nwl.users_id AS users_id, usr.users_nick AS users_nick'; 

$cs_newsletter = cs_sql_select(__FILE__,$from,$select,"newsletter_id = '" . $newsletter_id . "'");
		
echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,3);
echo $cs_lang['mod'] . ' - ' . $cs_lang['details'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo cs_icon('kate');
echo $cs_lang['subject'];
echo cs_html_roco(2,'leftb');
echo cs_secure($cs_newsletter['newsletter_subject']);
echo cs_html_roco(0);

echo cs_html_roco(1,'leftb');
echo cs_icon('clock');
echo $cs_lang['date'];
echo cs_html_roco(2,'leftb');
echo cs_date('unix',$cs_newsletter['newsletter_time'],1);
echo cs_html_roco(0); 

echo cs_html_roco(1,'leftb');
echo cs_icon('personal');
echo $cs_lang['from2'];
echo cs_html_roco(2,'leftb');
echo cs_secure($cs_newsletter['users_nick']);
echo cs_html_roco(0);

echo cs_html_roco(1,'leftb');
echo cs_icon('kdmconfig');
echo $cs_lang['to'];
echo cs_html_roco(2,'leftb');
$check_to = explode('?',$cs_newsletter['newsletter_to']); 
switch ($check_to[0])
{
	case 1:
	{
		$newsletter_to = 'Alle Benutzer';
		break;
	}
	case 2:
	{
		$newsletter_to = 'Benutzergruppe: '; 
		$group = cs_sql_select(__FILE__,'access','access_name',"access_id = '" . $check_to[1] . "'");
		$newsletter_to .= $group['access_name'];
		break;
	}
	case 3:
	{
		$newsletter_to = 'Squad: ';
		$group = cs_sql_select(__FILE__,'squads','squads_name',"squads_id = '" . $check_to[1] . "'");
		$newsletter_to .= $group['squads_name'];
		break;
	}
	case 4:
	{
		$newsletter_to = 'Clan: ';
		$group = cs_sql_select(__FILE__,'clans','clans_name',"clans_id = '" . $check_to[1] . "'");
		$newsletter_to .= $group['clans_name'];
		break;
	} 			                                          	                                            
}
echo cs_secure($newsletter_to);
echo cs_html_roco(0);

echo cs_html_roco(1,'headb',0,3);
echo $cs_lang['text'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb',0,2);
echo cs_secure($cs_newsletter['newsletter_text'],1,1);
echo cs_html_roco(0);
echo cs_html_table(0);
?>