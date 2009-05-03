<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('banners');

$banners_form = 1;
$banners_id = $_REQUEST['id'];
settype($banners_id,'integer');

if(isset($_POST['agree'])) {
  $banners_form = 0;
  $where = "banners_id = '" . $banners_id . "'";
  $getpic = cs_sql_select(__FILE__,'banners','banners_picture',$where);
  
  if(file_exists($getpic['banners_picture'])) {
    unlink($getpic['banners_picture']);
  }
  
  cs_sql_delete(__FILE__,'banners',$banners_id);
  
  cs_redirect($cs_lang['del_true'], 'banners');
}

if(isset($_POST['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'banners');
}

if(!empty($banners_form)) {
  $data['lang']['body'] = sprintf($cs_lang['del_rly'],$banners_id);
  $data['action']['form'] = cs_url('banners','remove');
  $data['data']['id'] = $banners_id;
  
  echo cs_subtemplate(__FILE__,$data,'banners','remove');
}