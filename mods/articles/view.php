<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('articles');

$cs_get = cs_get(array('where','id','page'));

$cs_articles_id = empty($cs_get['where']) ? $cs_get['id'] : $cs_get['where'];

function cs_articles_views($id, $views) {

  settype($id, 'integer');
  settype($views, 'integer');
  $_SESSION['articles'] = isset($_SESSION['articles']) ? $_SESSION['articles'] : array();

  if(empty($_SESSION['articles'][$id])) {
    $_SESSION['articles'][$id] = true;
    cs_sql_update(__FILE__, 'articles', array('articles_views'), array(1 + $views), $id, 0, 0);
  }
}

$cells = 'articles_views, articles_headline, users_id, articles_time, articles_text, articles_fornext, articles_com, categories_id';
$cs_articles = cs_sql_select(__FILE__,'articles',$cells,"articles_id = '" . $cs_articles_id . "'");

$categories = cs_sql_select(__FILE__,'categories','categories_picture, categories_access',"categories_id = '" . $cs_articles['categories_id'] . "'");

if ($categories['categories_access'] > $account['access_categories']) {
  
  echo $cs_lang['nocat_axx'];

} else {

  $cs_main['page_title'] = $cs_articles['articles_headline'];

  cs_articles_views($cs_articles_id, $cs_articles['articles_views']);
  
  $page = empty($cs_get['page']) ? 1 : $cs_get['page'];
  
  $data['head']['articles_headline'] = cs_secure($cs_articles['articles_headline']);
  $cs_articles_user = cs_sql_select(__FILE__,'users','users_nick, users_active, users_delete',"users_id = '" . $cs_articles['users_id'] . "'");
  $data['head']['users_link'] = cs_user($cs_articles['users_id'],$cs_articles_user['users_nick'],$cs_articles_user['users_active'], $cs_articles_user['users_delete']).' ';
  $data['head']['articles_date'] = cs_date('unix',$cs_articles['articles_time'],1);
  $data['head']['pages'] = $page;

  $data['if']['catimg'] = empty($categories['categories_picture']) ? false : true;
  $data['cat']['url_catimg'] = empty($data['if']['catimg']) ? '' : 'uploads/categories/'.$categories['categories_picture'];

  $with_html = cs_abcode_inhtml($cs_articles['articles_text']);
  $text = trim(cs_abcode_inhtml($cs_articles['articles_text'], 'del'));
  if(substr($text,0,3) == '<p>' AND substr($text,-4,4) == '</p>')
    $text = substr($text, 3, -4);

  $text = explode("[pagebreak]", $text);
  $count_text = count($text);
  $page_now = $page - 1;

  if(!empty($with_html))
    $text[$page_now] = cs_abcode_inhtml($text[$page_now], 'add');

    $secure_text = cs_secure($text[$page_now],1,1,1,1); 

  include_once('mods/articles/cutpages.php');

  $data['articles']['articles_text'] = articles_secure($secure_text);
  
  // navlist
  $data2['content'] = array();
  $data2['navlist']['last_page'] = '-';
  $data2['navlist']['next_page'] = '';
  
  if (empty($cs_articles['articles_fornext']) && $count_text >= 2) {
      
    $data2['lang']['pages'] = $cs_lang['pages'];
  
    if (2 < $page) {
      $last_page = $page - 1;
      $data2['navlist']['last_page'] = cs_link('<','articles','view','id=' .$cs_articles_id. '&amp;page=' .$last_page);
      $data2['navlist']['next_page'] = '';
    } 
  
    for($i = 0; $i < $count_text; $i++ ) {
      $sel_page = $i + 1;
      if ($sel_page != $page) {
        $content[$i]['page'] = cs_link($sel_page,'articles','view','id=' .$cs_articles_id. '&amp;page=' .$sel_page);
      } else {
        $content[$i]['page'] =  $page;
      }
    }
  
    if ($page < $count_text) {
      $next_page = $page + 1;
      $data2['navlist']['next_page'] =  cs_link('>','articles','view','id=' .$cs_articles_id. '&amp;page=' .$next_page);
    }
    if ($page > 1) {
      $last_page = $page - 1;
      $data2['navlist']['last_page'] = cs_link('<','articles','view','id=' .$cs_articles_id. '&amp;page=' .$last_page);
    } else {
      $data2['navlist']['last_page'] = '';
    }
    $data2['content'] = $content;
  }
  
  // template
    echo cs_subtemplate(__FILE__,$data,'articles','view'); 
  if (empty($cs_articles['articles_fornext'])) {
    echo cs_subtemplate(__FILE__,$data2,'articles','navpages');
  }

  // comments
  if(!empty($cs_articles)) {
  include_once('mods/comments/functions.php');
  $where1 = "comments_mod = 'articles' AND comments_fid = '" . $cs_articles_id . "'";
  $count_com = cs_sql_count(__FILE__,'comments',$where1);
  
  if(!empty($count_com)) {
    echo cs_html_br(1);
    echo cs_comments_view($cs_articles_id,'articles','view',$count_com);
  }
  echo cs_comments_add($cs_articles_id,'articles',$cs_articles['articles_com']);
  }
}