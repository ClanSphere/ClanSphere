<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanpartys');

$lanpartys_form = 1;
$lanpartys_id = $_REQUEST['id'];
settype($lanpartys_id,'integer');

if(isset($_GET['agree'])) {
  $lanpartys_form = 0;
  cs_sql_delete(__FILE__,'lanpartys',$lanpartys_id);

 cs_redirect($cs_lang['del_true'], 'lanpartys');
}

if(isset($_GET['cancel'])) 
  	cs_redirect($cs_lang['del_false'], 'lanpartys');

if(!empty($lanpartys_form)) {
  $data['lang']['remove'] = $cs_lang['head_remove']; 
  $data['lang']['body'] = sprintf($cs_lang['del_rly'],$lanpartys_id);
  
  $data['lang']['content'] = cs_link($cs_lang['confirm'],'lanpartys','remove','id=' . $lanpartys_id . '&amp;agree');
  $data['lang']['content'] .= ' - ';
  $data['lang']['content'] .= cs_link($cs_lang['cancel'],'lanpartys','remove','id=' . $lanpartys_id . '&amp;cancel');
	
  echo cs_subtemplate(__FILE__,$data,'lanpartys','remove');
}
?>
