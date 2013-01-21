<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('banners');
$cs_get = cs_get('id');
$cs_post = cs_post('id');
$banners_id = empty($cs_get['id']) ? $cs_post['id'] : $cs_get['id'];

if(isset($cs_post['agree'])) {
  $where = 'banners_id = ' . $banners_id;
  $getpic = cs_sql_select(__FILE__,'banners','banners_picture',$where);

  if(file_exists($getpic['banners_picture'])) {
    unlink($getpic['banners_picture']);
  }
  cs_sql_delete(__FILE__,'banners',$banners_id);
  cs_redirect($cs_lang['del_true'], 'banners');
}

if(isset($cs_post['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'banners');
}

$banner = cs_sql_select(__FILE__,'banners','banners_name','banners_id = ' . $banners_id,0,0,1);
if(!empty($banner)) {
  $data['lang']['body'] = sprintf($cs_lang['remove_entry'],$cs_lang['mod_name'],$banner['banners_name']);
  $data['action']['form'] = cs_url('banners','remove');
  $data['data']['id'] = $banners_id;
  echo cs_subtemplate(__FILE__,$data,'banners','remove');
}
else {
  cs_redirect('','banners');
}
