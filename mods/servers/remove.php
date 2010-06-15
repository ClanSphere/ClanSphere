<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('servers');
$cs_post = cs_post('id');
$cs_get = cs_get('id');

$servers_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $servers_id = $cs_post['id'];


if(isset($_POST['agree'])) {

 cs_sql_delete(__FILE__,'servers',$servers_id);
 cs_redirect($cs_lang['del_true'], 'servers');
}

if(isset($_POST['cancel']))
 cs_redirect($cs_lang['del_false'], 'servers');

else {

  $data['head']['body'] = sprintf($cs_lang['del_rly'],$servers_id);
  $data['servers']['id'] = $servers_id;

 echo cs_subtemplate(__FILE__,$data,'servers','remove');
}
