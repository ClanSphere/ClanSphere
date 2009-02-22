<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanrooms');

$lanrooms_id = $_REQUEST['id'];
settype($lanrooms_id,'integer');


if(!empty($_POST['submit'])) {
  $cs_lanroomd['lanroomd_number'] = $_POST['lanroomd_number'];
  $cs_lanroomd['lanroomd_row'] = $_POST['lanroomd_row'];
  $cs_lanroomd['lanroomd_col'] = $_POST['lanroomd_col'];

  settype($cs_lanroomd['lanroomd_number'],'integer');
  settype($cs_lanroomd['lanroomd_row'],'integer');
  settype($cs_lanroomd['lanroomd_col'],'integer');

  $error = '';

  if(empty($cs_lanroomd['lanroomd_number']))
    $error .= $cs_lang['no_number'] . cs_html_br(1);
  if(empty($cs_lanroomd['lanroomd_row']))
    $error .= $cs_lang['no_row'] . cs_html_br(1);  
  if(empty($cs_lanroomd['lanroomd_col']))
    $error .= $cs_lang['no_col'] . cs_html_br(1);
  
  if(empty($lanrooms_id)) {
    $error .= $cs_lang['no_room_given'] . cs_html_br(1);
  }
  else {
    $where = "lanroomd_number = '" . $cs_lanroomd['lanroomd_number'] . "' AND lanrooms_id = '";
    $where .= $lanrooms_id . "'";
    $search_number = cs_sql_count(__FILE__,'lanroomd',$where);
    if(!empty($search_number)) {
      $error++;
      $error .= $cs_lang['number_used'] . cs_html_br(1);
    }
    $where = "lanroomd_row = '" . $cs_lanroomd['lanroomd_row'] . "' AND lanroomd_col = '";
    $where .= $cs_lanroomd['lanroomd_col'] . "' AND lanrooms_id = '" . $lanrooms_id . "'";
    $search_target = cs_sql_count(__FILE__,'lanroomd',$where);
    if(!empty($search_target)) {
      $error++;
      $error .= $cs_lang['target_used'] . cs_html_br(1);
    }
 }

  if(!empty($_POST['submit']) AND empty($error)) {
    $cs_lanroomd['lanrooms_id'] = $lanrooms_id;
    $lanroomd_cells = array_keys($cs_lanroomd);
  $lanroomd_save = array_values($cs_lanroomd);
  cs_sql_insert(__FILE__,'lanroomd',$lanroomd_cells,$lanroomd_save);
  $cs_lanroomd['lanroomd_number']++;
  }
}
else {
  $cs_lanroomd['lanroomd_number'] = 1;
  $cs_lanroomd['lanroomd_row'] = 1;
  $cs_lanroomd['lanroomd_col'] = 1;
}

if(!empty($_GET['remove'])) {
  settype($_GET['remove'],'integer');
  cs_sql_delete(__FILE__,'lanroomd',$_GET['remove']);
  $data['lang']['body'] = $cs_lang['remove_done'];
}
elseif(!isset($_POST['submit'])) {
  $data['lang']['body'] = $cs_lang['body_map'];
}
elseif(!empty($error)) {
  $data['lang']['body'] = $error;
}
else {
  $data['lang']['body'] = $cs_lang['content_done'];
}

$order = 'lanroomd_row DESC, lanroomd_col DESC';
$lanroomd = cs_sql_select(__FILE__,'lanroomd','*',"lanrooms_id = '" . $lanrooms_id . "'",$order,0,0);
$lanroomd_loop = count($lanroomd);

include('mods/lanrooms/functions.php');
$data['lan']['map'] = cs_lanroom('lanrooms','map',$lanrooms_id);

$data['url']['form'] = cs_url('lanrooms','map');

$data['lan']['number'] = $cs_lanroomd['lanroomd_number'];
$data['lan']['row'] = $cs_lanroomd['lanroomd_row'];
$data['lan']['col'] = $cs_lanroomd['lanroomd_col'];
$data['data']['id'] = $lanrooms_id;

if(empty($lanroomd_loop)) {
  $data['lanrooms'] = '';
}

for($run=0; $run<$lanroomd_loop; $run++) {
  $data['lanrooms'][$run]['number'] = $lanroomd[$run]['lanroomd_number'];
  $data['lanrooms'][$run]['row'] = $lanroomd[$run]['lanroomd_row'];
  $data['lanrooms'][$run]['col'] = $lanroomd[$run]['lanroomd_col'];
  $data['lanrooms'][$run]['remove'] = cs_link($cs_lang['remove'],'lanrooms','map','id=' . $lanrooms_id . '&amp;remove=' . $lanroomd[$run]['lanroomd_id']);
}

echo cs_subtemplate(__FILE__,$data,'lanrooms','map');
?>
