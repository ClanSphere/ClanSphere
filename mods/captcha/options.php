<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('captcha');

$data = array();

require('mods/captcha/functions.php');


$sql['options'] = cs_sql_option(__FILE__,'captcha');


if(!empty($_POST['submit']))
{
  require_once 'mods/clansphere/func_options.php';
  $option['method'] = in_array($_POST['method'], $available_captchas) ? $_POST['method'] : false;
  $option['recaptcha_public_key'] = empty($_POST['recaptcha_public_key']) ? null : $_POST['recaptcha_public_key'];
  $option['recaptcha_private_key'] = empty($_POST['recaptcha_private_key'])? null : $_POST['recaptcha_private_key'];
  $option['areyouahuman_publisher_key'] = empty($_POST['areyouahuman_publisher_key']) ? null : $_POST['areyouahuman_publisher_key'];
  $option['areyouahuman_scoring_key'] = empty($_POST['areyouahuman_scoring_key']) ? null : $_POST['areyouahuman_scoring_key'];
  $option['areyouahuman_lightbox'] = empty($_POST['areyouahuman_lightbox']) ? '' : '1';

  if(($option['method'] == 'recaptcha' AND (empty($option['recaptcha_public_key']) OR empty($option['recaptcha_private_key']))) OR $option['method'] == false)
  {
    $option['method'] = 'standard';
  }
  elseif(($option['method'] == 'areyouahuman' AND (empty($option['areyouahuman_publisher_key']) OR empty($option['areyouahuman_scoring_key']))) OR $option['method'] == false)
  {
    $option['method'] = 'standard';
  }

  cs_optionsave('captcha', $option);
  cs_cache_clear();
  cs_redirect($cs_lang['changes_done'],'options','roots');
}
else
{
  $option = $sql['options'];
}

$data['options']['recaptcha_public_key'] = $option['recaptcha_public_key'];
$data['options']['recaptcha_private_key'] = $option['recaptcha_private_key'];
$data['options']['areyouahuman_publisher_key'] = $option['areyouahuman_publisher_key'];
$data['options']['areyouahuman_scoring_key'] = $option['areyouahuman_scoring_key'];
$data['checked']['areyouahuman_lightbox'] = empty($option['areyouahuman_lightbox']) ? '' : ' checked="checked"';

$run = 0;
foreach($available_captchas AS $captcha)
{
  $data['method'][$run]['name'] = $cs_lang[$captcha];
  $data['method'][$run]['value'] = $captcha;
  $data['method'][$run]['if']['select'] = $captcha == $option['method'] ? true : false;
  $run++;
}


echo cs_subtemplate(__FILE__,$data,'captcha','options');