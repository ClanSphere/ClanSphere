<?php 
// ClanSphere 2010 - www.clansphere.net  
// $Id$

$cs_lang = cs_translate('shoutbox');

require 'mods/shoutbox/access.php';

$captcha = extension_loaded('gd') ? 1 : 0;
  
$shoutbox_count = cs_sql_count(__FILE__,'shoutbox');
$shoutbox_options = cs_sql_option(__FILE__,'shoutbox');

$data = array();

$data['shoutbox'] = '';

$min = 0;

if ($shoutbox_options['order'] == 'ASC') {
  $order = 'shoutbox_date ASC';
  
  if ($shoutbox_count > $shoutbox_options['limit']) {
    $min = $shoutbox_count - $shoutbox_options['limit'];
  }
}
else
  $order = 'shoutbox_date DESC';
  
$cells = 'shoutbox_name, shoutbox_text, shoutbox_date';
$data['shoutbox'] = cs_sql_select(__FILE__,'shoutbox',$cells,0,$order,$min,$shoutbox_options['limit']);

$pattern = "=([^\s*?]{".$shoutbox_options['linebreak']."})(?![^<]+>|[^&]*;)=";
$count_shoutbox = count($data['shoutbox']);

for($i = 0; $i < $count_shoutbox; $i++) {
  $temp = preg_replace($pattern,"\\0 ",$data['shoutbox'][$i]['shoutbox_text']);
  $data['shoutbox'][$i]['shoutbox_text'] = cs_secure($temp,0,1,0);
  $data['shoutbox'][$i]['shoutbox_name'] = cs_secure($data['shoutbox'][$i]['shoutbox_name'],0,0,0);
  $data['shoutbox'][$i]['shoutbox_date'] = cs_date('unix',$data['shoutbox'][$i]['shoutbox_date'],1);
}

$data['url']['archieve'] = cs_url('shoutbox','list');

$data['if']['form'] = $account['access_shoutbox'] >= $axx_file['create'];

if($data['if']['form'] === TRUE) {
  $data['form']['url'] = cs_url('shoutbox','create');
  $data['form']['nick'] = empty($account['users_nick']) ? 'Nick' : cs_secure($account['users_nick']);
   
  $data['if']['captcha'] = FALSE;
  if(!empty($captcha) && empty($account['users_id'])) {
    $data['if']['captcha'] = TRUE;
    $data['captcha']['img'] = cs_html_img('mods/captcha/generate.php?time=' . cs_time() . '&mini');
  }
  
  $data['form']['uri'] = cs_url_self();
}

echo cs_subtemplate(__FILE__,$data,'shoutbox','navlist');