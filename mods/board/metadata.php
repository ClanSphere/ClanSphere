<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

$data = array();

if(isset($_POST['agree'])) {

  include 'mods/board/repair.php';
  
  cs_repair_board();

  cs_redirect($cs_lang['repair_true'], 'board');
}
elseif(isset($_POST['cancel'])) {

  cs_redirect($cs_lang['repair_false'], 'board');
}

echo cs_subtemplate(__FILE__,$data,'board','metadata');