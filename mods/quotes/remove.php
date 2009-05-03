<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('quotes');

$quotes_id = $_REQUEST['id'];

$data['head']['mod'] = $cs_lang['mod_name'];
$data['head']['action'] = $cs_lang['remove'];
$data['quotes']['id'] = $quotes_id;


if(isset($_POST['agree'])) {
  $quotes_form = 0;
  
  cs_sql_delete(__FILE__,'quotes',$quotes_id);
  $query = "DELETE FROM {pre}_comments WHERE comments_mod='quotes' AND ";
  $query .= "comments_fid='" . $quotes_id . "'";
  cs_sql_query(__FILE__,$query);
  
  cs_redirect($cs_lang['del_true'], 'quotes');
}

elseif(isset($_POST['cancel'])) 
  cs_redirect($cs_lang['del_false'], 'quotes');

else {

  $data['head']['body'] = sprintf($cs_lang['rly_remove'],$quotes_id);
  $data['lang']['confirm'] = $cs_lang['confirm'];
  $data['lang']['cancel'] = $cs_lang['cancel'];
  echo cs_subtemplate(__FILE__,$data,'quotes','remove');
}
