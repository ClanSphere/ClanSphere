<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanvotes');

$lanvotes_id = $_REQUEST['id'];
settype($lanvotes_id,'integer');

$cs_lanvotes = cs_sql_select(__FILE__,'lanvotes','*',"lanvotes_id = '" . $lanvotes_id . "'");

$where = "lanpartys_id = '" . $cs_lanvotes['lanpartys_id'] . "'";
$cs_lanpartys = cs_sql_select(__FILE__,'lanpartys','lanpartys_name, lanpartys_id',$where);

$cs_lan_name = cs_secure($cs_lanpartys['lanpartys_name']);
$data['lan']['name'] = cs_link($cs_lan_name,'lanpartys','view','id=' . $cs_lanpartys['lanpartys_id']);
$data['lan']['status'] = $cs_lang['status_' . $cs_lanvotes['lanvotes_status']];
$data['lan']['start'] = cs_date('unix',$cs_lanvotes['lanvotes_start'],1);
$data['lan']['end'] = cs_date('unix',$cs_lanvotes['lanvotes_end'],1);
$data['lan']['question'] = cs_secure($cs_lanvotes['lanvotes_question']);

$election = explode("\n", $cs_lanvotes['lanvotes_election']);
$election_count = count($election);

$fetch = "lanvotes_id = '" . $lanvotes_id . "'";
$voted = cs_sql_select(__FILE__,'lanvoted','lanvoted_answer, lanvotes_id',$fetch,0,0,0);
$voted_count = count($voted);
$answers_count = $voted_count;

if(empty($election_count)) {
  $data['election'] = '';
}

for($run = 0; $run < $election_count; $run++) {
  $answer_count = 0;
  for($run_2 = 0; $run_2 < $voted_count; $run_2++) {
    $voted_answer = $voted[$run_2]['lanvoted_answer'];
    $voted_fid = $voted[$run_2]['lanvotes_id'];
    
  if($voted_answer == $run + 1) {
      $answer_count++;
    }
  }
  
  $data['election'][$run]['question'] = $election[$run];
  if(!empty($voted_count)) {
    $answer_proz = $answer_count / $answers_count * 100;
  }
  else {
    $answer_proz = 0;
  }
  $answer_proz = round($answer_proz,1);
  
  if(!empty($answer_count)) {    
    $data['election'][$run]['end_img'] = cs_html_img('symbols/votes/vote02.png','13','2');
  }
  else {
    $data['election'][$run]['end_img'] = '';
  }
  
  $data['election'][$run]['percent'] = $answer_proz;
  $data['election'][$run]['count'] = $answer_count;
} 

echo cs_subtemplate(__FILE__,$data,'lanvotes','view');
?>