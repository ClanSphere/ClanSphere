<?php

function cs_manage($mod, $action, $def_mod, $def_action, $merge = array(), $head = array()) {
  $merge = is_array($merge) ? $merge : array();
  $show = $mod . '/' . $action;
  if (empty($head['message'])) $head['message'] = '';
  $data = array('head' => $head);

  global $account;
  
  if($account['users_view'] == 'list') {
    $options = array('info' => 0, 'size' => 16, 'lines' => 4, 'theme' => 'manage_list');
  }
  else {
    $options = array('info' => 0, 'size' => 48, 'lines' => 5, 'theme' => 'manage');
  }

  $mod_array = cs_checkdirs('mods', $show);
  $content = array_merge($merge, $mod_array);
  ksort($content);

  $run = 1;
  $loop = 0;

  foreach($content as $mod) {
    if(!array_key_exists('dir',$mod)) $mod['dir'] = $def_mod;
    if(!array_key_exists('file',$mod)) $mod['file'] = $def_action;
    $acc_dir = 'access_' . $mod['dir'];
    if(array_key_exists($acc_dir,$account) AND $account[$acc_dir] >= $mod['show'][$show]) {
      $cs_lap = cs_icon($mod['icon'],$options['size'],0,0);
      $data['content'][$loop]['img_link' . $run] = cs_link($cs_lap,$mod['dir'],$mod['file']);
      $data['content'][$loop]['txt_link' . $run] = cs_link($mod['name'],$mod['dir'],$mod['file']);
      $run++;
      if($run == $options['lines']) {
        $run = 1;
        $loop++;
      }
    }
  }

  if($run > 1) {
    while($run != 5) {
      $data['content'][$loop]['img_link' . $run] = '';
      $data['content'][$loop]['txt_link' . $run] = '';
      $run++;
    }
  }

  return cs_subtemplate(__FILE__,$data,'clansphere',$options['theme']);  
}
function cs_cspnews($id = 0, $all = 0) {
  global $cs_lang;
  $cs_lang = cs_translate('clansphere');
  $data['if']['one'] = false;
  $data['if']['all'] = false;
  $allow_url_fopen = ini_get('allow_url_fopen');
  if(empty($allow_url_fopen)) {
    $error = $cs_lang['need_url_fopen'];
  } else {
    if(!empty($id)) {
      $opt_where = "options_mod = 'clansphere' AND options_name = 'sec_news'";
      $def_cell = array('options_value');
      $def_cont = array($id);
      cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where);
    } else {
      $options = cs_sql_option(__FILE__,'clansphere');
      $last_id = $options['sec_news'];
      if($content = file_get_contents('http://www.clansphere.net/uploads/clansphere/sec_news.txt')) {
        $news = explode(';',$content);
        $content = explode('@', $news[0]);
        if(empty($all)) {
          if($content[0] > $last_id) {
            $url = 'http://www.clansphere.net/index/news/view/id/' . $content[0];
            $data['info']['text'] = $content[1];
            $data['info']['view'] = cs_html_link($url,$cs_lang['view']);
            $data['info']['read'] = cs_link($cs_lang['read'],'clansphere','admin','sec_news=' . $content[0]);
            $data['info']['showall'] = cs_link($cs_lang['showall'],'clansphere','sec_news');
            $data['if']['one'] = true;
            $data['if']['all'] = false;
            echo cs_subtemplate(__FILE__,$data,'clansphere','news');
          }
        } else {
          $data['if']['one'] = false;
          $data['if']['all'] = true;
          $count = count($news)-1;
          for($run=0; $run < $count; $run++) {
            $content = explode("@", $news[$run]);
            $data['infos'][$run]['text'] = cs_secure($content[1]);
            $url = 'http://www.clansphere.net/index/news/view/id/' . $content[0];
            $data['infos'][$run]['view'] = cs_html_link($url,$cs_lang['view']);
          }
          echo cs_subtemplate(__FILE__,$data,'clansphere','news');
        }
      }        
    }
  }
}
?>