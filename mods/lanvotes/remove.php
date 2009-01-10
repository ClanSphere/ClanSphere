<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanvotes');

$lanvotes_form = 1;
$lanvotes_id = $_REQUEST['id'];
settype($lanvotes_id,'integer');

if(isset($_GET['agree'])) {
  $lanvotes_form = 0;
  
  cs_sql_delete(__FILE__,'lanvoted',$lanvotes_id,'lanvotes_id');
  cs_sql_delete(__FILE__,'lanvotes',$lanvotes_id);
	
  cs_redirect($cs_lang['del_true'],'lanvotes','manage');
}

if(isset($_GET['cancel'])) {
  $lanvotes_form = 0;

  cs_redirect($cs_lang['del_false'],'lanvotes','manage');
}

if(!empty($lanvotes_form)) {
  $data['lang']['body'] = sprintf($cs_lang['del_rly'],$lanvotes_id);
  
  $data['lang']['content'] = cs_link($cs_lang['confirm'],'lanvotes','remove','id=' . $lanvotes_id . '&amp;agree');
  $data['lang']['content'] .= ' - ';
  $data['lang']['content'] .= cs_link($cs_lang['cancel'],'lanvotes','remove','id=' . $lanvotes_id . '&amp;cancel');
	
  echo cs_subtemplate(__FILE__,$data,'lanvotes','remove');
}
?>
