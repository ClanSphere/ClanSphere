<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

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
    return "<hr style=\"width:" . $width . "\" noshade=\"noshade\" />\n";
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
    $email = explode("@", $mail);
    $domain = empty($email[1]) ? array(0,1) : explode(".", $email[1]);
	$link = empty($link) ? $email[0] . ' (at) ' . $domain[0] . ' (dot) ' . $domain[1] : $link;
    $str = base64_encode($mail);
    
    return '<a href="#" onclick="cs_ajax_request(\'mods/clansphere/mail.php?mail=' . $str . '\',function(http_request){window.location=\'mailto:\'+http_request.responseText;})">' . $link . '</a>';
}
function cs_html_msnmail($mail, $link = '')
{
    $email = explode("@", $mail);
    $domain = empty($email[1]) ? array(0,1) : explode(".", $email[1]);
	$link = empty($link) ? $email[0] . ' (at) ' . $domain[0] . ' (dot) ' . $domain[1] : $link;
    $str = base64_encode($mail);
    
    return '<a href="#" onclick="cs_ajax_request(\'mods/clansphere/mail.php?mail=' . $str . '\',function(http_request){window.location=\'http://members.msn.com/\'+http_request.responseText;})">' . $link . '</a>';
}

function cs_html_link($url, $link, $use_target = 1, $class = 0, $title = 0, $more = 0)
{
    global $cs_main;
    static $target = 0;
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
        $target++;
        $var .= " target=\"cs" . $target . "\"";
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
    return "<a href=\"#\" name=\"" . $name . "\"" . $more . " >" . $text . "</a>";
}

function cs_html_input($name, $value, $type, $max = 0, $size = 0, $more = 0, $class = 'form')
{
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

?>