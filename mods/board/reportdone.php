<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

$report_id = $_GET['id'];

$report_cells = array('boardreport_done');
$report_save = array(1);
cs_sql_update(__FILE__,'boardreport',$report_cells,$report_save,$report_id);

cs_redirect($cs_lang['done_true'],'board','reportlist');