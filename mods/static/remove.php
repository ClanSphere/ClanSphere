<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('static');

$cs_static_tpl = array();
$cs_static_tpl['head']['mod']    = $cs_lang['mod_name'];
$cs_static_tpl['head']['action']  = $cs_lang['head_remove'];
$cs_static_tpl['head']['body']  = '-';

echo cs_subtemplate(__FILE__,$cs_static_tpl,'static','action_head');

$static_form = 1;
$static_id = $_REQUEST['id'];
settype($static_id,'integer');

if(isset($_GET['agree']))
{
  $static_form = 0;
  cs_sql_delete(__FILE__,'static',$static_id);

  cs_redirect($cs_lang['del_true'], 'static');
}

if(isset($_GET['cancel']))
  cs_redirect($cs_lang['del_false'], 'static');

if(!empty($static_form))
{
  $cs_static_tpl['remove']['mode'] = 'static_remove';
  $cs_static_tpl['remove']['action'] = 'remove';
  $cs_static_tpl['remove']['id'] = $static_id;
  
  $cs_static_tpl['remove']['agree'] = cs_link($cs_lang['confirm'],'static','remove','id=' . $static_id . '&amp;agree');
  $cs_static_tpl['remove']['cancel'] = cs_link($cs_lang['cancel'],'static','remove','id=' . $static_id . '&amp;cancel');

  echo cs_subtemplate(__FILE__,$cs_static_tpl,'static','remove');
}
?>