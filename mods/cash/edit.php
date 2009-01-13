<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cash');
$cs_post = cs_post('id');
$cs_get = cs_get('id');
$data = array();

$cash_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $cash_id = $cs_post['id'];

if(isset($_POST['submit'])) {
	
	$cs_cash['cash_inout'] = $_POST['cash_inout'];
	$cs_cash['cash_money'] = $_POST['cash_money'];
	$cs_cash['cash_text'] = $_POST['cash_text'];
	$cs_cash['cash_info'] = $_POST['cash_info'];
	$cs_cash['cash_time'] = cs_datepost('datum','date');
	
	$error = '';
	
	if(empty($cs_cash['cash_inout'])) {
		$error .= $cs_lang['no_inout'] . cs_html_br(1);
	}
	if(empty($cs_cash['cash_money'])) {
		$error .= $cs_lang['no_money'] . cs_html_br(1);
	}
	if(empty($cs_cash['cash_text'])) {
		$error .= $cs_lang['no_text'] . cs_html_br(1);
	}
	if(empty($cs_cash['cash_time'])) {
		$error .= $cs_lang['no_date'] . cs_html_br(1);
	}
	
}
else {

  $select = 'cash_id, cash_inout, cash_money, cash_time, cash_text, cash_info';
  $cs_cash = cs_sql_select(__FILE__,'cash',$select,"cash_id = '" . $cash_id . "'",0,0,1);
  
}

if(!isset($_POST['submit']) AND empty($error)) {
	$data['head']['body'] = $cs_lang['body_info'];
} elseif (!empty($error)) {
	$data['head']['body'] = $error;
}

if(!empty($error) OR !isset($_POST['submit'])) {
	
	$data['cash'] = $cs_cash;

	$inoutlist[0]['cash_inout'] = 'in';
	$inoutlist[0]['name'] = $cs_lang['drop_in'];
	$inoutlist[1]['cash_inout'] = 'out';
	$inoutlist[1]['name'] = $cs_lang['drop_out'];
	$data['cash']['inout_sel'] = cs_dropdown('cash_inout','name',$inoutlist,$cs_cash['cash_inout']);

	$data['cash']['date_sel'] = cs_dateselect('datum','date',$cs_cash['cash_time'],2000);

 	$data['cash']['abcode_smileys'] = cs_abcode_smileys('cash_info');
 	$data['cash']['abcode_features'] = cs_abcode_features('cash_info');

	$data['cash']['id'] = $cash_id;


  echo cs_subtemplate(__FILE__,$data,'cash','edit');
}
else {
	
	$cash_cells = array_keys($cs_cash);
	$cash_save = array_values($cs_cash);
  cs_sql_update(__FILE__,'cash',$cash_cells,$cash_save,$cash_id);

  cs_redirect($cs_lang['changes_done'],'cash');
}

?>