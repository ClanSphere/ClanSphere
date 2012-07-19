<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('ranks');
$data = array();

$cs_ranks['ranks_name'] = '';
$cs_ranks['squads_id'] = '';
$cs_ranks['ranks_url'] = '';
$cs_ranks['ranks_img'] = '';
$cs_ranks['ranks_code'] = '';

if(isset($_POST['submit'])) {

  $cs_ranks['ranks_name'] = $_POST['ranks_name'];
  $cs_ranks['squads_id'] = $_POST['squads_id'];
  $cs_ranks['ranks_url'] = $_POST['ranks_url'];
  $cs_ranks['ranks_img'] = $_POST['ranks_img'];
  $cs_ranks['ranks_code'] = $_POST['ranks_code'];

  $error = '';

  if(empty($cs_ranks['ranks_name']))
    $error .= $cs_lang['no_name'] . cs_html_br(1);
  if(empty($cs_ranks['ranks_url']) AND empty($cs_ranks['ranks_code']))
    $error .= $cs_lang['no_url'] . cs_html_br(1);
  if(empty($cs_ranks['ranks_img']) AND empty($cs_ranks['ranks_code']))
    $error .= $cs_lang['no_img'] . cs_html_br(1);
  
  $where = "ranks_name = '" . cs_sql_escape($cs_ranks['ranks_name']) . "'";
  $search = cs_sql_count(__FILE__,'ranks',$where);
  if(!empty($search))
    $error .= $cs_lang['rank_exists'] . cs_html_br(1);
}

if(!isset($_POST['submit']))
  $data['head']['body'] = $cs_lang['body_create'];
elseif(!empty($error))
  $data['head']['body'] = $error;

if(!empty($error) OR !isset($_POST['submit'])) {

  $data['ranks'] = $cs_ranks;

  $data_squads = cs_sql_select(__FILE__,'squads','squads_name,squads_id',0,'squads_name',0,0);
  $data['squads'] = cs_dropdownsel($data_squads, $cs_ranks['squads_id'], 'squads_id');

 echo cs_subtemplate(__FILE__,$data,'ranks','create');
}
else {

  $ranks_cells = array_keys($cs_ranks);
  $ranks_save = array_values($cs_ranks);
 cs_sql_insert(__FILE__,'ranks',$ranks_cells,$ranks_save);
  
 cs_redirect($cs_lang['create_done'],'ranks');
}