<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('abcode');

$abcode_form = 1;
$cs_get = cs_get('id');
$cs_post = cs_post('id');
$abcode_id = empty($cs_get['id']) ? $cs_post['id'] : $cs_get['id'];

if(isset($_POST['agree'])) {
  $abcode_form = 0;
  $where = 'abcode_id = ' . $abcode_id;
  $getpic = cs_sql_select(__FILE__,'abcode','abcode_file',$where);

  if(!empty($getpic['abcode_file'])) {
    cs_unlink('abcode', $getpic['abcode_file']);
  }

  cs_sql_delete(__FILE__,'abcode',$abcode_id);

  cs_cache_delete('abcode_smileys');
  cs_cache_delete('abcode_content');

  cs_redirect($cs_lang['del_true'], 'abcode');
}

if(isset($_POST['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'abcode');
}

if(!empty($abcode_form)) {
  $abcode = cs_sql_select(__FILE__,'abcode','abcode_func, abcode_pattern','abcode_id = ' . $abcode_id,0,0,1);
  if(!empty($abcode)) {
    $data['lang']['body'] = sprintf($cs_lang['remove_entry'],$cs_lang['mod_name'],$abcode['abcode_pattern']);
    $data['action']['form'] = cs_url('abcode','remove');
    $data['abcode']['id'] = $abcode_id;
    echo cs_subtemplate(__FILE__,$data,'abcode','remove');
  }
  else {
    cs_redirect('','abcode');
  }
}