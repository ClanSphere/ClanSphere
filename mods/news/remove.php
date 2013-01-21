<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('news');
$cs_get = cs_get('id,agree,cancel');

if(isset($cs_get['agree'])) {
  $news = cs_sql_select(__FILE__,'news','news_pictures',"news_id = '" . $cs_get['id'] . "'");
  $news_string = $news['news_pictures'];
  $news_pics = empty($news_string) ? array() : explode("\n",$news_string);
  foreach($news_pics AS $pics) {
    cs_unlink('news', 'picture-' . $pics);
    cs_unlink('news', 'thumb-' . $pics);
  }

  cs_sql_delete(__FILE__,'news',$cs_get['id']);
  $query = "DELETE FROM {pre}_comments WHERE comments_mod='news' AND ";
  $query .= "comments_fid='" . $cs_get['id'] . "'";
  cs_sql_query(__FILE__,$query);

  include_once('mods/news/rss.php');

  cs_redirect($cs_lang['del_true'], 'news');
}

if(isset($cs_get['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'news');
}

$cs_news = cs_sql_select(__FILE__,'news','news_headline','news_id = ' . $cs_get['id'],0,0,1);
if(!empty($cs_news)) {
  $data = array();
  $data['head']['topline'] = sprintf($cs_lang['remove_news'],$cs_news['news_headline']);
  $data['news']['content'] = cs_link($cs_lang['confirm'],'news','remove','id=' . $cs_get['id'] . '&amp;agree');
  $data['news']['content'] .= ' - ';
  $data['news']['content'] .= cs_link($cs_lang['cancel'],'news','remove','id=' . $cs_get['id'] . '&amp;cancel');
  echo cs_subtemplate(__FILE__,$data,'news','remove');
}
else {
  cs_redirect('','news','manage');
}
