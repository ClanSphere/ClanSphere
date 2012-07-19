<?php
// ClanSphere 2010 - www.clansphere.net 
// $Id$

$cs_lang = cs_translate('shoutbox');

$captcha = extension_loaded('gd') ? 1 : 0;

if(isset($_POST['submit'])) {
  
  $opt = cs_sql_option(__FILE__,'shoutbox');
  
  $cs_shout['shoutbox_ip'] = cs_getip();
  $cs_shout['shoutbox_name'] = trim($_POST['sh_nick']);
  $cs_shout['shoutbox_text'] = !empty($_POST['sh_text']) ? $_POST['sh_text'] : '' ;
  $cs_shout['shoutbox_date'] = cs_time();

  # do not use htmlspecialchars with charset here due to website
  $uri = empty($_POST['uri']) ? '' : htmlspecialchars($_POST['uri'], ENT_QUOTES);
  
  if(!empty($_POST['sh_text2'])) {
    $cs_shout['shoutbox_text'] = $_POST['sh_text2'];
  }
  
  $error = '';
  
  if($cs_shout['shoutbox_name'] == 'Nick' OR empty($cs_shout['shoutbox_name'])) {
    $error .= cs_html_br(1) . '- ' . $cs_lang['no_name'];
    $cs_shout['shoutbox_name'] = '';
  }
  
  if(empty($cs_shout['shoutbox_text'])) {
    $error .= cs_html_br(1) . ' ' . $cs_lang['no_text'];
  }
  
  if(strlen($cs_shout['shoutbox_text']) > $opt['max_text']) {
    $signs = strlen($cs_shout['shoutbox_text']) - $opt['max_text'];
    $error .= cs_html_br(1) . '- ' . sprintf($cs_lang['too_long'],$signs);
  }
  
  if(empty($account['users_id']) && !cs_captchacheck($_POST['captcha'],1)) {
    $error .= cs_html_br(1) . ' ' . $cs_lang['captcha_false'] . cs_html_br(1);
  }
  
  $cond = 'shoutbox_ip = \'' . cs_sql_escape($cs_shout['shoutbox_ip']) . '\'';
  $flood = cs_sql_select(__FILE__,'shoutbox','shoutbox_date',$cond,'shoutbox_date DESC');
  $maxtime  = $flood['shoutbox_date'] + $cs_main['def_flood'];
  
  $time_now = cs_time();
  if($maxtime > $time_now) {
    $diff = $maxtime - $time_now;
    $error .= cs_html_br(1) . '- ' . sprintf($cs_lang['flood'],$diff);
  }
  
  $text = cs_sql_escape($cs_shout['shoutbox_text']);
  $min = $time_now - 600; // 10 min
  $where = "shoutbox_text = '" . $text . "' AND shoutbox_ip = '" . cs_sql_escape($cs_shout['shoutbox_ip']) . "'";
  $where .= " AND shoutbox_date > '" . $min . "'";
  $count_double = cs_sql_count(__FILE__,'shoutbox',$where);
  
  if (!empty($count_double)) $error .= cs_html_br(1) . '- ' . $cs_lang['double'];
  
  if(empty($account['users_id']) || $cs_shout['shoutbox_name'] != $account['users_nick']) {
    $nick_valid = cs_sql_count(__FILE__,'users','users_nick = \'' . cs_sql_escape($cs_shout['shoutbox_name']) . '\'');
    
    if(!empty($nick_valid)) {
      $error .= cs_html_br(1) . '- ' . $cs_lang['user_exists'];
    }    
  }
  
  if(!empty($error)) {
    $data['lang']['body'] = $cs_lang['errors'] . ' ' . $error;
    
    $data['form']['url'] = cs_url('shoutbox','create');
    $data['form']['name'] = cs_secure($cs_shout['shoutbox_name']);
    $data['form']['message'] = cs_secure($cs_shout['shoutbox_text']);
    
    if(!empty($captcha) && empty($account['users_id'])) {
      $data['form']['captcha'] = cs_html_img('mods/captcha/generate.php?time=' . cs_time() . '&mini');
      $data['form']['show'] = cs_subtemplate(__FILE__,$data,'shoutbox','captcha');
    } else {
      $data['form']['show'] = '';
    }
  
    echo cs_subtemplate(__FILE__,$data,'shoutbox','create');
    
  } else {
    $cells = array_keys($cs_shout);
    $values  = array_values($cs_shout);
    cs_sql_insert(__FILE__,'shoutbox',$cells,$values);

    $data['shoutbox']['done'] = cs_html_link($uri, $cs_lang['continue'], 0);

    echo cs_subtemplate(__FILE__,$data,'shoutbox','submit');   
  }
}
else {
  $data['shoutbox']['no_submit'] = $cs_lang['no_submit'];
  echo cs_subtemplate(__FILE__,$data,'shoutbox','no_submit');
}