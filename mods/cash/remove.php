<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cash');
$cs_get = cs_get('id');
$data = array();
$cash_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
$form = 1;

if(isset($_GET['agree'])) {
  $form = 0;
  cs_sql_delete(__FILE__,'cash',$cash_id);
  cs_redirect($cs_lang['del_true'],'cash');
}

if(isset($_GET['cancel'])) {
  cs_redirect($cs_lang['del_false'],'cash');
}

if(!empty($form)) {
  $cash = cs_sql_select(__FILE__,'cash','cash_text','cash_id = ' . $cash_id);
  if(!empty($cash)) {
    $data['head']['body'] = sprintf($cs_lang['remove_entry'],$cs_lang['mod_remove'],$cash['cash_text']);
    $data['url']['agree'] = cs_url('cash','remove','id=' . $cash_id . '&amp;agree');
    $data['url']['cancel'] = cs_url('cash','remove','id=' . $cash_id . '&amp;cancel');
    echo cs_subtemplate(__FILE__,$data,'cash','remove');
  }
  else {
    cs_redirect('','cash');
  }
}