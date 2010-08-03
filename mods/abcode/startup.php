<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

global $cs_main;

$op_abcode = cs_sql_option(__FILE__, 'abcode');

$cs_main['rte_html'] = $op_abcode['rte_html'];
$cs_main['rte_more'] = $op_abcode['rte_more'];

if(!empty($op_abcode['rte_html']))
  include_once 'mods/' . $op_abcode['rte_html'] . '/rte_init.php';

if(!empty($op_abcode['rte_more']) AND $op_abcode['rte_more'] != $op_abcode['rte_html'])
  include_once 'mods/' . $op_abcode['rte_more'] . '/rte_init.php';