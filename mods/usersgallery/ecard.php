<?PHP
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');

$users_id = $account['users_id'];
$cs_ecard_users = cs_sql_select(__FILE__,'users','users_nick, users_email',"users_id = '" . $users_id . "'");
$id = isset($_REQUEST['user']) ? $_REQUEST['user'] : $_POST['id'];

$sender_name = $cs_ecard_users['users_nick'];
$sender_mail = $cs_ecard_users['users_email'];
$receiver_name = '';
$receiver_mail = '';
$ecard_titel = '';
$ecard_text = '';

$ecard_error = '';
$errormsg = '';

if (!empty($_POST['pic']))
{
	$pic = $_POST['pic'];
}
else
{
	$ecard_error++;
	$errormsg .= $cs_lang['error_pic'] . cs_html_br(1);
}

if (!empty($_POST['ecard_titel']) AND !empty($_POST['ecard_text']))
{
	$ecard_titel = $_POST['ecard_titel'];
	$ecard_text = $_POST['ecard_text'];
}
else
{
	$ecard_error++;
	$errormsg .= $cs_lang['error_text'] . cs_html_br(1);
}

if (!empty($_POST['receiver_name']) AND !empty($_POST['receiver_mail']))
{
	$receiver_name = $_POST['receiver_name'];
	$receiver_mail = $_POST['receiver_mail'];
}
else
{
	$ecard_error++;
	$errormsg .= $cs_lang['error_receiver'] . cs_html_br(1);
}

if (!empty($_POST['sender_name']) AND !empty($_POST['sender_mail']))
{
	$sender_name = $_POST['sender_name'];
	$sender_mail = $_POST['sender_mail'];
}
else
{
	$ecard_error++;
	$errormsg .= $cs_lang['error_sender'] . cs_html_br(1);
}

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_list'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo $cs_lang['body_list'];
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

if (isset($_POST['preview']))
{
	if (empty($ecard_error))
	{
	  	echo cs_html_form (1,'ecard1','usersgallery','ecard');
		echo cs_html_table(1,'forum',1);
		echo cs_html_roco(1,'centerb');
		echo cs_html_img('mods/gallery/image.php?userspic=' . $pic . '&size=300');
		echo cs_html_roco(2,'leftb',2);
		echo $cs_lang['of'];
		echo cs_html_link('mailto:' . $sender_mail,$sender_name,1);
		echo cs_html_br(2);
		echo $cs_lang['to'];
		echo cs_html_link('mailto:' . $receiver_mail,$receiver_name,1);
		echo cs_html_br(4);
		echo cs_date('unix',cs_time(),1);
		echo cs_html_roco(0);

		echo cs_html_roco(1,'leftb');
		echo cs_html_big(1);
		echo cs_secure($ecard_titel,1);
		echo cs_html_big(0);
		echo cs_html_br(2);
		echo cs_secure($ecard_text,1);
		echo cs_html_roco(0);
		echo cs_html_table(0);
		echo cs_html_br(1);

		echo cs_html_table(1,'forum',1);
		echo cs_html_roco(1,'leftc');
		echo cs_icon('ksysguard') . $cs_lang['options'];
		echo cs_html_roco(2,'leftb');
		echo cs_html_vote('sender_mail',$sender_mail,'hidden');
		echo cs_html_vote('sender_name',$sender_name,'hidden');
		echo cs_html_vote('receiver_mail',$receiver_mail,'hidden');
		echo cs_html_vote('receiver_name',$receiver_name,'hidden');
		echo cs_html_vote('id',$id,'hidden');
		echo cs_html_vote('pic',$pic,'hidden');
		echo cs_html_vote('ecard_titel',$ecard_titel,'hidden');
		echo cs_html_vote('ecard_text',$ecard_text,'hidden');
		echo cs_html_vote('submit',$cs_lang['submit'],'submit');
		echo cs_html_roco(0);
		echo cs_html_table(0);
		echo cs_html_form (0);
		echo cs_html_br(1);
	}
	else
	{
		echo cs_html_table(1,'forum',1);
		echo cs_html_roco(1,'leftc');
		echo cs_icon('important');
		echo $ecard_error;
		if($ecard_error == '1')
		{
			echo $cs_lang['error_occurred_1'];
		}
		else
		{
			echo $cs_lang['error_occurred'];
		}
		echo cs_html_roco(0);
		echo cs_html_roco(2,'leftc');
		echo $errormsg;
		echo cs_html_roco(0);
		echo cs_html_table(0);
		echo cs_html_br(1);
	}
}
if (isset($_POST['submit']))
{
	if (empty($ecard_error))
	{
	  	// gallery_count_cards
		// Für die &adresse noch einzufügen!!! ein MD5 hash aus e-mail Adresse und ID nummer. Bzw. Nur E-Mail.
		//$adresse =
		$title = $cs_lang['titel1'];
		$time = cs_date('unix',cs_time(),1);
	  	//$message = sprintf($cs_lang['message'], $receiver_name,cs_secure('[url=www.google.de]link[/url]',1),$sender_name,$sender_mail);
	  	$message = "<html><head><style type=text/css>
					<!--
					body { background-color: #CCCCCC; }
					-->
					</style></head><body><table width=92% border=1 align=center cellpadding=10 cellspacing=0 class=forum>
					<tr><td>
					<img src=mods/gallery/image.php?pic=$pic&size=300 alt= />
					</td><td  valign=top  width=20% rowspan=2>
					<img src=symbols/crystal_clear/48/icons.png style=float:right alt= />
					<br /><br /><br /><br /><br /><br />
					$cs_lang[of] <a href=mailto:$sender_mail > $sender_name</a>
					<br /><br />
					$cs_lang[to] <a href=mailto:$receiver_mail > $receiver_name</a>
					<br /><br /><br /><br />$time</td></tr><tr><td>
					<strong>$ecard_titel</strong>
					<br /><br />$ecard_text</td></tr></table> </html>";
		$type = 'text/html';

		if(cs_mail($receiver_mail,$title,$message,0,$type))
		{
			$from = 'usersgallery';
			$select = 'usersgallery_count_cards';
			$where = "usersgallery_id = '" . cs_sql_escape($pic) . "'";
			$cs_gallery = cs_sql_select(__FILE__,$from,$select,$where);

			$gallery_count = $cs_gallery['usersgallery_count_cards'] + 1;
			$gallery_cells = array('usersgallery_count_cards');
			$gallery_save = array($gallery_count);
			cs_sql_update(__FILE__,'usersgallery',$gallery_cells,$gallery_save,$pic);
			$getmsg_msg = $cs_lang['create_down'];
		}
		else
		{
			$getmsg_msg = $cs_lang['create_error'];
		}

		cs_redirect($getmsg_msg,'usersgallery','users','id='. $id);
	}
}
if(!empty($_REQUEST['id']) AND !isset($_POST['submit']) OR isset($_POST['pic']) AND !isset($_POST['submit']))
{
	if(!empty($_REQUEST['id']))
	{
		$pic = $_REQUEST['id'];
	}
	else
	{
		$pic = $_POST['pic'];
	}
	echo cs_html_form (1,'ecard','usersgallery','ecard');
	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'leftc');
	echo cs_icon('image') . $cs_lang['pic'];
	echo cs_html_roco(2,'centerb');
	echo cs_html_img('mods/gallery/image.php?userspic=' . $pic . '&size=300');
	echo cs_html_roco(0);

	echo cs_html_roco(1,'headb',0,2);
	echo $cs_lang['sender'];
	echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo $cs_lang['sender_name'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_input('sender_name',$sender_name,'text',80,40);
	echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo $cs_lang['sender_mail'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_input('sender_mail',$sender_mail,'text',80,40);
	echo cs_html_roco(0);

	echo cs_html_roco(1,'headb',0,2);
	echo $cs_lang['receiver'];
	echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo $cs_lang['receiver_name'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_input('receiver_name',$receiver_name,'text',80,40);
	echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo $cs_lang['receiver_mail'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_input('receiver_mail',$receiver_mail,'text',80,40);
	echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo $cs_lang['titel'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_input('ecard_titel',$ecard_titel,'text',80,40);
	echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo cs_icon('kate') . $cs_lang['text'] . ' *';
	echo cs_html_br(2);
	echo cs_abcode_smileys('ecard_text');
	echo cs_html_roco(2,'leftb');
	echo cs_abcode_features('ecard_text');
	echo cs_html_textarea('ecard_text',$ecard_text,'50','15');
	echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo cs_icon('ksysguard') . $cs_lang['options'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_vote('pic',$pic,'hidden');
	echo cs_html_vote('id',$id,'hidden');
	echo cs_html_vote('preview',$cs_lang['preview'],'submit');
	echo cs_html_vote('reset',$cs_lang['reset'],'reset');
	echo cs_html_roco(0);
	echo cs_html_table(0);
	echo cs_html_form (0);
	echo cs_html_br(1);
}

?>