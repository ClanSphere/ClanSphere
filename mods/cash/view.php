<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cash');

$cs_cash_id = $_GET['id'];
settype($cs_cash_id,'integer');
$cs_cash = cs_sql_select(__FILE__,'cash','*',"cash_id = '" . $cs_cash_id . "'");

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,3);
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_view'];
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('money') .$cs_lang['money'];
echo cs_html_roco(2,'leftb',0,2);
echo cs_secure ($cs_cash['cash_money'] .' '. $cs_lang['euro']);
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('kate') .$cs_lang['for'];
echo cs_html_roco(2,'leftb',0,2);
echo cs_secure($cs_cash['cash_text']); 
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('folder_yellow') .$cs_lang['inout'];
echo cs_html_roco(2,'leftb',0,2);
$inout = $cs_cash['cash_inout'];
echo cs_secure ($cs_lang[$inout]); 
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('1day') .$cs_lang['date'];
echo cs_html_roco(2,'leftb',0,2);
echo cs_date('date',$cs_cash['cash_time']);
echo cs_html_roco(0);

echo cs_html_roco(1,'headb',0,2);
echo $cs_lang['info']; 
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc',0,2);
echo cs_secure($cs_cash['cash_info'],1,1);
echo cs_html_roco(0);
echo cs_html_table(0);

?>
