<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

global $available_captchas, $captcha_option;
$captcha_option['options'] = cs_sql_option(__FILE__,'captcha');
$available_captchas = array(
  'standard',
  'recaptcha',
  'areyouahuman'
);

function cs_captchashow($mini = 0)
{
  global $cs_main,$captcha_option;
  if(check_captcha_methode() == 'recaptcha')
  {
    require_once('recaptchalib.php');
    $error = isset($cs_main['captcha_error']) ? $cs_main['captcha_error'] : '';
    return recaptcha_get_html($captcha_option['options']['recaptcha_public_key'], $error);
  }
  elseif(check_captcha_methode() == 'areyouahuman')
  {
    require_once('mods/captcha/ayah.php');
    $ayah = new AYAH();
    $cs_lang = cs_translate('captcha');
    $lightbox = $captcha_option['options']['areyouahuman_lightbox'] ? $cs_lang['lightbox_message'] : '';
    return $lightbox. $ayah->getPublisherHTML();
  }
  else
  {
    $mini = $mini != 0 ? '&mini' : '';
    $data['captcha']['img'] = cs_html_img('mods/captcha/generate.php?time=' . cs_time().$mini);
    $data['captcha']['size'] = empty($mini) ? 8 : 3;
    return cs_subtemplate(__FILE__,$data,'captcha','captcha');
  }
}

function cs_captchaverify($mini = 0)
{
  global $cs_main,$captcha_option;

  if(check_captcha_methode() == 'recaptcha')
  {
    require_once('recaptchalib.php');
    if (isset($_POST["recaptcha_response_field"])) {
      $resp = recaptcha_check_answer ($captcha_option['options']['recaptcha_private_key'],
        $_SERVER["REMOTE_ADDR"],
        $_POST["recaptcha_challenge_field"],
        $_POST["recaptcha_response_field"]);

      if ($resp->is_valid) {
        return true;
      } else {
        $cs_main['captcha_error'] = $resp->error;
        return false;
      }
    }
  }
  elseif(check_captcha_methode() == 'areyouahuman')  
  {
    require_once("ayah.php");
    $ayah = new AYAH();
    $score = $ayah->scoreResult();

    if ($score)
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  else
  {
    return cs_captchacheck($_POST['captcha'], $mini);
  }
}

function check_captcha_methode()
{
  global $captcha_option;
  if($captcha_option['options']['method'] == 'recaptcha' AND !empty($captcha_option['options']['recaptcha_private_key']) AND !empty($captcha_option['options']['recaptcha_public_key']))
  {
    return 'recaptcha';
  }
  if($captcha_option['options']['method'] == 'areyouahuman' AND !empty($captcha_option['options']['areyouahuman_scoring_key']) AND !empty
    ($captcha_option['options']['areyouahuman_publisher_key']))
  {
    return 'areyouahuman';
  }
  else
  {
    return 'standard';
  }
}