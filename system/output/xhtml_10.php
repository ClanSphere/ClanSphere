<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

if(version_compare(phpversion(), '5.2.1', '>='))
  require_once 'mods/ajax/mail_func.php';
else
  require_once 'mods/ajax/mail_func_old.php';

function cs_html_mail($mail, $link = '')
{
  return cs_ajax_mail($mail, $link);
}
function cs_html_jabbermail($mail, $link = '')
{
  return cs_ajax_mail($mail, $link);
}

function cs_html_br($run = 1)
{
  $var = '';
  while (0 < $run)
  {
    $var .= '<br />';
    $run--;
  }
  return $var . "\n";
}

function cs_html_hr($width)
{
  return "<hr style=\"width:" . $width . "\" />\n";
}

function cs_html_img($url, $height = 0, $width = 0, $more = 0, $alt = '')
{
  global $cs_main;
  $internal = '';
  if(strpos($url, '://') === false) {
    $prefix = strpos($url, $cs_main['php_self']['dirname']);
    if($prefix === false OR $prefix > 1) {
      $internal = $cs_main['php_self']['dirname'];
    }
  }
  $var = "<img src=\"" . $internal . str_replace(' ', '%20', $url) . "\" ";
  if (!empty($height) or !empty($width)) {
    $var .= 'style="';
    if (!empty($width)) {
      $var .= 'width:' . $width . 'px;';
    }
    if (!empty($height)) {
      $var .= 'height:' . $height . 'px;';
    }
    $var .= '" ';
  }  
  if (!empty($more))
  {
    $var .= $more . ' ';
  }
  return $var . "alt=\"" . $alt . "\" />";
}

function cs_html_link($url, $link, $use_target = 1, $class = 0, $title = 0, $more = 0)
{
  global $cs_main;
  $url = str_replace('http://http://', 'http://', $url);
  if (!empty($cs_main['rss']) and strpos($url, '://') === false)
  {
    if (!empty($cs_main['php_self']['dirname']) and strpos($url, $cs_main['php_self']['dirname']) === false)
    {
      $url = $cs_main['php_self']['website'] . $cs_main['php_self']['dirname'] . $url;
    }
    else
    {
      $url = $cs_main['php_self']['website'] . $url;
    }
  }
  $var = "<a href=\"" . str_replace(' ', '%20', $url) . "\"";
  if (!empty($use_target) and empty($cs_main['rss']))
  {
    $var .= " target=\"_blank\"";
  }
  if (!empty($class))
  {
    $var .= " class=\"" . $class . "\"";
  }
  if (!empty($title))
  {
    $var .= " title=\"" . $title . "\"";
  }
  if (!empty($more))
  {
    $var .= " " . $more;
  }
  return $var . ' >' . $link . '</a>';
}

function cs_html_anchor($name, $text = '', $more = '')
{
  return "<a href=\"#\" id=\"" . $name . "\"" . $more . " >" . $text . "</a>";
}

function cs_html_select($func, $name = '', $more = 0)
{
  if (!empty($func))
  {
    $var = "<select name=\"" . $name . "\" class=\"form\"";
    if (!empty($more))
    {
      $var .= ' ' . $more;
    }
    return $var . ">\n";
  }
  else
  {
    return "</select>\n";
  }
}

function cs_html_option($name, $value, $select = 0, $style = 0)
{
  global $cs_main;
  $value = htmlspecialchars($value, ENT_QUOTES, $cs_main['charset']);
  $var = "<option value=\"" . $value . "\"";
  if (!empty($style))
  {
    $var .= " style=\"" . $style . "\"";
  }
  if (!empty($select))
  {
    $var .= " selected=\"selected\"";
  }
  return $var . '>' . $name . "</option>\n";
}

function cs_html_underline($func)
{
  $func == 1 ? $var = '<span style="text-decoration:underline>' : $var = '</span>';
  return $var;
}

function cs_html_big($func)
{
  $func == 1 ? $var = '<strong>' : $var = '</strong>';
  return $var;
}

function cs_html_italic($func)
{
  $func == 1 ? $var = '<em>' : $var = '</em>';
  return $var;
}

function cs_html_list($string, $style = 0, $element = '[*]')
{
  $var = str_replace($element, '</li><li>', $string);
  $first = strpos($var, '</li>');
  $var = substr($var, 0, $first) . substr($var, $first + 5) . '</li>';
  $var = empty($style) ? '<ul>' . $var . '</ul>' : '<ol>' . $var . '</ol>';
  return $var;
}