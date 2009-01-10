<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

function cs_servervars($mode, $integers = 0, $unharmed = 0) {
  
  $return = array();
  if (empty($unharmed)) $unharmed = array();
  $mode = strtolower($mode);
  $vars = $mode == 'post' ? $_POST : $_GET;
  if (is_string($integers)) $integers = explode(',',$integers);
  
  foreach ($vars AS $key => $value) {
    if (in_array($key, $unharmed)) { $return[$key] = $value; continue; }
    $return[$key] = in_array($key, $integers) ? (int) $value : cs_sql_escape($value);
  }
  //if ($mode == 'post') unset($_POST); else unset($_GET);
  
  return $return;
}

function cs_get($integers = 0, $unharmed = 0) { return cs_servervars('get',$integers,$unharmed); }
function cs_post($integers = 0, $unharmed = 0) { return cs_servervars('post',$integers,$unharmed); }

/* Part that can be enabled after
 * including this function in the whole script
 *
$cs_post_hidden = $_POST;
$cs_get_hidden = $_GET;
 *
unset($_POST);
unset($_GET);
unset($_REQUEST);
 *
 *
*/

?>