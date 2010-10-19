<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('news');
$cs_get = cs_get('id');
$news_form = 1;
$news_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

if(isset($_GET['agree'])) {
  $news_form = 0;
  $news = cs_sql_select(__FILE__,'news','news_pictures',"news_id = '" . $news_id . "'");
  $news_string = $news['news_pictures'];
  $news_pics = empty($news_string) ? array() : explode("\n",$news_string);
  foreach($news_pics AS $pics) {
    cs_unlink('news', 'picture-' . $pics);
    cs_unlink('news', 'thumb-' . $pics);
  }

  cs_sql_delete(__FILE__,'news',$news_id);
  $query = "DELETE FROM {pre}_comments WHERE comments_mod='news' AND ";
  $query .= "comments_fid='" . $news_id . "'";
  cs_sql_query(__FILE__,$query);

  include_once('mods/news/rss.php');

  cs_redirect($cs_lang['del_true'], 'news');
}

if(isset($_GET['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'news');
}

if(!empty($news_form)) {
  $cs_news = cs_sql_select(__FILE__,'news','news_headline','news_id = ' . $news_id,0,0,1);
  if(!empty($cs_news)) {
    $data['head']['topline'] = sprintf($cs_lang['remove_news'],$cs_news['news_headline']);
    $data['news']['content'] = cs_link($cs_lang['confirm'],'news','remove','id=' . $news_id . '&amp;agree');
    $data['news']['content'] .= ' - ';
    $data['news']['content'] .= cs_link($cs_lang['cancel'],'news','remove','id=' . $news_id . '&amp;cancel');
  }
  else {
    cs_redirect('','news','manage');
  }
  echo cs_subtemplate(__FILE__,$data,'news','remove');
}
