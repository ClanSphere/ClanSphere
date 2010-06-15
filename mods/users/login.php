<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');

  $data['head']['mod'] = $cs_lang['mod_name'];
  $data['head']['action'] = $cs_lang['login'];
  
global $login;
if(empty($login['mode'])) {

  if(empty($_POST['login'])) {
    $login_msg = $cs_lang['login_messages'];
  }
  elseif(!empty($login['error'])) {
    $err = $login['error'];
    $login_msg = $cs_lang[$err];
  }

  if(empty($login['nick'])) { 
    $login['nick'] = ''; 
  }
  if(empty($login['password'])) { 
    $login['password'] = ''; 
  }
  if(empty($login['cookie'])) {
    $cookie_yes = 0;
    $cookie_no = 1;
  }
  else {
    $cookie_yes = 1;
    $cookie_no = 0;
  }
  
  $data['head']['body_text'] = empty($login_msg) ? $cs_lang['login_messages'] : $login_msg;  
  $data['lang']['nick'] = $cs_lang['nick'];
  $data['lang']['password'] = $cs_lang['pwd'];
  $data['lang']['cookie'] = $cs_lang['cookie'];
  $data['lang']['yes'] = $cs_lang['yes'];
  $data['lang']['no'] = $cs_lang['no'];
  $data['lang']['options'] = $cs_lang['options'];
  $data['lang']['submit'] = $cs_lang['submit'];
  $data['lang']['reset'] = $cs_lang['reset'];
  
  echo cs_html_br(0);
  echo cs_subtemplate(__FILE__,$data,'users','head');
  echo cs_subtemplate(__FILE__,$data,'users','login');
}
else {
  
  $data['head']['mod'] = $cs_lang['mod_name'];
  $data['head']['action'] = $cs_lang['login'];
  $login_method = $login['method'];
  $data['head']['body_text'] = $cs_lang['method_' . $login_method];
  echo cs_subtemplate(__FILE__,$data,'users','head');

  
  if((empty($_POST['uri']))|| (strstr($_POST['uri'], 'logout'))) {
    cs_redirect('','users','home');
  }
  else {
    $data['link']['continue'] = cs_html_link(str_replace('&','&amp;',$_POST['uri']),$cs_lang['continue'],0);
    echo cs_subtemplate(__FILE__,$data,'users','continue');
  }
}