<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('news');
$cs_post = cs_post('where');
$cs_get = cs_get('where');

$cat_id = empty($cs_get['where']) ? 0 : $cs_get['where'];
if (!empty($cs_post['where']))  $cat_id = $cs_post['where'];

$cs_option = cs_sql_option(__FILE__, 'news');
$abcode = explode(",", $cs_option['abcode']);

$where = "nws.news_public > 0 AND cat.categories_access <= " . $account['access_news'];
if(!empty($cat_id)) {
  $where .= " AND cat.categories_id = '" . $cat_id . "'";
}

$start = empty($_REQUEST['start']) ? 0 : (int)$_REQUEST['start'];

$newsmod = "categories_mod = 'news' AND categories_access <= " . $account['access_news'];
$cat_data = cs_sql_select(__FILE__, 'categories', '*', $newsmod, 'categories_name', 0, 0);
$data['head']['dropdown'] = cs_dropdown('where', 'categories_name', $cat_data, $cat_id, 'categories_id');
$join = 'news nws INNER JOIN {pre}_categories cat ON nws.categories_id = cat.categories_id';
$news_count = cs_sql_count(__FILE__, $join, $where, 'news_id');
$data['head']['pages'] = cs_pages('news', 'recent', $news_count, $start, $cat_id, 0, $cs_option['max_recent']);

$from = 'news nws INNER JOIN {pre}_users usr ON nws.users_id = usr.users_id ';
$from .= 'INNER JOIN {pre}_categories cat ON nws.categories_id = cat.categories_id';
$select = 'nws.news_id AS news_id, nws.news_headline AS news_headline, nws.news_time AS news_time, nws.news_text AS news_text,';
$select .= ' nws.news_pictures AS news_pictures, nws.users_id AS users_id, usr.users_nick AS users_nick, usr.users_active AS users_active, usr.users_delete AS users_delete, nws.categories_id AS ';
$select .= 'categories_id, cat.categories_picture AS categories_picture, cat.categories_name AS categories_name, nws.news_mirror AS news_mirror, nws.news_mirror_name AS news_mirror_name, nws.news_readmore AS news_readmore, nws.news_readmore_active AS news_readmore_active';
$order = 'news_attached DESC, news_time DESC';
$cs_news = cs_sql_select(__FILE__, $from, $select, $where, $order, $start, $cs_option['max_recent']);

if($cs_option['max_recent'] == '1') {
  $anews = array();
  array_push($anews,$cs_news);
  unset($cs_news);
  $cs_news = $anews;
  $news_loop = 1;
}
else {
  $news_loop = count($cs_news);
}

for($run = 0; $run < $news_loop; $run++) {
  $cs_news[$run]['news_headline'] = cs_secure($cs_news[$run]['news_headline']);
  $cs_news[$run]['news_time'] = cs_date('unix', $cs_news[$run]['news_time'], 1);
  $cs_news[$run]['if']['readmore'] = false;

  if(!empty($cs_news[$run]['news_readmore']) and $cs_news[$run]['news_readmore_active'] == '1') {
    $cs_news[$run]['news_readmore'] = cs_secure($cs_news[$run]['news_readmore'], $abcode[0], $abcode[1], $abcode[2], $abcode[3], $abcode[4]) . cs_html_br(2);
    $cs_news[$run]['if']['readmore'] = true;
    $cs_news[$run]['news_text'] = '';
  }
  elseif(!empty($cs_news[$run]['news_readmore']) and  $cs_news[$run]['news_readmore_active'] == '0'){
    $cs_news[$run]['news_readmore'] = cs_secure($cs_news[$run]['news_readmore'], $abcode[0], $abcode[1], $abcode[2], $abcode[3], $abcode[4]) . cs_html_br(2);
    $cs_news[$run]['news_text'] = cs_secure($cs_news[$run]['news_text'], $abcode[0], $abcode[1], $abcode[2], $abcode[3], $abcode[4]);
  }
  else {
    $cs_news[$run]['news_readmore'] = '';
    $cs_news[$run]['news_text'] = cs_secure($cs_news[$run]['news_text'], $abcode[0], $abcode[1], $abcode[2], $abcode[3], $abcode[4]);
  }

  $cs_user = cs_secure($cs_news[$run]['users_nick']);
  $cs_news[$run]['users_link'] = cs_user($cs_news[$run]['users_id'],$cs_news[$run]['users_nick'], $cs_news[$run]['users_active'], $cs_news[$run]['users_delete']);
  $where3 = "comments_mod = 'news' AND comments_fid = " . $cs_news[$run]['news_id'];
  $cs_news[$run]['comments_count'] = cs_sql_count(__FILE__, 'comments', $where3);
  $start = floor($cs_news[$run]['comments_count'] / ($account['users_limit'] + 1)) * $account['users_limit'];
  $cs_news_com_count = $cs_news[$run]['comments_count'] - $start;
  $cs_news[$run]['comments_link'] = cs_link($cs_lang['comments'], 'news', 'view', 'id=' . $cs_news[$run]['news_id'] . '&amp;start=' . $start . '#com' . $cs_news_com_count);
  $cs_news[$run]['categories_name'] = cs_secure($cs_news[$run]['categories_name']);

  $cs_news[$run]['if']['catimg'] = empty($cs_news[$run]['categories_picture']) ? false : true;
  $cs_news[$run]['url_catimg'] = empty($cs_news[$run]['if']['catimg']) ? '' : 'uploads/categories/' . $cs_news[$run]['categories_picture'];

  $cs_news[$run]['pictures'] = '';
  if(!empty($cs_news[$run]['news_pictures'])) {
    $news_pics = explode("\n", $cs_news[$run]['news_pictures']);
    foreach ($news_pics as $pic) {
    $link = cs_html_img('uploads/news/thumb-' . $pic);
      $cs_news[$run]['pictures'] .= cs_html_link('uploads/news/picture-' . $pic, $link) . ' ';
    }
  }

  $cs_news[$run]['if']['show'] = false;

  if(!empty($cs_news[$run]['news_mirror'])) {
    $cs_news[$run]['if']['show'] = true;

    $temp_mirror = explode("\n", $cs_news[$run]['news_mirror']);
  $temp_mirror_name = explode("\n", $cs_news[$run]['news_mirror_name']);

  $tpl_run = 0;
  for($run_mirror=1; $run_mirror < count($temp_mirror); $run_mirror++) {
    $num = $run_mirror;

    if($run_mirror == (count($temp_mirror) - 1)) {
        $cs_news[$run]['mirror'][$tpl_run]['dot'] =  '';
    }
    elseif(!empty($run_mirror)) {
      $cs_news[$run]['mirror'][$tpl_run]['dot'] =  ' - ';
    }
    else {
      $cs_news[$run]['mirror'][$tpl_run]['dot'] =  ' - ';
    }

    $cs_news[$run]['mirror'][$tpl_run]['news_mirror'] = cs_html_link($temp_mirror[$run_mirror],$temp_mirror_name[$run_mirror]);
    $tpl_run++;
  }
  }
}

$data['news'] = $cs_news;
echo cs_subtemplate(__FILE__, $data, 'news', 'recent');
?>