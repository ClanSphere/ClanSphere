<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_abcode_inhtml($string, $mode = 0) {

  $search = (cs_substr($string,0,6) == '[html]' AND cs_substr($string,-7,7) == '[/html]') ? true : false;
  if(empty($mode))
    return $search;
  elseif($mode == 'del' AND !empty($search))
    $string = cs_substr($string, 6, -7);
  elseif($mode == 'add' AND empty($search) AND $string != '')
    $string = '[html]' . $string . '[/html]';
  return $string;
}

function cs_abcode_button($name, $title, $tag1, $tag2, $content) {

  $javascript = "javascript:abc_insert('" . $tag1 . "','" . $tag2 . "','" . $name . "','')";
  return cs_html_link($javascript, $content, 0, 0, $title) . ' ';
}

function cs_abcode_features($name, $html = 0, $keep = 0) {

  global $cs_main;
  if(!empty($cs_main['rte_more']) AND empty($keep)) return '';

  $cs_lang = cs_translate('system/abcodes', 1);

  $data = array();
  $data['var']['imgpath'] = $cs_main['img_path'];
  $data['var']['ext'] = $cs_main['img_ext'];
  $data['if']['html'] = empty($html) ? false : true;
  $data['var']['textarea'] = $name;

  return cs_subtemplate(__FILE__, $data, 'abcode', 'features');
}

function cs_abcode_smileys($name, $keep = 0) {

  global $cs_main;
  if(!empty($cs_main['rte_more']) AND empty($keep)) return '';

  $cs_lang = cs_translate('system/abcodes', 1);

  $select = 'abcode_pattern, abcode_file';
  $loop_abc = cs_sql_select(__FILE__,'abcode',$select,"abcode_func = 'img'","abcode_order DESC, abcode_id",0,10, 'abcode_smileys');
  $abc_count = count($loop_abc);

  $data = array();
  $data['if']['features'] = $abc_count == 10 ? 1 : 0;
  $data['if']['row3'] = $abc_count > 6 ? 1 : 0;
  $data['if']['row2'] = $abc_count > 3 ? 1 : 0;
  $data['if']['row1'] = $abc_count > 0 ? 1 : 0;

  if($abc_count < 3)
    $data['var'] = array('img2' => '', 'pattern2' => '', 'img3' => '', 'pattern3' => '');
  elseif($abc_count < 6)
    $data['var'] = array('img5' => '', 'pattern5' => '', 'img6' => '', 'pattern6' => '');
  elseif($abc_count < 9)
    $data['var'] = array('img8' => '', 'pattern8' => '', 'img9' => '', 'pattern9' => '');

  $run = 0;
  $abc_while = $abc_count > 9 ? 9 : $abc_count;

  while($abc_while > $run) {
    $data['var']['img' . ($run + 1)] = cs_html_img('uploads/abcode/' . $loop_abc[$run]['abcode_file']);
    $data['var']['pattern' . ($run + 1)] = $loop_abc[$run]['abcode_pattern'];
    $run++;
  }

  $data['var']['textarea'] = $name;

  return empty($abc_count) ? '' : cs_subtemplate(__FILE__, $data, 'abcode', 'imgbox');
}

function cs_abcode_mode($set = 0) {

  static $mode = 1;
  if(!empty($set)) {
    $mode = empty($mode) ? 1 : 0;
  }
  return $mode;
}

function cs_abcode_php($matches) {

  global $cs_main;
  static $lop = 1;
  static $php;

  $content = array();
  $mode = cs_abcode_mode();
  if(empty($mode)) {
    $php_code = html_entity_decode($matches[1], ENT_QUOTES, $cs_main['charset']);
    $php_code = str_replace(array("\r\n","\n"),"\r",$php_code);
    $lines = substr_count($php_code,"\r") + 2;

    if (strpos($php_code, '<?php') === false) { $without = true; $php_code = '<?php ' . $php_code; }
    $php_code = highlight_string($php_code,TRUE);
    if (!empty($without)) $php_code = str_replace('&lt;?php','',$php_code);

    $content['source']['numbers'] = '';
    for($run = 1; $run < $lines; $run++) {
      $content['source']['numbers'] .= $run . ". \r";
    }
    $content['source']['content'] = str_replace(array('<br />', '<code>', '</code>'), '', $php_code);
    $content['source']['id'] = $lop;

    $result = cs_subtemplate(__FILE__, $content, 'abcode', 'sourcebox');

    $php[$lop] = str_replace("\n",'',$result);
    $data = '[php]' . $lop . '[/php]';
    $lop++;
  }
  else {
    $use = $matches[1];
    $data = isset($php[$use]) ? nl2br($php[$use]) : '';
  }

  return $data;
}

function cs_abcode_u($matches) {

  return cs_abcode_output(7, $matches);
}

function cs_abcode_b($matches) {

  return cs_abcode_output(6, $matches);
}

function cs_abcode_i($matches) {

  return cs_abcode_output(8, $matches);
}

function cs_abcode_indent($matches) {

  return cs_abcode_output(9, $matches);
}

function cs_abcode_s($matches) {

  return cs_abcode_output(10, $matches);
}

function cs_abcode_h($matches) {

  return cs_abcode_output(12, $matches);
}

function cs_abcode_hr() {

  return cs_abcode_output(11);
}

function cs_abcode_hr_width($matches) {

  return cs_html_hr($matches[1]);
}

function cs_abcode_list($matches) {

  $style = empty($matches[2]) ? 0 : $matches[1];
  $list = empty($matches[2]) ? $matches[1] : $matches[2];
  $list = cs_html_list($list,$style);
  return str_replace('<br />','',$list);
}

function cs_abcode_img($matches) {

  if ($matches[0]{4} == ']') {
    return cs_html_img($matches[1]);
  }
  else {
    $img  = cs_html_img($matches[3], $matches[2], $matches[1]);
    return cs_html_link($matches[3], $img);
  }
}

function cs_abcode_urlimg ($matches) {

  return '[url='.$matches[1].']'.cs_html_img($matches[4],$matches[3],$matches[2]).'[/url]';
}

function cs_abcode_mail($matches) {

  if (strpos($matches[0],'</a>') !== false)
    return $matches[0];

  if ($matches[0]{0} != '[')
    $matches[1] = $matches[0];
  if(isset($matches['name']))
    $matches[1] = $matches[2];

  return cs_html_mail($matches[1]);
}

function cs_abcode_color($matches) {

  return cs_abcode_output(5, $matches);
}

function cs_abcode_size($matches) {

  $matches[1] = $matches[1] > 50 ? 50 : $matches[1];
  return cs_abcode_output(4, $matches);
}

function cs_abcode_align($matches) {

  return cs_abcode_output(3, $matches);
}

function cs_abcode_urlauto($matches) {

  if (strpos($matches[0],'</a>') !== false || strpos($matches[0],'[/threadid]') !== false)
    return $matches[0];

  $after = '';
  if (cs_substr($matches[0],-1) == ',') { $matches[0] = cs_substr($matches[0],0,-1); $after = ','; }
  $url = cs_substr($matches[0],0,4) == 'www.' ? 'http://' . $matches[0] : $matches[0];

  return cs_html_link($url,$matches[0]) . $after;
}

function cs_abcode_url($matches) {

  $matches[1] = trim($matches[1]);
  $java = cs_substr($matches[1],0,10);
  if(strtolower($java) != 'javascript') {
    if(empty($matches[2])) {
      $matches[2] = $matches[1];
    }
    $matches[1] = strpos($matches[1],'www.') === 0 ? 'http://' . $matches[1] : $matches[1];
    return cs_html_link($matches[1],$matches[2],1);
  } else {
    return cs_abcode_i(array(0,'Javascript Links are not allowed'));
  }
}

function cs_abcode_quote($matches) {

  global $replaces;
  if ($matches[0] == '[/quote]')
    return cs_abcode_output(2);
  if(empty($matches[1]))
    return cs_abcode_output(1);

  return cs_abcode_output(0,$matches);
}

function cs_abcode_clip($matches) {

  static $clip_id;
  $clip_id++;

  $var = '<a class="clip" href="#">' . $matches[1] . ' ';
  $var .= cs_html_img('symbols/clansphere/plus.gif',0,0,0,'+');
  $var .= cs_html_img('symbols/clansphere/minus.gif',0,0,'style="display:none"','-');
  $var .= '</a>';
  $var .= '<div>' . $matches[2] . '</div>';
  return $var;
}

$htmlcode = array();

function cs_abcode_html($matches) {

  global $cs_main, $htmlcode;
  $nr = count($htmlcode);
  $htmlcode[] = html_entity_decode($matches[1], ENT_QUOTES, $cs_main['charset']);
  return '{html' . $nr . '}';
}

function cs_abcode_eval($matches) {

  global $cs_main;
  $matches[1] = str_replace('<br />',"\r\n",$matches[1]);
  $matches[1] = html_entity_decode($matches[1], ENT_QUOTES, $cs_main['charset']);
  $matches[1] = str_replace(array('<?php','<?','?>'),'',$matches[1]);

  ob_start();
  eval($matches[1]);
  $content = ob_get_contents();
  ob_end_clean();
  $content = str_replace(array("\n","\r"),'',$content);
  return $content;
}

function cs_abcode_flag ($matches) {

  $path = 'symbols/countries/' . $matches[1] . '.png';
  return file_exists($path) ? cs_html_img($path) : '';
}

function cs_abcode_threadid($matches) {

  return cs_link($matches[2],'board','thread','where='.$matches[1]);
}

function cs_abcode_decode($matches) {

  global $cs_main;
  return html_entity_decode($matches[1], ENT_QUOTES, $cs_main['charset']);
}

$replaces = array();

function cs_abcode_load() {

  global $replaces, $cs_main;
  if (!empty($replaces)) return;
  $theme = empty($cs_main['def_theme']) || !file_exists('themes/' . $cs_main['def_theme'] . '/abcode/replaces.tpl') ? 'base' : $cs_main['def_theme'];

  $replaces = file('themes/' . $theme . '/abcode/replaces.tpl');
}

function cs_abcode_output($id, $matches = 0, $limit = 0) {

  global $replaces;
  if (empty($matches)) return rtrim($replaces[$id]);
  if (empty($limit)) {
    $replace = array();
    foreach ($matches AS $key => $value) $replace['{var:' . $key . '}'] = $value;
    return str_replace(array_keys($replace), array_values($replace), rtrim($replaces[$id]));
  }
}

function cs_secure($replace,$features = 0,$smileys = 0, $clip = 1, $html = 0, $phpeval = 0) {

  global $cs_main;
  $newlines = 1;
  $op_abcode = cs_sql_option(__FILE__,'abcode');
  cs_abcode_load();

  $replace = str_replace(array('{','}'),array('&#123;','&#125;'),$replace);

  if(!empty($features)) {
    cs_abcode_mode(1);
    $replace = preg_replace_callback("=\[php\](.*?)\[/php\]=si","cs_abcode_php",$replace);
  }

  if(!empty($smileys)) {
    static $loop, $loop_abc;
    if(empty($loop_abc)) {
      $select = 'abcode_func, abcode_pattern, abcode_result, abcode_file';
      $loop_abc = cs_sql_select(__FILE__,'abcode',$select,0,0,0,0, 'abcode_content');
      $loop = count($loop_abc);
    }
    for($run=0; $run < $loop; $run++) {
      if($loop_abc[$run]['abcode_func'] == 'img') {
        $img_file = 'uploads/abcode/' . $loop_abc[$run]['abcode_file'];
        $img_src = cs_html_img($img_file);
        $replace = str_replace($loop_abc[$run]['abcode_pattern'],'{'.$img_src.'}',$replace);
      }
      elseif($loop_abc[$run]['abcode_func'] == 'str') {
        $pattern = $loop_abc[$run]['abcode_pattern'];
        $replace = str_replace($pattern,'{'.$loop_abc[$run]['abcode_result'].'}',$replace);
      }
    }
  }

  $replace = htmlentities($replace, ENT_QUOTES, $cs_main['charset']);
  $replace = preg_replace('=&amp;#(\d+);=si', '&#\\1;', $replace);
  $replace = preg_replace_callback('={(.*?)}=si','cs_abcode_decode',$replace);

  if(!empty($features)) {

    if(!empty($html)) {
      $newlines = cs_abcode_inhtml($replace) ? 0 : 1;
      $replace = preg_replace_callback("=\[html\](.*?)\[/html\]=si","cs_abcode_html",$replace);
    }

    if (!empty($phpeval))
      $replace = preg_replace_callback("=\[phpcode\](.*?)\[/phpcode\]=si",'cs_abcode_eval',$replace);

    if(!empty($newlines))
      $replace = nl2br($replace);

    $replace = preg_replace_callback("=\[u\](.*?)\[/u\]=si","cs_abcode_u",$replace);
    $replace = preg_replace_callback("=\[b\](.*?)\[/b\]=si","cs_abcode_b",$replace);
    $replace = preg_replace_callback("=\[i\](.*?)\[/i\]=si","cs_abcode_i",$replace);
    $replace = preg_replace_callback("=\[s\](.*?)\[/s\]=si","cs_abcode_s",$replace);
    $replace = preg_replace_callback("'\[(?P<name>email|mail)\](.*?)\[/(?P=name)\]'i","cs_abcode_mail",$replace);
    $replace = preg_replace_callback('=([^\s]{2,})@([^\s]{2,})\.([^\s]{2,7})(?![^<]+>|[^&]*;)=i','cs_abcode_mail',$replace);
    $replace = preg_replace_callback("=\[color\=(#*[\w]*?)\](.*?)\[/color\]=si","cs_abcode_color",$replace);
    $replace = preg_replace_callback("=\[size\=([\d]*?)\](.*?)\[/size\]=si","cs_abcode_size",$replace);
    $replace = preg_replace_callback("'\[(?P<align>left|center|right|justify)\](.*?)\[/(?P=align)\]'si","cs_abcode_align",$replace);
    $replace = preg_replace_callback("=\[list\=([\w]*?)\](.*?)\[/list\]=si","cs_abcode_list",$replace);
    $replace = preg_replace_callback("=\[list\](.*?)\[/list\]=si","cs_abcode_list",$replace);
    $replace = preg_replace_callback("=\[url\=(.*?)\]\[img width\=(.*?) height\=(.*?)\](.*?)\[/img\]\[/url\]=si","cs_abcode_urlimg",$replace);
    $replace = preg_replace_callback("=\[url\=(.*?)\](.*?)\[/url\]=si","cs_abcode_url",$replace);
    $replace = preg_replace_callback("=\[url\](.*?)\[/url\]=i","cs_abcode_url",$replace);
    $replace = preg_replace_callback("=\[img width\=([\d]*?) height\=([\d]*?)\](.*?)\[/img\]=si", "cs_abcode_img",$replace);
    $replace = preg_replace_callback("=\[img\](.*?)\[/img\]=i","cs_abcode_img",$replace);
    $replace = preg_replace_callback('=\[flag\=([\w]*?)\]=i','cs_abcode_flag',$replace);
    $replace = preg_replace_callback("=\[indent\=([\d]*?)\](.*?)\[/indent\]=si","cs_abcode_indent",$replace);
    $replace = preg_replace_callback("=\[threadid\=([\w]*?)\](.*?)\[/threadid\]=si","cs_abcode_threadid",$replace);
    $replace = preg_replace_callback("=\[h\=([\d]*?)\](.*?)\[/h\]=si","cs_abcode_h",$replace);
    $replace = preg_replace_callback("=\[hr\]=i","cs_abcode_hr",$replace);
    preg_match_all('=\[quote\=?(.*?)\]=si', $replace, $quote_sub);
    $quote_start_count  = count($quote_sub[0]);
    $quote_end_count    = substr_count($replace, '[/quote]');
    if ($quote_start_count !== 0 && $quote_start_count == $quote_end_count) {
      $replace = preg_replace_callback('=\[quote\=?(.*?)\]=si',"cs_abcode_quote",$replace);
      $replace = preg_replace_callback('=\[/quote\]=si',"cs_abcode_quote",$replace);
    }
    if(!empty($clip)) {
      $replace = preg_replace_callback("=\[clip\=(.*?)\](.*?)\[/clip\]=si","cs_abcode_clip",$replace);
    }
  }
  if(!empty($html)) {
    global $htmlcode;
    if (!empty($htmlcode)) {
      $count = count($htmlcode);
      for ($i = 0; $i < $count; $i++) $replace = str_replace('{html'.$i.'}',$htmlcode[$i],$replace);
    }
  }

  if(!empty($features)) {

    cs_abcode_mode(1);

    if(empty($html)) {
      $replace = preg_replace_callback('=(www\.|http://|ftp://|https://)([^\s]+)\.([^\s]+)(?![^<]+>|[^&]*;)=si','cs_abcode_urlauto',$replace);

      if(!empty($op_abcode['word_cut']))
        $replace = preg_replace("=(?![>])([^\s*?]{".$op_abcode['word_cut']."})(?![^<]+>|[^&]*;)=","\\0 ",$replace);
    }

    $replace = preg_replace_callback("=\[php\](.*?)\[/php\]=si","cs_abcode_php",$replace);
  }

  return $replace;
}

function cs_abcode_resize ($matches) {

  $options = cs_sql_option(__FILE__,'abcode');

  $max_width = $options['image_width'];
  $max_height = $options['image_height'];

  if ($matches[0]{4} == ']') {
    $img = $matches[1];
    $size = empty($img) ? false : @getimagesize($img);
    if (is_array($size)) {
      if ($size[0] > $max_width) {
        $new_width = $max_width;
        $new_height = round($size[1] / $size[0] * $max_width);
        $change = 1;
      } else {
        $new_height = $size[1];
        $new_width = $size[0];
      }
      if ($new_height > $max_height) {
        $new_height = $max_height;
        $new_width = round($size[0] / $size[1] * $max_height);
        $change = 1;
      }
    }
  }
  else {
    $img = $matches[3];
    if ($matches[1] > $max_width) {
      $change = 1;
      $new_width = $max_width;
    }
    if ($matches[2] > $max_height) {
      $change = 1;
      $new_height = $max_height;
    }
    if (!empty($change)) {
      $new_width = empty($new_width) ? $matches[1] : $new_width;
      $new_height = empty($new_height) ? $matches[2] : $new_height;
    }
  }

  if (!empty($change)) {
    $var = '[img width='.$new_width.' height='.$new_height.']'.$img.'[/img]';
  } else {
    $var = $matches[0];
  }

  return $var;
}