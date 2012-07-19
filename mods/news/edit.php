<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('news');
$cs_post = cs_post('id');
$cs_get = cs_get('id');

$news_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $news_id = $cs_post['id'];

require_once('mods/categories/functions.php');
$news_newtime = 0;

$op_news = cs_sql_option(__FILE__,'news');
$abcode = explode(",",$op_news['abcode']);
$data['op']['features'] = empty($abcode[0]) ? $cs_lang['no'] : $cs_lang['yes'];
$data['op']['smileys'] = empty($abcode[1]) ? $cs_lang['no'] : $cs_lang['yes'];
$data['op']['clip'] = empty($abcode[2]) ? $cs_lang['no'] : $cs_lang['yes'];
$data['op']['html'] = empty($abcode[3]) ? $cs_lang['no'] : $cs_lang['yes'];
$data['op']['php'] = empty($abcode[4]) ? $cs_lang['no'] : $cs_lang['yes'];

$data['if']['preview'] = false;
$data['if']['no_readmore'] = true;


if(isset($_POST['submit']) or isset($_POST['preview'])) {
  $cs_news['categories_id'] = empty($_POST['categories_name']) ? (int)$_POST['categories_id'] : cs_categories_create('news', $_POST['categories_name']);
  $cs_news['news_close'] = isset($_POST['news_close']) ? (int)$_POST['news_close'] : 0;
  $cs_news['news_public'] = isset($_POST['news_public']) ? (int)$_POST['news_public'] : 0;
  $cs_news['news_attached'] = isset($_POST['news_attached']) ? (int)$_POST['news_attached'] : 0;
  $cs_news['news_headline'] = $_POST['news_headline'];
  $cs_news['users_id'] = $_POST['users_id'];
  $cs_news['news_publishs_at'] = isset($_POST['publish_at']) ? (int)cs_datepost('date', 'unix') : 0;
  $cs_news['news_readmore_active'] = isset($_POST['news_readmore_active']) ? (int)$_POST['news_readmore_active'] : 0;
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
      $cs_news["news_mirror"] = $cs_news["news_mirror"] . "\n" . $_POST["news_mirror_$num"];
      $cs_news["news_mirror_name"] = $cs_news["news_mirror_name"] . "\n" . $_POST["news_mirror_name_$num"];
    }
  }

  if (!empty($_POST['news_newtime'])) {
    $cs_news['news_time'] = cs_time();
    $news_newtime = 1;
  }

  $error = 0;
  $errormsg = '';

  if(empty($cs_news['categories_id'])) {
    $error++;
    $errormsg .= $cs_lang['no_cat'] . cs_html_br(1);
  }
  if(empty($cs_news['news_headline'])) {
    $error++;
    $errormsg .= $cs_lang['no_headline'] . cs_html_br(1);
  }
  if(empty($cs_news['news_text'])) {
    $error++;
    $errormsg .= $cs_lang['no_text'] . cs_html_br(1);
  }
}
else {
  $cells = 'news_id, categories_id, news_headline, news_text, users_id, news_time, news_close, news_public,';
  $cells .= 'news_attached, news_id, news_publishs_at, news_mirror, news_mirror_name, news_readmore, news_readmore_active';
  $cs_news = cs_sql_select(__FILE__, 'news', $cells, "news_id = '" . $news_id . "'");
}

if(!isset($_POST['submit']) and !isset($_POST['preview'])) {
  $data['head']['body'] = $cs_lang['head_body'];
}
elseif (!empty($error)) {
  $data['head']['body'] = $errormsg;
}
elseif (isset($_POST['preview'])) {
  $data['head']['body'] = $cs_lang['preview'];
}
else {
  $data['head']['body'] = $cs_lang['changes_done'];
}

if(isset($_POST['preview']) and empty($error)) {
  $data['news']['news_time'] = cs_date('unix', cs_time(), 1);
  $data['news']['preview_news_text'] = cs_secure($cs_news['news_text'], $abcode[0], $abcode[1], $abcode[2], $abcode[3], $abcode[4]);

  $data['if']['readmore'] = false;

  if(!empty($cs_news['news_readmore'])) {
    $data['if']['readmore'] = true;
    $data['news']['preview_news_readmore'] = cs_secure($cs_news['news_readmore'], $abcode[0], $abcode[1], $abcode[2], $abcode[3], $abcode[4]) . cs_html_br(2);
  }

  $search = 'users_id = ' . $cs_news['users_id'];
  $cs_news_user = cs_sql_select(__FILE__, 'users', 'users_nick, users_active', $search);
  $data['news']['users_link'] = cs_user($cs_news['users_id'], $cs_news_user['users_nick'], $cs_news_user['users_active']);

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

    $temp_mirror = explode("\n", $cs_news['news_mirror']);
    $temp_mirror_name = explode("\n", $cs_news['news_mirror_name']);

    $prev_run = 0;
    for($run=1; $run < count($temp_mirror); $run++) {
      $num = $run;

      if($run == (count($temp_mirror) - 1)) {
        $data['prev_mirror'][$prev_run]['dot'] =  '';
      }
      elseif(!empty($run)) {
        $data['prev_mirror'][$prev_run]['dot'] =  ' - ';
      }
      else {
        $data['prev_mirror'][$prev_run]['dot'] =  ' - ';
      }

      $data['prev_mirror'][$prev_run]['news_mirror'] = cs_html_link($temp_mirror[$run],$temp_mirror_name[$run]);
      $prev_run++;
    }
  }

  $data['if']['preview'] = true;
}

if(isset($_POST['mirror'])) {
  $data['news']['categories_id'] = empty($_POST['categories_name']) ? (int)$_POST['categories_id'] : cs_categories_create('news', $_POST['categories_name']);
  $data['news']['news_close'] = isset($_POST['news_close']) ? (int)$_POST['news_close'] : 0;
  $data['news']['news_public'] = isset($_POST['news_public']) ? (int)$_POST['news_public'] : 0;
  $data['news']['news_attached'] = isset($_POST['news_attached']) ? (int)$_POST['news_attached'] : 0;
  $data['news']['news_headline'] = $_POST['news_headline'];
  $data['news']['users_id'] = $_POST['users_id'];
  $data['news']['news_publishs_at'] = isset($_POST['publish_at']) ? (int)cs_datepost('date', 'unix') : 0;
  $data['news']['news_readmore_active'] = isset($_POST['news_readmore_active']) ? (int)$_POST['news_readmore_active'] : 0;
  $data['if']['no_readmore'] = isset($_POST['news_readmore_active']) ? false : true;
  $data['news']['news_text'] = empty($cs_main['rte_html']) ? $_POST['news_text'] : cs_abcode_inhtml($_POST['news_text'], 'add');
  $data['news']['news_readmore'] = empty($cs_main['rte_html']) ? $_POST['news_readmore'] : cs_abcode_inhtml($_POST['news_readmore'], 'add');

  $_POST['run_loop']++;
}

if(!empty($error) or isset($_POST['preview']) or !isset($_POST['submit'])) {
  $data['categories']['dropdown'] = cs_categories_dropdown('news',$cs_news['categories_id']);

  $data['news']['news_headline'] = cs_secure($cs_news['news_headline']);
  $data['news']['news_readmore'] = cs_secure($cs_news['news_readmore']);
  $data['news']['news_text'] = cs_secure($cs_news['news_text']);
  $data['news']['users_id'] = (int) $cs_news['users_id'];

  if(isset($_POST['mirror'])) {
    $run_loop = isset($_POST['run_loop']) ? $_POST['run_loop'] : 1;
  }
  else {
    $temp_mirror = explode("\n", $cs_news['news_mirror']);
    $temp_mirror_name = explode("\n", $cs_news['news_mirror_name']);

    $run_loop = count($temp_mirror);
  }

  $tpl_run = 0;

  if(empty($cs_news['news_mirror'])) {
    $run = 0;
  }
  else {
    $run = 1;
  }

  for($run; $run < $run_loop; $run++) {
    if(empty($cs_news['news_mirror'])) {
      $num = $run+1;
    }
    else {
      $num = $run;
    }

    if(isset($_POST['mirror'])) {
      $cs_news["news_mirror_$num"] = isset($_POST["news_mirror_$num"]) ? $_POST["news_mirror_$num"] : '';
      $cs_news["news_mirror_name_$num"] = isset($_POST["news_mirror_name_$num"]) ? $_POST["news_mirror_name_$num"] : '';
    }
    else {
      $cs_news["news_mirror_$num"] = $temp_mirror[$run];
      $cs_news["news_mirror_name_$num"] = $temp_mirror_name[$run];
    }

    $data['mirror'][$tpl_run]['num'] = $num;
    $data['mirror'][$tpl_run]['news_mirror'] = $cs_news["news_mirror_$num"];
    $data['mirror'][$tpl_run]['news_mirror_name'] = $cs_news["news_mirror_name_$num"];
    $tpl_run++;
  }

  if(empty($cs_main['rte_html'])) {
    $data['abcode']['features'] = cs_abcode_features('news_text', $abcode[3]);
    $data['abcode']['smileys'] = cs_abcode_smileys('news_text');
    $data['abcode']['features_readmore'] = cs_abcode_features('news_readmore', $abcode[3]);
    $data['abcode']['smileys_readmore'] = cs_abcode_smileys('news_readmore');
    $data['if']['rte_html'] = false;
    $data['if']['abcode'] = true;
  }
  else {
    $data['if']['rte_html'] = true;
    $data['if']['abcode'] = false;
    $data['rte']['html'] = cs_rte_html('news_text', $cs_news['news_text']);
    $data['rte']['html_readmore'] = cs_rte_html('news_readmore', $cs_news['news_readmore']);
  }

  $data['news']['news_id'] = $news_id;
  $data['news']['loop'] = $run_loop;
  $data['news']['news_readmore_active'] = $cs_news['news_readmore_active'] == 1 ? 'checked="checked"' : '';
  $data['news']['news_close'] = $cs_news['news_close'] == 1 ? 'checked="checked"' : '';
  $data['news']['news_public'] = $cs_news['news_public'] == 1 ? 'checked="checked"' : '';
  $data['news']['news_attached'] = $cs_news['news_attached'] == 1 ? 'checked="checked"' : '';
  $data['news']['check_publish'] = (!empty($cs_news['news_publishs_at']) ? 'checked="checked"' : '');
  $data['news']['news_publishs_at'] = cs_dateselect('date', 'unix', (!empty($cs_news['news_publishs_at']) ? $cs_news['news_publishs_at'] : cs_time()), 1995);
  $data['if']['no_readmore'] = !empty($data['news']['news_readmore_active']) ? false : true;

  echo cs_subtemplate(__FILE__, $data, 'news', 'edit');
}
else {
  $news_cells = array_keys($cs_news);
  $news_save = array_values($cs_news);
  cs_sql_update(__FILE__, 'news', $news_cells, $news_save, $news_id);
  
  cs_cache_delete('news_publish');

  if(!empty($cs_news['news_public'])) {
    include_once('mods/news/rss.php');
  }

  cs_redirect($cs_lang['changes_done'], 'news');
}