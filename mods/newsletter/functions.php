<?php
function addEditForm($cs_lang,$edit = 0, $data = 0, $highlight = 0)
{
	global $account;
		
	echo cs_html_form (1,'newsletter_form','newsletter','create');		

	echo cs_html_table(1,'forum',1);
	// --
	echo cs_html_roco(1,'headb',0,2); 
	echo $cs_lang['head_create'];
	echo cs_html_roco(1,'leftb',0,2);
	echo $cs_lang['require'];
	echo cs_html_roco(0);
	echo cs_html_table(0);
	// -- 
	echo cs_html_br(1);
	echo cs_html_table(1,'forum',1);
	// -- 
	echo cs_html_form (1,'newsletter_form','newsletter','create'); 
	echo cs_html_roco(1,'leftc');
	echo cs_icon('kate');
	echo @missing_detect($cs_lang['subject'] . " *", $highlight['newsletter_subject']);
	echo cs_html_roco(2,'leftb');
	// -- 
	echo cs_html_input('newsletter_subject',$data['newsletter_subject'],'text',50,30);
	echo cs_html_roco(0);
	// -- 
	echo cs_html_roco(1,'leftc');
	echo cs_icon('personal'); 
	echo @missing_detect($cs_lang['to'] . " *", $highlight['newsletter_to']);
	echo cs_html_roco(2,'leftb');
	echo cs_html_select(1,'newsletter_to');
	echo cs_html_option('Alle Benutzer','1');
	echo cs_html_option('-->' .$cs_lang['ac_group'],'');
	$usergroups = cs_sql_select(__FILE__,'access','access_id,access_name','access_id != 1',0,0,0);
	foreach($usergroups as $value)
	{
		echo cs_html_option('-' .$value['access_name'],'2?' .$value['access_id']);	 	
	}	 
	echo cs_html_option('-->' .$cs_lang['squads'],'');     
	$usergroups = cs_sql_select(__FILE__,'squads','squads_id,squads_name',0,0,0,0);
	foreach($usergroups as $value)
	{
		echo cs_html_option('-' .$value['squads_name'],'3?' .$value['squads_id']);	 	
	}	 
	echo cs_html_option('-->' .$cs_lang['clans'],'');
	$usergroups = cs_sql_select(__FILE__,'clans','clans_id,clans_name',0,0,0,0);
	foreach($usergroups as $value)
	{
		echo cs_html_option('-' .$value['clans_name'],'4?' .$value['clans_id']);	 	
	}	 
	echo cs_html_select(0);
	echo cs_html_roco(0);
	// -- 
	echo cs_html_roco(1,'leftc');
	echo cs_icon('kedit');
	echo @missing_detect($cs_lang['text'] . " *", $highlight['newsletter_text']);
	echo cs_html_roco(2,'leftb');
	echo cs_html_textarea('newsletter_text',$data['newsletter_text'],50,30);
	echo cs_html_roco(0);
	// --  
	echo cs_html_roco(1,'leftc');
	echo cs_icon('ksysguard');
	echo $cs_lang['options'];
	echo cs_html_roco(2,'leftc');
	echo cs_html_vote('users_id',$account['users_id'],'hidden');
	echo cs_html_vote('newsletter_time',cs_time(),'hidden');
	echo cs_html_vote('submit',$cs_lang['submit'],'submit');
	//echo cs_html_vote('preview',$cs_lang['preview'],'submit');
	echo cs_html_vote('reset',$cs_lang['reset'],'reset');
	echo cs_html_roco(0);
	echo cs_html_table(0);
	echo cs_html_form (0);		
}

function save_send_mails($cs_lang, $data)
{       
	global $cs_main; 
	foreach($data as $name => $value) //Ginge zwar mit php funktion aber, ich möchte verhindern das einiges eingetragen wird
	{
		if($name != "submit")
		{
			$cells[] = $name;
			if(empty($value))
				$value = '';
			$content[] = $value;
		}
	}
	//print_r ($content);
	$check_to = explode('?',$content[1]); 
	switch ($check_to[0]) 
	{
		case 1:
   		{
   			$from  = 'users';
			$where = "users_active = '1' AND users_newsletter = '1'";
			$select = 'users_email';
   			break;
   		}
   		break;
       		case 2:
   		{
   			$from  = 'access acs INNER JOIN {pre}_users usr ON usr.access_id = acs.access_id ';
			$where = "acs.access_id = '" . $check_to[1] . "' AND usr.users_newsletter = '1'";
			$select = 'usr.users_email';
   			break;
   		}
   		break;
		case 3:
		{
   			$from  = 'squads squ INNER JOIN {pre}_members meb ON meb.squads_id = squ.squads_id ';
			$from .= 'INNER JOIN {pre}_users usr ON meb.users_id = usr.users_id';
			$where = "squ.squads_id = '" . $check_to[1] . "' AND usr.users_newsletter = '1'";
			$select = 'usr.users_email';
   			break;
   		} 
   		case 4:
   		{
   			$from  = 'clans cln INNER JOIN {pre}_squads squ ON squ.clans_id = cln.clans_id ';
   			$from .= 'INNER JOIN {pre}_members meb ON meb.squads_id = squ.squads_id ';
			$from .= 'INNER JOIN {pre}_users usr ON meb.users_id = usr.users_id';
			$where = "cln.clans_id = '" . $check_to[1] . "' AND usr.users_newsletter = '1'";
			$select = 'usr.users_email';
   			break;
   		}
   		break;
	}
	//senden der mails
	$mail_addys = cs_sql_select(__FILE__,$from,$select,$where,0,0,0);
	//print_r ($mail_addys);
	$count_mails = 0; 
	foreach($mail_addys as $value)
	{       
		cs_mail($value['users_email'],$content[0],$content[2]);
		$count_mails++; 
	}
	//eintargen der newsletter in die datenbank
	cs_sql_insert(__FILE__,'newsletter',$cells,$content);
	echo cs_html_table(1,'forum',1);
	// -- 
	echo cs_html_roco(1,'headb',0,2); 
	echo $cs_lang['head_create']; 
	echo cs_html_roco(1,'leftb');
	echo sprintf($cs_lang['sucessfull'] ,$count_mails);
	echo cs_html_br(1);
	echo cs_html_roco(1,'centerc');
	echo cs_link($cs_lang['next'],'newsletter','manage');
	echo cs_html_roco(0); 
	// -- 
	echo cs_html_table(0);	
}
function checkRequiredFields($array, $fields)
{
	$result = array();
	//Eigentlich würde ne Zahl oder Bool reichen, aber damit kann ich die Daten weiterverwenden
	foreach($fields as $value)
	{
		if(empty($array[$value]))
				$result[$value] = 1;
		//else
			//$result[$value] = 0;
	}
	return $result;
}
function missing_detect($text, $input_name)
{
	if(empty($input_name))
		echo cs_secure($text);		
	else    
	{                      
		echo cs_html_big(1);
		echo cs_html_span(1,'color:maroon');
		echo cs_secure($text);
		echo cs_html_span(0);
		echo cs_html_big(0); 
	}
}	
?>