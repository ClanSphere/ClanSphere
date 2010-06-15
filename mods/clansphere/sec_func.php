<?php
// ClanSphere 2010 - www.clansphere.net
// $Id: sec_func.php 2500 2009-04-02 18:39:00Z hajo $

function cs_cspnews($all = 0) {

  global $cs_lang, $cs_main;

  $cs_lang = cs_translate('clansphere');

  if(file_exists('uploads/cache/op_clansphere.tmp'))
    cs_unlink('cache', 'op_clansphere.tmp');

  $id = empty($_GET['sec_news']) ? 0 : (int) $_GET['sec_news'];

  $data['if']['one'] = false;
  $data['if']['all'] = false;
  $allow_url_fopen = ini_get('allow_url_fopen');

  if(empty($allow_url_fopen)) {
    $error = $cs_lang['need_url_fopen'];
  }
  else {
    if(!empty($id) AND empty($all)) {
      $opt_where = "options_mod = 'clansphere' AND options_name = 'sec_last'";
      cs_sql_update(__FILE__, 'options', array('options_value'), array($id), 0, $opt_where);
    }
    else {
      $opt_where = "options_mod = 'clansphere' AND options_name = 'sec_time'";
      cs_sql_update(__FILE__, 'options', array('options_value'), array(cs_time()), 0, $opt_where);

      if($content = file_get_contents('http://www.clansphere.net/uploads/clansphere/sec_news.txt')) {
        $content = str_replace(array("\r","\n"),'',$content);
        $news = explode(';',$content);
        $content = explode('@', $news[0]);

        if($content[0] > $cs_main['sec_news']) {
          $opt_where = "options_mod = 'clansphere' AND options_name = 'sec_news'";
          $sec_news = (int) $content[0];
          cs_sql_update(__FILE__, 'options', array('options_value'), array($sec_news), 0, $opt_where);
        }

        if(empty($all)) {
          if($content[0] > $cs_main['sec_last']) {
            $url = 'http://www.clansphere.net/index/news/view/id/' . $content[0];
            $data['info']['text'] = htmlentities($content[1], ENT_QUOTES, $cs_main['charset']);
            $data['info']['view'] = cs_html_link($url,$cs_lang['view']);
            $data['info']['read'] = cs_link($cs_lang['read'],'clansphere','sec_news','sec_news=' . $content[0]);
            $data['info']['showall'] = cs_link($cs_lang['showall'],'clansphere','sec_news');
            $data['if']['one'] = true;
            $data['if']['all'] = false;
            return cs_subtemplate(__FILE__,$data,'clansphere','news');
          }
        }
        else {
          $data['if']['one'] = false;
          $data['if']['all'] = true;
          $count = count($news)-1;
          for($run=0; $run < $count; $run++) {
            $content = explode("@", $news[$run]);
            $data['infos'][$run]['text'] = cs_secure($content[1]);
            $url = 'http://www.clansphere.net/index/news/view/id/' . $content[0];
            $data['infos'][$run]['view'] = cs_html_link($url,$cs_lang['view']);
          }
          return cs_subtemplate(__FILE__,$data,'clansphere','news');
        }
      }        
    }
  }
}