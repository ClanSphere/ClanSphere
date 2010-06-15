<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('abcode');

$abcode_form = 1;
$abcode_id = $_REQUEST['id'];
settype($abcode_id,'integer');

if(isset($_POST['agree'])) {
  $abcode_form = 0;
  $where = "abcode_id = '" . $abcode_id . "'";
  $getpic = cs_sql_select(__FILE__,'abcode','abcode_file',$where);

  if(!empty($getpic['abcode_file']))
    cs_unlink('abcode', $getpic['abcode_file']);

  cs_sql_delete(__FILE__,'abcode',$abcode_id);

  cs_unlink('cache', 'abcode_smileys.tmp');
  cs_unlink('cache', 'abcode_content.tmp');

  cs_redirect($cs_lang['del_true'], 'abcode');
}

if(isset($_POST['cancel'])) {
  $abcode_form = 0;
  cs_redirect($cs_lang['del_false'], 'abcode');
}

if(!empty($abcode_form)) {
  $data['lang']['body'] = sprintf($cs_lang['del_rly'],$abcode_id);
  $data['action']['form'] = cs_url('abcode','remove');
  $data['abcode']['id'] = $abcode_id;

  echo cs_subtemplate(__FILE__,$data,'abcode','remove');
}