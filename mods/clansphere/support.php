<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clansphere');

$data = array();

$data['support'] = array(
  0 => array(
    'url' => 'board.clansphere.net',
    'name' => $cs_lang['name_board'],
    'text' => $cs_lang['text_board'],
  ),
  1 => array(
    'url' => 'bugs.clansphere.net',
    'name' => $cs_lang['name_bugs'],
    'text' => $cs_lang['text_bugs'],
  ),
  2 => array(
    'url' => 'contact.clansphere.net',
    'name' => $cs_lang['name_contact'],
    'text' => $cs_lang['text_contact'],
  ),
  3 => array(
    'url' => 'design.clansphere.net',
    'name' => $cs_lang['name_design'],
    'text' => $cs_lang['text_design'],
  ),
  4 => array(
    'url' => 'lang.clansphere.net',
    'name' => $cs_lang['name_lang'],
    'text' => $cs_lang['text_lang'],
  ),
  5 => array(
    'url' => 'mods.clansphere.net',
    'name' => $cs_lang['name_mods'],
    'text' => $cs_lang['text_mods'],
  ),
  6 => array(
    'url' => 'vcs.clansphere.net',
    'name' => $cs_lang['name_vcs'],
    'text' => $cs_lang['text_vcs'],
  ),
  7 => array(
    'url' => 'wiki.clansphere.net',
    'name' => $cs_lang['name_wiki'],
    'text' => $cs_lang['text_wiki'],
  )
);

echo cs_subtemplate(__FILE__,$data,'clansphere','support');