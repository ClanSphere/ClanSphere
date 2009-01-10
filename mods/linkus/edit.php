<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('linkus');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['head'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo $cs_lang['body_edit'];
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

$linkus_error = 2; 
$linkus_form = 1;
$linkus_id = $_REQUEST['id'];
settype($linkus_id,'integer');
$linkus_edit = cs_sql_select(__FILE__,'linkus','*',"linkus_id = '" . $linkus_id . "'"); 
$linkus_name = $linkus_edit['linkus_name']; 
$linkus_url = $linkus_edit['linkus_url'];
$linkus_banner = $linkus_edit['linkus_banner'];


if(!empty($_POST['linkus_name'])) {
	$linkus_name = $_POST['linkus_name'];
	$linkus_error--;
}
if(!empty($_POST['linkus_url'])) {
	$linkus_url = $_POST['linkus_url'];
	$linkus_error--;
}


if(isset($_POST['submit'])) {
	if(empty($linkus_error)) {
		$linkus_form = 0;
		
    $awards_cells = array('linkus_name','linkus_url');
    $awards_save = array($linkus_name,$linkus_url);
    cs_sql_update(__FILE__,'linkus',$awards_cells,$awards_save,$linkus_id);
    
		cs_redirect($cs_lang['changes_done'], 'linkus') ;
	}
	else {
		echo cs_html_table(1,'forum',1);
		echo cs_html_roco(1,'leftc');
		echo cs_icon('important');
		echo $cs_lang['error_occurred'];
		echo ' - ';
		echo cs_secure ($linkus_error).' '.$cs_lang['error_count'];
		echo cs_html_roco(0);
		echo cs_html_table(0);
		echo cs_html_br(1);
	}
}

if(!empty($linkus_form)) {

	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'leftc',0,2);
	echo cs_html_img ('uploads/linkus/' .$linkus_banner);
	echo cs_html_roco(0);
	echo cs_html_table(0);
	echo cs_html_br(1); 
	
	echo cs_html_form (1,'linkus_edit','linkus','edit',1);
        echo cs_html_table(1,'forum',1);
        echo cs_html_roco(1,'leftc');
        echo cs_icon('kivio') . $cs_lang['mass'];
        echo cs_html_roco(2,'leftb');
        $place = 'uploads/linkus/' .$linkus_banner;
        $mass = getimagesize($place);
        echo cs_secure($mass[0] .' x '. $mass[1]);
        echo cs_html_roco(0); 
	
        echo cs_html_roco(1,'leftc');
        echo cs_icon('wp') . $cs_lang['name']. ' *';
        echo cs_html_roco(2,'leftb');
        echo cs_html_input('linkus_name',$linkus_name,'text',200,50);
        echo cs_html_roco(0); 
    
        echo cs_html_form (1,'linkus_create','linkus','create',1);
        echo cs_html_roco(1,'leftc');
        echo cs_icon('gohome') . $cs_lang['url']. ' *';
        echo cs_html_roco(2,'leftb');
        echo "http://";
        echo cs_html_input('linkus_url',$linkus_url,'text',200,50);
        echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo cs_icon('ksysguard') . $cs_lang['options'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_vote('id',$linkus_id,'hidden');
	echo cs_html_vote('submit',$cs_lang['edit'],'submit');
	echo cs_html_vote('reset',$cs_lang['reset'],'reset');
	echo cs_html_roco(0);
	echo cs_html_table(0);
	echo cs_html_form (0);
}

?>
