<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$string = base64_decode($_GET['mail']);
$pattern = "=^[_a-z0-9-]+(\.[_a-z0-9-]+)*@([0-9a-z](-?[0-9a-z])*\.)+[a-z]{2}([zmuvtg]|fo|me)?$=i";
if(preg_match($pattern,$string)) {
  echo $string;
}
