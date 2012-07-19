<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_manage($mod, $action, $def_mod, $def_action, $merge = array(), $head = array()) {

  global $account, $cs_lang;
  $merge = is_array($merge) ? $merge : array();
  $show = $mod . '/' . $action;
  if (empty($head['message'])) $head['message'] = '';
  $data = array('head' => $head);
  $data['content'] = array();

  $options = array('info' => 0, 'size' => 48 , 'theme' => '');
  $options['theme'] = empty($account['users_view']) ? 'manage' : 'manage_' . $account['users_view'];

  if($account['users_view'] == 'list') {
    $options['size'] = 16;
    if($show == 'clansphere/admin') {
      $options['theme'] = 'manage_admin';
      $options['info']  = 1;
    }
  }

  $mod_array = cs_checkdirs('mods', $show);
  $content = array_merge($merge, $mod_array);
  ksort($content);

  $loop = 0;
  foreach($content as $mod) {

    if(!array_key_exists('dir',$mod)) $mod['dir'] = $def_mod;
    if(!array_key_exists('file',$mod)) $mod['file'] = $def_action;
    $acc_dir = 'access_' . $mod['dir'];
    if(array_key_exists($acc_dir,$account) AND $account[$acc_dir] >= $mod['show'][$show]) {
      $cs_lap = cs_icon($mod['icon'],$options['size'],0,0);
      $data['content'][$loop]['img_1'] = $cs_lap;
      $data['content'][$loop]['txt_1'] = $mod['name'];
      $data['content'][$loop]['link_1'] = cs_url($mod['dir'],$mod['file']);

      if(!empty($options['info'])) {

        if(file_exists('mods/' . $mod['dir'] . '/create.php'))
        $data['content'][$loop]['create_1'] = cs_link(cs_icon('editpaste',16,$cs_lang['create']),$mod['dir'],'create');
        else
        $data['content'][$loop]['create_1'] = '';
        if(file_exists('mods/' . $mod['dir'] . '/manage.php'))
        $data['content'][$loop]['manage_1'] = cs_link(cs_icon('kfm',16,$cs_lang['manage']),$mod['dir'],'manage');
        else
        $data['content'][$loop]['manage_1'] = '';
        if(file_exists('mods/' . $mod['dir'] . '/options.php'))
        $data['content'][$loop]['options_1'] = cs_link(cs_icon('package_settings',16,$cs_lang['options']),$mod['dir'],'options');
        else
        $data['content'][$loop]['options_1'] = '';
      }
      $loop++;
    }
  }

  $data['head']['total'] = $loop;

  return cs_subtemplate(__FILE__,$data,'clansphere',$options['theme']);
}