<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('faq');

$max = 40;

$data = array();

$data['count']['faq'] = cs_sql_count(__FILE__,'faq');

$cells  = 'categories_id, categories_name';
$where = "categories_mod = 'faq' AND categories_access <= '" . $account['access_faq'] . "'";
$data['categories'] = cs_sql_select(__FILE__,'categories',$cells,$where,'categories_name',0,0);
$count_categories = count($data['categories']);

for ($run = 0; $run < $count_categories; $run++) {
  
  $data['categories'][$run]['categories_name'] = cs_secure($data['categories'][$run]['categories_name']);
  
  $cells  = 'faq_id, faq_question, faq_answer';
  $cond = 'categories_id = \'' . $data['categories'][$run]['categories_id'] . '\'';
  
  
  $data['categories'][$run]['faq'] = cs_sql_select(__FILE__,'faq',$cells,$cond,'faq_id ASC',0,0);
  
  $data['categories'][$run]['faq'] = empty($data['categories'][$run]['faq']) ? array() : $data['categories'][$run]['faq'];
  
  $count_faq = count($data['categories'][$run]['faq']);

  
  for ($run2 = 0; $run2 < $count_faq; $run2++) {
    $data['categories'][$run]['faq'][$run2]['faq_question'] = strlen($data['categories'][$run]['faq'][$run2]['faq_question']) < $max ?
      cs_secure($data['categories'][$run]['faq'][$run2]['faq_question'],1) :
      cs_substr(cs_secure($data['categories'][$run]['faq'][$run2]['faq_question']),0,$max-2) . '..';
    $data['categories'][$run]['faq'][$run2]['faq_answer'] = strlen($data['categories'][$run]['faq'][$run2]['faq_answer']) < $max ?
      cs_secure($data['categories'][$run]['faq'][$run2]['faq_answer'],1,1,1,1) :
      cs_substr(cs_secure($data['categories'][$run]['faq'][$run2]['faq_answer'],1,1,1,1),0,$max-2) . '..';
  }
  
}

echo cs_subtemplate(__FILE__,$data,'faq','list');