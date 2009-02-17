<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanvotes');

$lanvotes_id = $_REQUEST['id'];
settype($lanvotes_id,'integer');


$lvs = cs_sql_select(__FILE__,'lanvotes','*',"lanvotes_id = '" . $lanvotes_id . "'");
$lan = "lanpartys_id = '" . $lvs['lanpartys_id'] . "' AND users_id = '" . $account['users_id'] . "'";
$lgu = cs_sql_select(__FILE__,'languests','*',$lan);

if(empty($lgu['languests_status']) OR $lgu['languests_status'] != $lvs['lanvotes_status']) {
  $data['lang']['body'] = $cs_lang['not_allowed'];
  
  echo cs_subtemplate(__FILE__,$data,'lanvotes','error');
}
elseif($lvs['lanvotes_start'] > cs_time() OR $lvs['lanvotes_end'] < cs_time()) {
  $data['lang']['body'] = $cs_lang['not_running'];
  
  echo cs_subtemplate(__FILE__,$data,'lanvotes','error');
}
else {
  $get_voted = "lanvotes_id = '" . $lanvotes_id . "' AND users_id = '" . $account['users_id'] . "'";
  $cs_lanvoted = cs_sql_select(__FILE__,'lanvoted','*',$get_voted);

  if(empty($cs_lanvoted['lanvoted_answer'])) {
    $cs_lanvoted['lanvoted_answer'] = 0;
  }
  
  if(isset($_POST['submit'])) {
    $cs_lanvoted['lanvoted_answer'] = empty($_POST['lanvoted_answer']) ? 0 : $_POST['lanvoted_answer'];

    $error = 0;
    $errormsg = '';

    if(empty($cs_lanvoted['lanvoted_answer'])) {
      $error++;
      $errormsg .= $cs_lang['no_answer'] . cs_html_br(1);
  }
  }
  
  if(!isset($_POST['submit'])) {
    $data['lang']['body'] = $cs_lang['body_elect'];
  }
  
  if(!empty($error)) {
    $data['lang']['body'] = $errormsg;
  }

  if(!empty($error) OR !isset($_POST['submit'])) {
    $data['data']['id'] = $lanvotes_id;
  $data['url']['form'] = cs_url('lanvotes','elect');

    $data['votes']['question'] = cs_secure($lvs['lanvotes_question']);

    $election = explode("\n", $lvs['lanvotes_election']);
  $answers_stop = count($election);
  for($run = 0; $run < $answers_stop; $run++) {
      $run2 = $run + 1;
    $sel = ($run2 == $cs_lanvoted['lanvoted_answer'] ? 1 : 0);
    $new = $run + 1;
    $data['lan'][$run]['answer'] = cs_html_vote('lanvoted_answer',$new,'radio',$sel) . ' ' . cs_secure($election[($run)]);
    }
  
  echo cs_subtemplate(__FILE__,$data,'lanvotes','elect');
  }
  else {
    if(empty($cs_lanvoted['lanvoted_id'])) {
      $cs_lanvoted['lanvotes_id'] = $lanvotes_id;
      $cs_lanvoted['users_id'] = $account['users_id'];
      $cs_lanvotes['lanvoted_since'] = cs_time();

      $lanvoted_cells = array_keys($cs_lanvoted);
      $lanvoted_save = array_values($cs_lanvoted);
      cs_sql_insert(__FILE__,'lanvoted',$lanvoted_cells,$lanvoted_save);
    }
    else {
      $lanvoted_cells = array_keys($cs_lanvoted);
      $lanvoted_save = array_values($cs_lanvoted);
      cs_sql_update(__FILE__,'lanvoted',$lanvoted_cells,$lanvoted_save,$cs_lanvoted['lanvoted_id']);
    }
  
  cs_redirect($cs_lang['elect_done'],'lanvotes','manage');
  }
}
?>
