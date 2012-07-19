<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('faq');

$data = array();

$categories_id = $_GET['id'];
settype($categories_id,'integer');
$where = "categories_mod = 'faq' AND categories_id = '" . $categories_id . "' AND categories_access <= '" . $account['access_faq'] . "'";
$categories_data = cs_sql_select(__FILE__,'categories','*',$where,'categories_name',0,0);
$categories_loop = count($categories_data);

if(!empty($categories_loop)) {
  for($run=0; $run<$categories_loop; $run++) {
    $data['cat'][$run]['name'] = cs_secure($categories_data[$run]['categories_name']);
    $data['cat'][$run]['text'] = cs_secure($categories_data[$run]['categories_text']);
    $data['if']['cat_text'] = empty($categories_data[$run]['categories_text']) ? false : true;
  }

  $cs_faq_cat1 = cs_sql_select(__FILE__,'faq','*',"categories_id = '" . $categories_id . "'",'categories_id DESC',0,0);
  $faq_loop1 = count($cs_faq_cat1);

  $data['faq'] = array();
  for($run=0; $run<$faq_loop1; $run++) {
    $data['faq'][$run]['num'] = cs_secure($run + 1);
    $data['faq'][$run]['question'] = cs_secure($cs_faq_cat1[$run]['faq_question']);
    $data['faq'][$run]['answer'] = cs_secure($cs_faq_cat1[$run]['faq_answer'],1,1,1,1);
  }
  echo cs_subtemplate(__FILE__,$data,'faq','view');
} else {
  $data['head']['mod'] = $cs_lang['mod_name'];
  $data['head']['action'] = $cs_lang['cat'];
  $data['head']['icon'] = cs_icon('error',48);
  $cs_lang_error = cs_translate('errors');
  $data['head']['topline'] = $cs_lang_error['403_body'];
  echo cs_subtemplate(__FILE__,$data,'errors','403');
}