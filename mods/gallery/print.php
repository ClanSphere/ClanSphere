<?PHP
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');

	$error = '';
	$errormsg = '';
	
	if(!empty($_REQUEST['pic']))
	{
		$pic = $_REQUEST['pic'];
	}
	else
	{
		$error++;
		$pic = '';
	}

	if(!empty($_POST['print'])) 
	{
		$print = $_POST['print'];
	}
	else
	{
		$error++;
		$errormsg .= $cs_lang['error_print'] . cs_html_br(1);
	}
	
	if(!empty($_POST['pic'])) 
	{
		$pic = $_POST['pic'];
	}
	else
	{
		$error++;
		$errormsg .= $cs_lang['error_pic'] . cs_html_br(1);
	}
	
	if(!empty($_POST['print_width'])) 
	{
		$print_width = $_POST['print_width'];
	}
	else
	{
		$print_width = '1024';
	}
	
	if(!empty($_POST['print_height'])) 
	{
		$print_height = $_POST['print_height'];
	}
	else
	{
		$print_height = '768';
	}

	$print_form_height[0] = '';
	$print_form_width[0] = '';
	$print_form_height[1] = '255';
	$print_form_width[1] = '369';
	$print_form_height[2] = '283';
	$print_form_width[2] = '425';
	$print_form_height[3] = '369';
	$print_form_width[3] = '510';
	
	$print_form_height[4] = '421';
	$print_form_width[4] = '298';
	$print_form_height[5] = '842';
	$print_form_width[5] = '595';
	$print_form_height[6] = '1684';
	$print_form_width[6] = '1191';
	
	$print_form_height[7] = $print_height;
	$print_form_width[7] = $print_width;

	empty($_REQUEST['print']) ? $print = 0 : $print = $_REQUEST['print'];
	$height = $print_form_height[$print];
	$width = $print_form_width[$print];

	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'headb');
	echo $cs_lang['mod'] . ' - ' . $cs_lang['print'];
	echo cs_html_roco(0);
	echo cs_html_roco(1,'leftb');
	echo $cs_lang['body_print'];
	echo cs_html_roco(0);
	echo cs_html_table(0);
	echo cs_html_br(1);

	if (isset($_POST['preview'])) 
	{
		if (empty($error)) 
		{
			if (extension_loaded('gd'))
			{
				echo cs_html_form (1,'print_now','gallery','print_now');
				echo cs_html_table(1,'forum',1);
				echo cs_html_roco(1,'centerb');
				echo cs_html_img("mods/gallery/image.php?pic=" . $pic . "&size=" . $width);
				echo cs_html_roco(0);
				
				echo cs_html_roco(1,'centerb');
				echo cs_html_link("mods/gallery/print_now.php?pic=" . $pic . "&size=" . $width,'drucken');
				echo cs_html_roco(0);
				echo cs_html_table(0);
				echo cs_html_form (0);
				echo cs_html_br(1);				
			}
			else
			{
				echo cs_html_table(1,'forum',1);
				echo cs_html_roco(1,'centerb');
				echo cs_html_img("mods/gallery/image.php?pic=" . $pic,$height,$width,'',$pic);
				echo cs_html_roco(0);
				echo cs_html_table(0);
				echo cs_html_br(1);				
			}
		}
		else
		{
			echo cs_html_table(1,'forum',1);
			echo cs_html_roco(1,'leftc');
			echo cs_icon('important');
			echo $cs_lang['error'];
			echo cs_html_roco(0);			
			echo cs_html_roco(2,'leftb');
			echo $errormsg;
			echo cs_html_roco(0);
			echo cs_html_table(0);
			echo cs_html_br(1);				
		}
	}
	
	$print_ff1 = 0;
	$print_ff2 = 0;
	$print_ff3 = 0;
	
	echo cs_html_form (1,'print','gallery','print');
	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'leftc','','',150);
	echo cs_icon('configure') . $cs_lang['print_format'];
	echo cs_html_roco(2,'leftb',0,2);
	echo cs_html_vote('print','1','radio',$print_ff1);
	echo $cs_lang['print_ff1'];
	echo cs_html_br(1);
	echo cs_html_vote('print','2','radio',$print_ff2);
	echo $cs_lang['print_ff2'];
	echo cs_html_br(1);
	echo cs_html_vote('print','3','radio',$print_ff3);
	echo $cs_lang['print_ff3'];
	echo cs_html_roco(0);

	$print_pf1 = 0;
	$print_pf2 = 0;
	$print_pf3 = 0;

	echo cs_html_roco(1,'leftc','','',150);
	echo cs_icon('configure') . $cs_lang['print_p_format'];
	echo cs_html_roco(2,'leftb',0,2);
	echo cs_html_vote('print','4','radio',$print_pf1);
	echo $cs_lang['print_pf1'];
	echo cs_html_br(1);
	echo cs_html_vote('print','5','radio',$print_pf2);
	echo $cs_lang['print_pf2'];
	echo cs_html_br(1);
	echo cs_html_vote('print','6','radio',$print_pf3);
	echo $cs_lang['print_pf3'];
	echo cs_html_roco(0);
	
	$print_vf1 = 0;
	
	echo cs_html_roco(1,'leftc','','',150);
	echo cs_icon('configure') . $cs_lang['print_v_format'];
	echo cs_html_roco(2,'leftb',0,2);
	echo cs_html_vote('print','7','radio',$print_vf1);
	echo $cs_lang['print_vf1'];
	echo cs_html_br(2);
	echo cs_html_input('print_width',$print_width,'text',4,4);
	echo ' X ';
	echo cs_html_input('print_height',$print_height,'text',4,4);
	echo ' Pixel';
	echo cs_html_roco(0);
	
	echo cs_html_roco(1,'leftc');
	echo cs_icon('ksysguard') . $cs_lang['options'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_vote('pic',$pic,'hidden');	
	echo cs_html_vote('preview',$cs_lang['preview'],'submit');
	echo cs_html_vote('reset',$cs_lang['reset'],'reset');
	echo cs_html_roco(0);
	echo cs_html_table(0);
	echo cs_html_form(0);
?>