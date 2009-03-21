<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

# Warning: This file is deprecated! Try to move to xhtml_10.php as soon as possible
# The following functions are removed: cs_html_table, cs_html_roco, cs_html_form, cs_html_textarea, cs_html_span
# Change xhtml_10.php to xhtml_10_old.php in cs_init to use them further on
# The following functions will be deleted soon: cs_html_input, cs_html_vote, cs_html_div
# Please use themes instead

function cs_html_br($run)
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

function cs_html_table($func, $class = 0, $spacing = 0, $width = 0)
{
  cs_warning(__FUNCTION__ . ' - Function is removed, please use themes instead!');
  
  if (empty($func))
  {
    return "</table>\n";
  }
  else
  {
    $var = "\n<table ";
    if (!empty($class))
    {
      $var .= "class=\"" . $class . "\" ";
    }
    if (!empty($width) or $func == 1)
    {
      global $cs_main;
      $width2 = empty($width) ? $cs_main['def_width'] : $width;
      $var .= "style=\"width:" . $width2 . "\" ";
    }
    $var .= "cellpadding=\"0\" cellspacing=\"" . $spacing . "\">\n";
    return $var;
  }
}

function cs_html_roco($func, $class = 0, $rowspan = 0, $colspan = 0, $width = 0)
{
  cs_warning(__FUNCTION__ . ' - Function is removed, please use themes instead!');
  
  if (empty($func))
  {
    return "\n </td></tr>";
  }
  else
  {
    if ($func >= 2)
    {
      $var = "</td><td";
    }
    else
    {
      $var = "<tr><td";
    }
    if (!empty($class))
    {
      $var .= " class=\"" . $class . "\"";
    }
    if (!empty($colspan))
    {
      $var .= " colspan=\"" . $colspan . "\"";
    }
    if (!empty($rowspan))
    {
      $var .= " rowspan=\"" . $rowspan . "\"";
    }
    if (!empty($width))
    {
      $var .= " style=\"width:" . $width . "\"";
    }
    return $var . ">\n";
  }
}

function cs_html_img($url, $height = 0, $width = 0, $more = 0, $alt = '')
{
  global $cs_main;
  $internal = strpos($url, '://') === false ? $cs_main['php_self']['dirname'] : '';
  $var = "<img src=\"" . $internal . str_replace(' ', '%20', $url) . "\" ";
  if (!empty($height) and !empty($width))
  {
    $var .= "style=\"height:" . $height . 'px;width:' . $width . "px\" ";
  }
  if (!empty($more))
  {
    $var .= $more . ' ';
  }
  return $var . "alt=\"" . $alt . "\" />";
}

function cs_html_mail($mail, $link = '')
{
  global $cs_main;
	$email = explode("@", $mail);
  $domain = empty($email[1]) ? array(0,1) : explode(".", $email[1]);
  $link = empty($link) ? $email[0] . ' (at) ' . $domain[0] . ' (dot) ' . $domain[1] : $link;
  $str = base64_encode($mail);
  
  return '<a href="javascript:cs_ajax_request(\''.$cs_main['php_self']['dirname'].'mods/clansphere/mail.php?mail=' . $str . '\',function(request){window.location=\'mailto:\'+request.responseText;})">' . $link . '</a>';
}
function cs_html_msnmail($mail, $link = '')
{
  $email = explode("@", $mail);
  $domain = empty($email[1]) ? array(0,1) : explode(".", $email[1]);
  $link = empty($link) ? $email[0] . ' (at) ' . $domain[0] . ' (dot) ' . $domain[1] : $link;
  $str = base64_encode($mail);
  
  return '<a href="javascript: cs_ajax_request(\'mods/clansphere/mail.php?mail=' . $str . '\',function(http_request){window.location=\'http://members.msn.com/\'+http_request.responseText;})">' . $link . '</a>';
}

function cs_html_link($url, $link, $use_target = 1, $class = 0, $title = 0, $more = 0)
{
  global $cs_main;
  $url = str_replace('http://http://', 'http://', $url);
  if (!empty($cs_main['rss']) and strpos($url, '://') === false)
  {
    if (!empty($cs_main['php_self']['dirname']) and strpos($url, $cs_main['php_self']['dirname']) === false)
    {
      $url = 'http://' . $_SERVER['HTTP_HOST'] . $cs_main['php_self']['dirname'] . $url;
    }
    else
    {
      $url = 'http://' . $_SERVER['HTTP_HOST'] . $url;
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

function cs_html_form($func, $form_id = 0, $mod = 0, $action = 0, $enctype = 0, $more = 0)
{
  cs_warning(__FUNCTION__ . ' - Function is removed, please use themes instead!');
  
  if (!empty($func))
  {
    $form = "<form method=\"post\" id=\"" . $form_id . "\" ";
    $form .= "action=\"" . cs_url($mod, $action, $more) . "\"";
    if (!empty($enctype))
    {
      $form .= " enctype=\"multipart/form-data\"";
    }
    return $form . ">\n";
  }
  else
  {
    return "</form>\n";
  }
}

function cs_html_input($name, $value, $type, $max = 0, $size = 0, $more = 0, $class = 'form')
{
  cs_warning(__FUNCTION__ . ' - Function is marked for removal, please use themes!');

  $value = htmlspecialchars($value);
  $var = "\n <input type=\"" . $type . "\" name=\"" . $name . "\" value=\"" . $value . "\" ";
  if (!empty($more))
  {
    $var .= $more . ' ';
  }
  if (!empty($max))
  {
    $var .= "maxlength=\"" . $max . "\" ";
  }
  if (!empty($size))
  {
    $var .= "size=\"" . $size . "\" ";
  }
  if (!empty($class))
  {
    $var .= "class=\"" . $class . "\" ";
  }
  return $var . '/>';
}

function cs_html_vote($name, $value, $type, $check = 0, $more = 0, $class = 'form')
{
  cs_warning(__FUNCTION__ . ' - Function is marked for removal, please use themes!');
  
  $var = "\n <input type=\"" . $type . "\" name=\"" . $name . "\" value=\"" . $value . "\"";
  if (!empty($more))
  {
    $var .= ' ' . $more;
  }
  if (!empty($check))
  {
    $var .= " checked=\"checked\"";
  }
  if (!empty($class))
  {
    $var .= " class=\"" . $class . "\"";
  }
  return $var . '/>';
}

function cs_html_textarea($name, $value, $cols, $rows, $readonly = 0)
{
  cs_warning(__FUNCTION__ . ' - Function is removed, please use themes instead!');
  
  $var = "<textarea name=\"" . $name . "\" cols=\"" . $cols . "\" rows=\"" . $rows . "\" ";
  if (!empty($readonly))
  {
    $var .= "readonly=\"readonly\" ";
  }
  $var .= "id=\"" . $name . "\" class=\"form\">" . htmlspecialchars($value) . "</textarea>\n";
  return $var;
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
  $value = htmlspecialchars($value);
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
  $func == 1 ? $var = '<u>' : $var = '</u>';
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

function cs_html_div($func, $style = 0, $more = 0)
{
  cs_warning(__FUNCTION__ . ' - Function is marked for removal, please use themes!');
  
  if ($func == 1)
  {
    $var = '<div';
    if (!empty($style))
    {
      $var .= " style=\"" . $style . "\"";
    }
    if (!empty($more))
    {
      $var .= ' ' . $more;
    }
    return $var . ">";
  }
  else
  {
    return "</div>";
  }
}

function cs_html_span($func, $style = 0, $more = 0)
{
  cs_warning(__FUNCTION__ . ' - Function is removed, please use themes instead!');
  
  if ($func == 1)
  {
    $var = '<span';
    if (!empty($style))
    {
      $var .= " style=\"" . $style . "\"";
    }
    if (!empty($more))
    {
      $var .= ' ' . $more;
    }
    return $var . ">";
  }
  else
  {
    return "</span>";
  }
}

?>