<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('categories');
$cs_get = cs_get('id');
$data = array();

$categories_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

$data['if']['allow_agree'] = TRUE;

$select = 'categories_picture, categories_mod';
$where = "categories_id = '" . $categories_id . "'";
$cs_category = cs_sql_select(__FILE__,'categories',$select,$where,0,0,1);

if(isset($_GET['agree'])) {
  
  if(!empty($cs_category['categories_picture'])) {
    cs_unlink('categories',$cs_category['categories_picture']);
  }
  cs_sql_delete(__FILE__,'categories',$categories_id);  

  cs_redirect($cs_lang['del_true'],'categories','manage','where=' . $cs_category['categories_mod']);
}

if(isset($_GET['cancel']))
  cs_redirect($cs_lang['del_false'],'categories','manage','where=' . $cs_category['categories_mod']);

else {

    $count_use = cs_sql_count(__FILE__,$cs_category['categories_mod'],$where);

  if(empty($count_use)) {
    $data['head']['body'] = sprintf($cs_lang['del_rly'],$categories_id);
    $data['url']['agree'] = cs_url('categories','remove','id=' . $categories_id . '&amp;agree');     
  } else {
    $data['if']['allow_agree'] = FALSE;
    $data['head']['body'] = sprintf($cs_lang['del_no'],$count_use);  
  }
  $data['url']['cancel'] = cs_url('categories','remove','id=' . $categories_id . '&amp;cancel');

  echo cs_subtemplate(__FILE__,$data,'categories','remove');
}
              
?>
