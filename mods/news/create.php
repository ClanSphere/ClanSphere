<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('news');
global $cs_http;
require_once 'mods/categories/functions.php';
$news_newtime = 0;
$op_news = cs_sql_option(__FILE__,'news');

$data['lang'] = $cs_lang;
$data['head']['mod'] = $cs_lang['mod_name'];
$data['head']['action'] = $cs_lang['create'];
$data['head']['body'] = '';
$data['head']['error'] = '';
$data['if']['preview'] = false;
$data['if']['no_readmore'] = true;

$cs_news['categories_id'] = '';
$cs_news['news_close'] = '';
$cs_news['news_public'] = $op_news['def_public'];
$cs_news['news_attached'] = '';
$cs_news['news_headline'] = '';
$cs_news['news_text'] = '';
$cs_news['news_time'] = '';
$cs_news['news_publishs_at'] = '';
$cs_news['users_id'] = $account['users_id'];
$cs_news['news_mirror'] = '';
$cs_news['news_mirror_name'] = '';
$cs_news['news_readmore'] = '';
$cs_news['news_readmore_active'] = '';

if (!empty($_GET['warid'])) {
  
  $wars_id = (int) $_GET['warid'];
  
  $lang = cs_substr($account['users_lang'],0,2);
  if (!file_exists('uploads/wars/news_' . $lang . '.txt')) $lang = 'de';
  
  $text = file_get_contents('uploads/wars/news_' . $lang . '.txt');
  
  $tables  = 'wars w INNER JOIN {pre}_squads sq ON w.squads_id = sq.squads_id ';
  $tables .= 'INNER JOIN {pre}_clans c ON w.clans_id = c.clans_id ';
  $tables .= 'INNER JOIN {pre}_categories cat ON w.categories_id = cat.categories_id'; 
  $cells  = 'sq.squads_name AS squads_name, c.clans_name AS clans_name, ';
  $cells .= 'w.wars_score1 AS wars_score1, w.wars_score2 AS wars_score2, ';
  $cells .= 'cat.categories_name AS categories_name, w.squads_id AS squads_id, ';
  $cells .= 'w.wars_id AS wars_id, c.clans_id AS clans_id'; 
  $war = cs_sql_select(__FILE__, $tables, $cells, "wars_id = '" . $wars_id . "'");
  
  $replace = array();
  $replace['{SQUADNAME}'] = $war['squads_name'];
  $replace['{SQUADURL}'] = cs_url('squads','view','id=' . $war['squads_id']);
  $replace['{OPPONENTNAME}'] = $war['clans_name'];
  $replace['{OPPONENTURL}'] = cs_url('clans', 'view', 'id=' . $war['clans_id']);
  $replace['{SCORE_1}'] = $war['wars_score1'];
  $replace['{SCORE_2}'] = $war['wars_score2'];
  $replace['{MATCH_URL}'] = cs_url('wars','view','id=' . $war['wars_id']);
  $replace['{CAT_NAME}'] = $war['categories_name'];
  
  $search = array_keys($replace);
  $replace = array_values($replace);
  
  $text = str_replace($search, $replace, $text);
  
  $cs_news['news_text'] = $text;
}

$abcode = explode(",",$op_news['abcode']);
$data['op']['features'] = empty($abcode[0]) ? $cs_lang['no'] : $cs_lang['yes'];
$data['op']['smileys'] = empty($abcode[1]) ? $cs_lang['no'] : $cs_lang['yes'];
$data['op']['clip'] = empty($abcode[2]) ? $cs_lang['no'] : $cs_lang['yes'];
$data['op']['html'] = empty($abcode[3]) ? $cs_lang['no'] : $cs_lang['yes'];
$data['op']['php'] = empty($abcode[4]) ? $cs_lang['no'] : $cs_lang['yes'];

if (isset($_POST['submit']) or isset($_POST['preview'])) {
  $cs_news['categories_id'] = empty($_POST['categories_name']) ? $_POST['categories_id'] : cs_categories_create('news', $_POST['categories_name']);
  $cs_news['news_close'] = isset($_POST['news_close']) ? $_POST['news_close'] : 0;
  $cs_news['news_public'] = isset($_POST['news_public']) ? $_POST['news_public'] : 0;
  $cs_news['news_attached'] = isset($_POST['news_attached']) ? $_POST['news_attached'] : 0;
  $cs_news['news_headline'] = $_POST['news_headline'];
  $cs_news['news_time'] = cs_time();
  $cs_news['users_id'] = $account['users_id'];
  $cs_news['news_publishs_at'] = isset($_POST['publish_at']) ? cs_datepost('date', 'unix') : 0;
  $cs_news['news_readmore_active'] = isset($_POST['news_readmore_active']) ? $_POST['news_readmore_active'] : 0;
  $data['if']['no_readmore'] = isset($_POST['news_readmore_active']) ? false : true;
  $cs_news['news_text'] = empty($cs_main['rte_html']) ? $_POST['news_text'] : cs_abcode_inhtml($_POST['news_text'], 'add');
  $cs_news['news_readmore'] = empty($cs_main['rte_html']) ? $_POST['news_readmore'] : cs_abcode_inhtml($_POST['news_readmore'], 'add');
    
  if(!empty($cs_news['news_publishs_at'])) $cs_news['news_public'] = 0;

  $run_loop = isset($_POST['run_loop']) ? $_POST['run_loop'] : 1;
  $cs_news['news_mirror'] = '';
  $cs_news['news_mirror_name'] = '';

  for($run=0; $run < $run_loop; $run++) {
    $num = $run+1;

    if(!empty($_POST["news_mirror_$num"]) AND !empty($_POST["news_mirror_name_$num"])) {
      $cs_news['news_mirror'] = $cs_news['news_mirror'] . "\n" . $_POST["news_mirror_$num"];
      $cs_news['news_mirror_name'] = $cs_news['news_mirror_name'] . "\n" . $_POST["news_mirror_name_$num"];
    }
  }

  if(!empty($_POST['news_newtime'])) {
    $cs_news['news_time'] = cs_time();
    $news_newtime = 1;
  }

  $error = '';

  if(empty($cs_news['categories_id']))
    $error .= $cs_lang['no_cat'] . cs_html_br(1);
  if(empty($cs_news['news_headline']))
    $error .= $cs_lang['no_headline'] . cs_html_br(1);
  if(empty($cs_news['news_text']))
    $error .= $cs_lang['no_text'] . cs_html_br(1);
}

if(!isset($_POST['submit']) and !isset($_POST['preview'])) {
  $data['head']['body'] = $cs_lang['head_body'];
}
elseif(!empty($error)) {
  $data['head']['body'] = $error;
}
elseif (isset($_POST['preview'])) {
  $data['head']['body'] = $cs_lang['preview'];
}

if(isset($_POST['preview']) and empty($error)) {
  $run = $_POST['run_loop'];
  $data['news']['news_time'] = cs_date('unix', cs_time(), 1);
  $data['news']['preview_news_text'] = cs_secure($cs_news['news_text'],$abcode[0],$abcode[1],$abcode[2],$abcode[3],$abcode[4]);

  $data['if']['readmore'] = false;

  if(!empty($cs_news['news_readmore'])) {
    $data['if']['readmore'] = true;
    $data['news']['preview_news_readmore'] = cs_secure($cs_news['news_readmore'],$abcode[0],$abcode[1],$abcode[2],$abcode[3],$abcode[4]) . cs_html_br(2);
  }

  $search = 'users_id = ' . $cs_news['users_id'];
  $cs_news_user = cs_sql_select(__FILE__, 'users', 'users_nick, users_active', $search);
  $data['news']['users_link'] = cs_user($cs_news['users_id'],$cs_news_user['users_nick'], $cs_news_user['users_active']);

  $data['if']['catimg'] = false;
  $cat_search = "categories_id = '" . $cs_news['categories_id'] . "'";
  $cs_cat = cs_sql_select(__FILE__, 'categories', 'categories_picture', $cat_search);

  if(!empty($cs_cat['categories_picture'])) {
    $data['if']['catimg'] = true;
    $data['news']['url_catimg'] = 'uploads/categories/' . $cs_cat['categories_picture'];
  }

  $data['if']['show'] = false;

  if(!empty($cs_news['news_mirror'])) {
    $data['if']['show'] = true;

    if(isset($_POST['mirror'])) {
      $run_loop = isset($_POST['run_loop']) ? $_POST['run_loop'] : 1;
    } else {
      $temp_mirror = explode("\n", $cs_news['news_mirror']);
      $temp_mirror_name = explode("\n", $cs_news['news_mirror_name']);
      $run_loop_2 = count($temp_mirror);
    }

    $prev_run = 0;

    for($run_prev=1; $run_prev < $run_loop_2; $run_prev++) {
      $num = $run_prev;

      if($run_prev == (count($temp_mirror) - 1)) {
        $data['prev_mirror'][$prev_run]['dot'] =  '';
      } elseif(!empty($run_prev)) {
        $data['prev_mirror'][$prev_run]['dot'] =  ' - ';
      } else {
        $data['prev_mirror'][$prev_run]['dot'] =  ' - ';
      }

      $data['prev_mirror'][$prev_run]['news_mirror'] = cs_html_link($temp_mirror[$run_prev],$temp_mirror_name[$run_prev]);
      $prev_run++;
    }
  }

  $data['if']['preview'] = true;
}

if(isset($_POST['mirror'])) {
  $cs_news['categories_id'] = empty($_POST['categories_name']) ? $_POST['categories_id'] : cs_categories_create('news', $_POST['categories_name']);
  $cs_news['news_close'] = isset($_POST['news_close']) ? $_POST['news_close'] : 0;
  $cs_news['news_public'] = isset($_POST['news_public']) ? $_POST['news_public'] : 0;
  $cs_news['news_attached'] = isset($_POST['news_attached']) ? $_POST['news_attached'] : 0;
  $cs_news['news_headline'] = $_POST['news_headline'];
  $cs_news['news_time'] = cs_time();
  $cs_news['news_publishs_at'] = isset($_POST['publish_at']) ? cs_datepost('date', 'unix') : 0;
  $cs_news['news_readmore_active'] = isset($_POST['news_readmore_active']) ? $_POST['news_readmore_active'] : 0;
  $cs_news['news_text'] = empty($cs_main['rte_html']) ? $_POST['news_text'] : cs_abcode_inhtml($_POST['news_text'], 'add');
  $cs_news['news_readmore'] = empty($cs_main['rte_html']) ? $_POST['news_readmore'] : cs_abcode_inhtml($_POST['news_readmore'], 'add');

  $_POST['run_loop']++;
}

if(!empty($error) or isset($_POST['preview']) or !isset($_POST['submit'])) {
  
  $data['categories']['dropdown'] = cs_categories_dropdown('news',$cs_news['categories_id']);
  $data['news']['news_headline'] = cs_secure($cs_news['news_headline']);
  $data['news']['news_text'] = cs_secure($cs_news['news_text']);
  $data['news']['news_readmore'] = cs_secure($cs_news['news_readmore']);

  if(isset($_POST['mirror'])) {
    $run_loop = isset($_POST['run_loop']) ? $_POST['run_loop'] : 1;
  } else {
    $temp_mirror = explode("\n", $cs_news['news_mirror']);
    $temp_mirror_name = explode("\n", $cs_news['news_mirror_name']);

    $run_loop = count($temp_mirror);
  }

  $tpl_run = 0;
  $run = empty($cs_news['news_mirror']) ? 0 : 1;

  for($run; $run < $run_loop; $run++) {

    $num = empty($cs_news['news_mirror']) ? $run + 1 : $run;

    if(isset($_POST['mirror'])) {
      $cs_news["news_mirror_$num"] = isset($_POST["news_mirror_$num"]) ? $_POST["news_mirror_$num"] : '';
      $cs_news["news_mirror_name_$num"] = isset($_POST["news_mirror_name_$num"]) ? $_POST["news_mirror_name_$num"] : '';
    } else {
      $cs_news["news_mirror_$num"] = $temp_mirror[$run];
      $cs_news["news_mirror_name_$num"] = $temp_mirror_name[$run];
    }

    $data['mirror'][$tpl_run]['num'] = $num;
    $data['mirror'][$tpl_run]['news_mirror'] = $cs_news["news_mirror_$num"];
    $data['mirror'][$tpl_run]['news_mirror_name'] = $cs_news["news_mirror_name_$num"];
    $tpl_run++;
  }

  if(empty($cs_main['rte_html'])) {
    $data['abcode']['features'] = cs_abcode_features('news_text', $abcode[3], 1);
    $data['abcode']['smileys'] = cs_abcode_smileys('news_text', 1);
    $data['abcode']['features_readmore'] = cs_abcode_features('news_readmore', $abcode[3], 1);
    $data['abcode']['smileys_readmore'] = cs_abcode_smileys('news_readmore', 1);
    $data['if']['rte_html'] = false;
    $data['if']['abcode'] = true;
  } else {
    $data['if']['rte_html'] = true;
    $data['if']['abcode'] = false;
    $data['rte']['html'] = cs_rte_html('news_text', $cs_news['news_text']);
    $data['rte']['html_readmore'] = cs_rte_html('news_readmore', $cs_news['news_readmore']);
  }

  $data['news']['loop'] = $run_loop;
  $data['news']['news_readmore_active'] = $cs_news['news_readmore_active'] == 1 ? 'checked="checked"' : '';
  $data['news']['news_close'] = $cs_news['news_close'] == 1 ? 'checked="checked"' : '';
  $data['news']['news_public'] = $cs_news['news_public'] == 1 ? 'checked="checked"' : '';
  $data['news']['news_attached'] = $cs_news['news_attached'] == 1 ? 'checked="checked"' : '';
  $data['news']['check_publish'] = (!empty($cs_news['news_publishs_at']) ? 'checked="checked"' : '');
  $data['news']['news_publishs_at'] = cs_dateselect('date', 'unix', (!empty($cs_news['news_publishs_at']) ? $cs_news['news_publishs_at'] : cs_time()), 1995);

  echo cs_subtemplate(__FILE__, $data, 'news', 'create');
  
} else {
  
  $news_cells = array_keys($cs_news);
  $news_save = array_values($cs_news);
  cs_sql_insert(__FILE__, 'news', $news_cells, $news_save);
  
  cs_cache_delete('news_publish');

  if (!empty($cs_news['news_public']))
    include_once 'mods/news/rss.php';

  cs_redirect($cs_lang['news_created'], 'news');
}