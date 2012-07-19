<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');
$cs_get = cs_get('id');
$data = array();

$watermark_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
$select = 'categories_picture, categories_name';
$watermark = cs_sql_select(__FILE__,'categories',$select,"categories_id = '" . $watermark_id . "'");

if(isset($_GET['agree'])) {

  if(!empty($watermark['categories_picture'])) {
   cs_unlink('categories', $watermark['categories_picture']);
  }
 cs_sql_delete(__FILE__,'categories',$watermark_id);  

 cs_redirect($cs_lang['del_true'],'gallery','wat_manage');
}

if(isset($_GET['cancel']))
 cs_redirect($cs_lang['del_false'],'gallery','wat_manage');

else {

  $data['head']['body'] = sprintf($cs_lang['del_rly'],$watermark_id);
  $data['url']['agree'] = cs_url('gallery','wat_remove','id=' . $watermark_id . '&amp;agree');
  $data['url']['cancel'] = cs_url('gallery','wat_remove','id=' . $watermark_id . '&amp;cancel');
  
 echo cs_subtemplate(__FILE__,$data,'gallery','wat_remove');
}