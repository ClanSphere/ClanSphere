<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

function cs_manage($mod, $action, $def_mod, $def_action, $merge = array(), $head = array()) {

  global $account, $cs_lang;
  $merge = is_array($merge) ? $merge : array();
  $show = $mod . '/' . $action;
  if (empty($head['message'])) $head['message'] = '';
  $data = array('head' => $head);

  $options = array('info' => 0, 'size' => 48 , 'theme' => '');
  $options['theme'] = empty($account['users_view']) ? 'manage' : 'manage_' . $account['users_view'];

  if($account['users_view'] == 'list') {
    $options['info'] = 1;
    $options['size'] = 16;
  }

  $mod_array = cs_checkdirs('mods', $show);
  $content = array_merge($merge, $mod_array);
  ksort($content);

  $data['head']['total'] = 0;
  $run = 1;
  $loop = 0;

  foreach($content as $mod) {
    if(!array_key_exists('dir',$mod)) $mod['dir'] = $def_mod;
    if(!array_key_exists('file',$mod)) $mod['file'] = $def_action;
    $acc_dir = 'access_' . $mod['dir'];
    if(array_key_exists($acc_dir,$account) AND $account[$acc_dir] >= $mod['show'][$show]) {
      $cs_lap = cs_icon($mod['icon'],$options['size'],0,0);
      $data['content'][$loop]['img_' . $run] = $cs_lap;
      $data['content'][$loop]['txt_' . $run] = $mod['name'];
      $data['content'][$loop]['link_' . $run] = cs_url($mod['dir'],$mod['file']);
      $data['head']['total']++;
      $run++;
      if($run == $options['lines']) {
        $run = 1;
        $loop++;
      }
    }
  }

  if($run > 1) {
    while($run != 5) {
      $data['content'][$loop]['img_' . $run] = '';
      $data['content'][$loop]['txt_' . $run] = '';
      $data['content'][$loop]['link_' . $run] = '';
      $run++;
    }
  }

  return cs_subtemplate(__FILE__,$data,'clansphere',$options['theme']);  
}

?>