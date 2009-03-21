<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('templates');

$templates = cs_checkdirs('templates');
$tpl_all = count($templates);

$activate = isset($_GET['activate']) ? $_GET['activate'] : 0;
$activate = $activate == 'install' ? 0 : $activate;
$allow = 0;
if(!empty($activate)) {
  foreach($templates as $mod) {
    if($mod['dir'] == $activate) {
    $allow++;
  }
  }
}

$data['lang']['body'] = sprintf($cs_lang['body_temp_list'],$tpl_all);

if(!empty($activate) AND !empty($allow)) {
  $opt_where = "users_id='" . $account['users_id'] . "'";
  $def_cell = array('users_tpl');
  $def_cont = array($activate);
  cs_sql_update(__FILE__,'users',$def_cell,$def_cont,0,$opt_where);
  
  cs_redirect($cs_lang['success'],'templates','center');
  
  if(file_exists('themes/'.$activate)) {
    cs_redirect($cs_lang['theme_found'],'templates','center'); 
  }
}
else {
  $data['lang']['getmsg'] = cs_getmsg();
  
  $run = 0;
  
  if(empty($templates)) {
    $data['temp_list'] = '';
  }
  
  foreach($templates as $mod) {
    $data['temp_list'][$run]['name'] = $mod['name'];
    $data['temp_list'][$run]['version'] = $mod['version'];
    $data['temp_list'][$run]['date'] = cs_date('date',$mod['released']);
  
    if(isset($_GET['template']) AND preg_match("=^[_a-z0-9-]+$=i",$_GET['template'])) {
  $cs_main['template'] = $_GET['template'];
}
if($mod['dir'] == $cs_main['template']) { 
      $data['temp_list'][$run]['preview'] = cs_icon('submit','16',$cs_lang['yes']);
    }
    elseif($mod['dir'] != 'install') {  
      $data['temp_list'][$run]['preview'] = cs_link(cs_icon('cancel','16',$cs_lang['no']),'templates','center','template=' . $mod['dir']);
    }
    else {
      $data['temp_list'][$run]['preview'] = cs_icon('editdelete','16','----');
    }
  
  $cs_users = cs_sql_select(__FILE__,'users','users_tpl','users_id = "' . $account['users_id'] . '"');
    if(!empty($cs_users)) {
          if(!empty($cs_users['users_tpl'])) {
            $cs_main['template'] = $cs_users['users_tpl'];
          }
          else {
            $cs_main['template'] = $cs_main['def_tpl'];
          }
        }
        else {
          $cs_main['template'] = $cs_main['def_tpl'];
        }
    
    
    $cs_users = cs_sql_select(__FILE__,'users','users_tpl','users_id = "' . $account['users_id'] . '"');
    if(!empty($cs_users)) {
          if(!empty($cs_users['users_tpl'])) {
            $cs_main['def_tpl'] = $cs_users['users_tpl'];
          }
          else {
            $cs_main['def_tpl'] = $cs_main['def_tpl'];
          }
        }
        else {
          $cs_main['def_tpl'] = $cs_main['def_tpl'];
        }

    if($mod['dir'] == $cs_main['def_tpl']) { 
      $data['temp_list'][$run]['active'] = cs_icon('submit','16',$cs_lang['yes']);
    }
    elseif($mod['dir'] != 'install') {  
      $data['temp_list'][$run]['active'] = cs_link(cs_icon('cancel','16',$cs_lang['no']),'templates','center','activate=' . $mod['dir']);
    }
    else {
      $data['temp_list'][$run]['active'] = cs_icon('editdelete','16','----');
    }
    $run++;
  }
}

echo cs_subtemplate(__FILE__,$data,'templates','center');
?>