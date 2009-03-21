<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$
$cs_lang = cs_translate('converter');
$data = array();

$data['data']['display'] = 'none';

// CMS Auswahl
$mods = cs_checkdirs('mods');
$run=0;
foreach($mods as $cms) {
  if(!empty($cms['cms'])) {
    for($run=0; $run<count($cms['cms']); $run++) {
      $data['cms'][$run]['dir'] = $cms['cms'][$run]['dir'];
      $data['cms'][$run]['name'] = $cms['cms'][$run]['name'];
    }
  }
}
if(isset($_POST['submit'])) {
  if(!empty($_POST['cms'])) {
    cs_redirect('','converter','convert','cms=' . $_POST['cms']);
  } else {
    $data['data']['display'] = 'block';
  }
}
echo cs_subtemplate(__FILE__,$data,'converter','list');
?>