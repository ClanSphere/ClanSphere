<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

# Warning: This file is deprecated! Replace the following functions with themes

# List of removed functions:
# cs_html_table, cs_html_roco, cs_html_form, cs_html_textarea, cs_html_vote, cs_html_input, cs_html_div, cs_html_span
# Add the following line to your setup.php file to use them further on:
# $cs_main['xhtml_old'] = 1;

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
    return $form . ">\n" . cs_xsrf_protection_field(array(''));
  }
  else
  {
    return "</form>\n";
  }
}

function cs_html_input($name, $value, $type, $max = 0, $size = 0, $more = 0, $class = 'form')
{
  cs_warning(__FUNCTION__ . ' - Function is removed, please use themes instead!');

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
  cs_warning(__FUNCTION__ . ' - Function is removed, please use themes instead!');
  
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

function cs_html_div($func, $style = 0, $more = 0)
{
  cs_warning(__FUNCTION__ . ' - Function is removed, please use themes instead!');
  
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