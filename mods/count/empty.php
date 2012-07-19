<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('count');

$data = array();
$count_form = 1;

if(isset($_POST['agree'])) {
  
  $count_form = 0;
  cs_sql_query(__FILE__, 'TRUNCATE {pre}_count');  
  $file = 'empty_1';
}

if(isset($_POST['cancel'])) {
  $count_form = 0;
  $file = 'empty_2';
}

if(!empty($count_form)) $file = 'empty';


echo cs_subtemplate(__FILE__,$data,'count',$file);