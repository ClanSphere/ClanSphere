<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('comments');
$cs_get = cs_get('id,agree,cancel');

$cols = 'comments_mod, comments_text';
$cs_com = cs_sql_select(__FILE__,'comments',$cols,'comments_id = ' . $cs_get['id'],0,0);

$text = cs_substr($cs_com['comments_text'],0,15);

if(isset($cs_get['agree'])) {
  cs_sql_delete(__FILE__,'comments',$cs_get['id']);

  cs_redirect($cs_lang['del_true'],'comments','manage','where=' . $cs_com['comments_mod']);
}

if(isset($cs_get['cancel'])) {

  cs_redirect($cs_lang['del_false'],'comments','manage','where=' . $cs_com['comments_mod']);
}

if(!empty($cs_com)) {
  $data = array();
  $data['head']['body'] = sprintf($cs_lang['remove_entry'],$cs_lang['mod_remove'],$text);
  $data['url']['agree'] = cs_url('comments','remove','id=' . $cs_get['id'] . '&amp;agree');
  $data['url']['cancel'] = cs_url('comments','remove','id=' . $cs_get['id'] . '&amp;cancel');

  echo cs_subtemplate(__FILE__,$data,'comments','remove');
}
else {
  cs_redirect($cs_lang['del_false'],'comments','manage','where=' . $cs_com['comments_mod']);
}