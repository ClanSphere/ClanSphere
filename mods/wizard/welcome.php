<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('wizard');

$turn = (isset($_GET['turn']) AND $_GET['turn'] == 'off') ? 0 : 1;
$opt_where = "options_mod = 'wizard' AND options_name = ";
$def_cell = array('options_value');
$def_cont = array($turn);
cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'welcome'");

cs_cache_delete('op_wizard');

cs_redirect(empty($turn) ? $cs_lang['turn_off'] : $cs_lang['turn_on'],'users','home');