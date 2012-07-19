<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('news');

$cs_get = cs_get('id,where');

$cs_option = cs_sql_option(__FILE__, 'news');
$abcode = explode(",", $cs_option['abcode']);

$cs_news_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_get['where'])) $cs_news_id = $cs_get['where'];

$from = 'news nws INNER JOIN {pre}_users usr ON nws.users_id = usr.users_id INNER JOIN {pre}_categories cat ON nws.categories_id = cat.categories_id';
$select = 'nws.news_id AS news_id, nws.news_headline AS news_headline, nws.news_time AS news_time, nws.news_text AS news_text, nws.news_close AS news_close, nws.news_public AS news_public, nws.news_pictures as news_pictures, nws.users_id AS users_id, usr.users_nick AS users_nick, usr.users_active AS users_active, usr.users_delete AS users_delete, nws.categories_id AS categories_id, cat.categories_access AS categories_access, cat.categories_picture AS categories_picture, nws.news_mirror AS news_mirror, nws.news_mirror_name AS news_mirror_name, nws.news_readmore AS news_readmore, nws.news_readmore_active AS news_readmore_active';
$cs_news = cs_sql_select(__FILE__,$from,$select,"news_id = '" . $cs_news_id . "'");

$head['head']['mod'] = $cs_lang['mod_name'];
$head['head']['action'] = $cs_lang['details'];
$topline = empty($cs_news['news_public']) ? 'not_public' : 'news_info';
$head['head']['topline'] = $cs_lang[$topline];

echo cs_subtemplate(__FILE__,$head,'news','head');

$pub = $cs_news['categories_access'] > $account['access_news'] ? 0 : $cs_news['news_public'];
if(!empty($pub)) {
  $com_where = "comments_mod = 'news' AND comments_fid = '" . $cs_news['news_id'] . "'";
  $data['news']['comments_count'] = cs_sql_count(__FILE__,'comments',$com_where);

  $start = floor($data['news']['comments_count'] / ($account['users_limit'] + 1)) * $account['users_limit'];
  $cs_news_com_count = $data['news']['comments_count'] - $start;
  $data['news']['comments_link'] = cs_link($cs_lang['comments'],'news','view','id=' . $cs_news['news_id'] . '&amp;start=' . $start . '#com' . $cs_news_com_count);

  $cs_main['page_title'] = $cs_news['news_headline'];
  $data['news']['news_headline'] = cs_secure($cs_news['news_headline']);

  $data['news']['news_time'] = cs_date('unix',$cs_news['news_time'],1);
  $data['news']['news_text'] = cs_secure($cs_news['news_text'], $abcode[0], $abcode[1], $abcode[2], $abcode[3], $abcode[4]);

  if(empty($cs_news['news_readmore_active']))
    $data['news']['news_readmore'] = '';
  else {
    $data['news']['news_readmore']  = cs_secure($cs_news['news_readmore'], $abcode[0], $abcode[1], $abcode[2], $abcode[3], $abcode[4]);
    $data['news']['news_readmore'] .= cs_html_br(2);
  }
  
  $data['news']['users_link'] = cs_user($cs_news['users_id'],$cs_news['users_nick'], $cs_news['users_active'], $cs_news['users_delete']);
  $data['if']['catimg'] = empty($cs_news['categories_picture']) ? false : true;
  $data['news']['url_catimg'] = empty($data['if']['catimg']) ? '' : 'uploads/categories/'.$cs_news['categories_picture'];

  $data['news']['pictures'] = '';
  if(!empty($cs_news['news_pictures'])) {
    $news_pics = explode("\n",$cs_news['news_pictures']);
    $data['news']['pictures'] = cs_html_br(2);
    foreach($news_pics AS $pic) {
      $link = cs_html_img('uploads/news/thumb-' . $pic);
      $path = $cs_main['php_self']['dirname'];
      $data['news']['pictures'] .= cs_html_link($path . 'uploads/news/picture-' . $pic,$link) . ' ';
    }
  }

  $data['if']['show'] = false;

  if(!empty($cs_news['news_mirror'])) {
    $data['if']['show'] = true;

    $temp_mirror = explode("\n", $cs_news['news_mirror']);
    $temp_mirror_name = explode("\n", $cs_news['news_mirror_name']);

    $tpl_run = 0;

    for($run_mirror=1; $run_mirror < count($temp_mirror); $run_mirror++) {
      $num = $run_mirror;

      if($run_mirror == (count($temp_mirror) - 1)) {
          $data['mirror'][$tpl_run]['dot'] =  '';
      }
      elseif(!empty($run_mirror)) {
        $data['mirror'][$tpl_run]['dot'] =  ' - ';
      }
      else {
        $data['mirror'][$tpl_run]['dot'] =  ' - ';
      }
      $url = strpos($temp_mirror[$run_mirror],'://') === false ? 'http://' . $temp_mirror[$run_mirror] : $temp_mirror[$run_mirror];
      $data['mirror'][$tpl_run]['news_mirror'] = cs_html_link($url,$temp_mirror_name[$run_mirror]);
      $tpl_run++;
    }
  }

  echo cs_subtemplate(__FILE__,$data,'news','view');

  echo cs_html_anchor('com0');
  include_once('mods/comments/functions.php');

  if(!empty($data['news']['comments_count'])) {
    echo cs_html_br(1);
    echo cs_comments_view($cs_news_id,'news','view',$data['news']['comments_count']);
  }
  echo cs_comments_add($cs_news_id,'news',$cs_news['news_close']);
}