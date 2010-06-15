<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('news');
$cs_get = cs_get('id');

$news_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

if(isset($_GET['agree'])) {
  
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
elseif(isset($_GET['cancel'])) 
  cs_redirect($cs_lang['del_false'], 'news');
else {

  $data['head']['topline'] = sprintf($cs_lang['remove_rly'],$news_id);
  $data['news']['content'] = cs_link($cs_lang['confirm'],'news','remove','id=' . $news_id . '&amp;agree');
  $data['news']['content'] .= ' - ';
  $data['news']['content'] .= cs_link($cs_lang['cancel'],'news','remove','id=' . $news_id . '&amp;cancel');
}

echo cs_subtemplate(__FILE__,$data,'news','remove');