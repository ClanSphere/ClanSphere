<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$nav_array = array(
  '----',
  'ajax/navaddthis',
  'ajax/navbookmark',
  'articles/navlist',
  'articles/navtop',
  'banners/navlist',
  'banners/navright',
  'banners/rotation',
  'board/navlist',
  'board/navtop',
  'board/navtop2',
  'buddys/navlist',
  'count/navall',
  'count/navday',
  'count/navmon',
  'count/navone',
  'count/navusr',
  'count/navyes',
  'events/nav_birthday',
  'events/navcal',
  'events/navnext',
  'files/navlist',
  'files/navtop',
  'gallery/navlist',
  'members/navrand',
  'news/navlist',
  'partner/navlist',
  'ranks/navlist',
  'replays/navlist',
  'search/navlist',
  'servers/navlist',
  'servers/navrandom',
  'shoutbox/navlist',
  'users/navbirth',
  'users/navlang',
  'users/navlang2',
  'users/navlast',
  'users/navonline',
  'users/navonline_ava',
  'users/navonline_pic',
  'users/navrand',
  'users/nextbirth',
  'votes/navlist',
  'wars/navdraw',
  'wars/navlast',
  'wars/navlist',
  'wars/navlist2',
  'wars/navlost',
  'wars/navnext',
  'wars/navtop',
  'wars/navwon'
);

$cs_lang = cs_translate('clansphere');

if(isset($_REQUEST['debug_navfile']))
  if($_REQUEST['debug_navfile'] == 'none')
    $_SESSION['debug_navfile'] = 0;
  else
    $_SESSION['debug_navfile'] = (int) $_REQUEST['debug_navfile'];

if(empty($_SESSION['debug_navfile'])) {

  $data = array();
  $data['form']['url'] = cs_url($cs_main['def_mod'], $cs_main['def_action'], $cs_main['def_parameters']);
  foreach($nav_array AS $num => $value) {
    $data['navfiles'][$num]['value'] = $value;
    $data['navfiles'][$num]['num'] = $num;
  }

  echo cs_subtemplate(__FILE__,$data,'clansphere','navdebug');
}
else {

  $nav_file = $nav_array[$_SESSION['debug_navfile']];
  $remove = cs_link($cs_lang['remove'], $cs_main['def_mod'], $cs_main['def_action'], 'debug_navfile=none');
  echo $nav_file . ' [ ' . $remove . ' ]' . cs_html_br(2);
  include 'mods/' . $nav_file . '.php';
}