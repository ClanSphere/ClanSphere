<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_admin_menu() {

  global $cs_main, $account;

  $cs_lang = cs_translate('clansphere');

  $data = array();

  $recent_mod = $cs_main['mod'];
  $recent_action = $cs_main['action'];

  $link_count = 0;

  if (file_exists('mods/' . $recent_mod . '/manage.php') && $account['access_' . $recent_mod] >= 3)
  {
    include $cs_main['def_path'] . '/mods/' . $recent_mod . '/info.php';

    # look for sql table named like mod, else use first sql table given
    $mod_tables = is_array($mod_info['tables']) ? $mod_info['tables'] : array();
    if(in_array($recent_mod, $mod_tables))
      $sql_table = $recent_mod;
    elseif(isset($mod_tables[0]))
      $sql_table = $mod_tables[0];
    else
      $sql_table = false;

    $sql_count = empty($sql_table) ? '' : ' (' . cs_sql_count(__FILE__, $sql_table) . ')';

    $link_count++;  
    $data['menu']['manage'] = $recent_action == 'manage' ? $cs_lang['manage'] : cs_link($cs_lang['manage'], $recent_mod,'manage') . $sql_count;  
    $data['if']['manage'] = true;
  }
  else
  {
    $data['menu']['manage'] = '';
    $data['if']['manage'] = false;
  }

  if (file_exists('mods/' . $recent_mod . '/create.php') && $account['access_' . $recent_mod] >= 3 && $recent_mod != 'shoutbox')
  {
    $link_count++;  
    $data['menu']['create'] = $recent_action == 'create' ? $cs_lang['create'] : cs_link($cs_lang['create'], $recent_mod,'create');
    $data['if']['create'] = true;  
  }
  else
  {
    $data['menu']['create'] = '';
    $data['if']['create'] = false;
  }

  if (file_exists('mods/' . $recent_mod . '/options.php') && $account['access_' . $recent_mod] >= 5)
  {
    $link_count++;  
    $data['menu']['options'] = $recent_action == 'options' ? $cs_lang['options'] : cs_link($cs_lang['options'], $recent_mod,'options');
    $data['if']['options'] = true;
  }
  else
  {
    $data['menu']['options'] = '';
    $data['if']['options'] = false;
  }

  if ($link_count > 1)
  {
    $data['links']['count'] = $link_count;
    return cs_subtemplate(__FILE__,$data,'clansphere','admin_menu');
  }
}