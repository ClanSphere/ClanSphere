<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cash');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_edit'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo $cs_lang['body_edit'];
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

$cash_error = 5; 
$cash_form = 1;
$cash_id = $_REQUEST['id'];
settype($cash_id,'integer');

$cash_edit = cs_sql_select(__FILE__,'cash','*',"cash_id = '" . $cash_id . "'"); 
$cash_money = $cash_edit['cash_money']; 
$cash_info = $cash_edit['cash_info'];
$cash_text = $cash_edit['cash_text'];
$cash_inout = $cash_edit['cash_inout'];

if(empty($_POST['datum_month']) OR empty($_POST['datum_day']) OR empty($_POST['datum_year'])) {
    $cash_time = $cash_edit['cash_time'];
  }
  else {
    $cash_time = $_POST['datum_year'] . '-' . $_POST['datum_month'];
    $cash_time .= '-' .   $_POST['datum_day'];
    $cash_error--;
}
  
if(!empty($_POST['cash_inout'])) {
	$cash_inout = $_POST['cash_inout'];
	$cash_error--;
}
if(!empty($_POST['cash_money'])) {
	$cash_money = $_POST['cash_money'];
	$cash_error--;
}
if(!empty($_POST['cash_info'])) {
	$cash_info = $_POST['cash_info'];
	$cash_error--;
}

if(!empty($_POST['cash_text'])) {
	$cash_text = $_POST['cash_text'];
	$cash_error--;
}

if(isset($_POST['submit'])) {
	if(empty($cash_error)) {
		$cash_form = 0;
		
    $cash_cells = array('cash_text','cash_time','cash_info','cash_money','cash_inout');
    $cash_save = array($cash_text,$cash_time,$cash_info,$cash_money,$cash_inout);
    cs_sql_update(__FILE__,'cash',$cash_cells,$cash_save,$cash_id);
    
		cs_redirect($cs_lang['changes_done'], 'cash') ;
	}
	else {
		echo cs_html_table(1,'forum',1);
		echo cs_html_roco(1,'leftc');
		echo cs_icon('important');
		echo $cs_lang['error_occurred'];
		echo ' - ';
		echo cs_secure ($cash_error).' '.$cs_lang['error_count'];
		echo cs_html_roco(0);
		echo cs_html_table(0);
		echo cs_html_br(1);
	}
}

if(isset($_POST['preview'])) {
	if(empty($cash_error)) {
 
		echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,3);
echo $cs_lang['mod'] . ' - ' . $cs_lang['head'];
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('money') .$cs_lang['money'];
echo cs_html_roco(2,'leftb',0,2);
echo cs_secure ($cash_money .' '. $cs_lang['euro']);
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('kate') .$cs_lang['for'];
echo cs_html_roco(2,'leftb',0,2);
echo cs_secure($cash_text); 
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('folder_yellow') .$cs_lang['inout'];
echo cs_html_roco(2,'leftb',0,2);
$inout = $cash_inout;
echo cs_secure ($cs_lang[$inout]); 
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('1day') .$cs_lang['date'];
echo cs_html_roco(2,'leftb',0,2);
echo cs_date('date',$cash_time);
echo cs_html_roco(0);

echo cs_html_roco(1,'headb',0,2);
echo $cs_lang['info']; 
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc',0,2);
echo cs_secure($cash_info,1,1);
echo cs_html_roco(0);

echo cs_html_table(0);
		echo cs_html_br(2);
	}
else {
		echo cs_html_table(1,'forum',1);
		echo cs_html_roco(1,'leftc');
		echo cs_icon('important');
		echo $cs_lang['error_occurred'];
		echo ' - ';
		echo cs_secure ($cash_error).' '.$cs_lang['error_count'];
		echo cs_html_roco(0);
		echo cs_html_table(0);
		echo cs_html_br(1);
	}
}

if(!empty($cash_form)) {

	echo cs_html_form (1,'cash_create','cash','edit');
	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'leftc');
	echo cs_icon('money') . $cs_lang['money']. ' *';
	echo cs_html_roco(2,'leftb');
	echo cs_html_input('cash_money',$cash_money,'text',14,10);
	echo ' '. $cs_lang['euro'];
	echo cs_html_roco(0);
        
        echo cs_html_roco(1,'leftc');
	echo cs_icon('folder_yellow') . $cs_lang['inout']. ' *'; 
	echo cs_html_roco(2,'leftb');
	$inoutlist[0]['cash_inout'] = 'in';
        $inoutlist[0]['name'] = $cs_lang['drop_in'];
        $inoutlist[1]['cash_inout'] = 'out';
        $inoutlist[1]['name'] = $cs_lang['drop_out'];
	echo cs_dropdown('cash_inout','name',$inoutlist,$cash_inout);
	echo cs_html_select(0);
        
        echo cs_html_roco(1,'leftc');
	echo cs_icon('1day') . $cs_lang['date']. ' *';
	echo cs_html_roco(2,'leftb');
	echo cs_dateselect('datum','date',$cash_time);
	echo cs_html_roco(0);
	
	echo cs_html_roco(1,'leftc');
	echo cs_icon('kedit') . $cs_lang['for']. ' *';
	echo cs_html_roco(2,'leftb');
	echo cs_html_input('cash_text',$cash_text,'text',200,50);
	echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo cs_icon('kate') . $cs_lang['info']. ' *';
        echo cs_html_br(2);
        echo cs_abcode_smileys('cash_info');
	echo cs_html_roco(2,'leftb');
        echo cs_abcode_features('cash_info');
	echo cs_html_textarea('cash_info',$cash_info,'50','20');
	echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo cs_icon('ksysguard') . $cs_lang['options'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_vote('id',$cash_id,'hidden');
	echo cs_html_vote('submit',$cs_lang['edit'],'submit');
	echo cs_html_vote('preview',$cs_lang['preview'],'submit');
	echo cs_html_vote('reset',$cs_lang['reset'],'reset');
	echo cs_html_roco(0);
	echo cs_html_table(0);
	echo cs_html_form (0);
}

?>
