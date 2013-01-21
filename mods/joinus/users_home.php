<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('joinus');
$cs_option = cs_sql_option(__FILE__,'joinus');
$data = array();

$select = 'games_id, joinus_nick, joinus_age, joinus_since, joinus_id';
$cs_joinus = cs_sql_select(__FILE__,'joinus',$select,0,'joinus_since DESC',0,$cs_option['max_usershome']);
$join_loop = count($cs_joinus);

if(!empty($cs_joinus)) {
  for($run=0; $run < $join_loop; $run++) {
    if(!empty($cs_joinus[$run]['games_id'])) {
        $data['join'][$run]['game'] = cs_html_img('uploads/games/' . $cs_joinus[$run]['games_id'] . '.gif');
      }else{$data['join'][$run]['game'] = '-';}
    $data['join'][$run]['nick'] = cs_link(cs_secure($cs_joinus[$run]['joinus_nick']),'joinus','view','id=' . $cs_joinus[$run]['joinus_id']);
    
    $birth = explode ('-', $cs_joinus[$run]['joinus_age']);
    $age = cs_datereal('Y') - $birth[0];
    if(cs_datereal('m')<=$birth[1]) { $age--; }
    if(cs_datereal('d')>=$birth[2] AND cs_datereal('m')==$birth[1]) { $age++; }
    $data['join'][$run]['age'] = $age;
    
    $data['join'][$run]['since'] = cs_date('unix',$cs_joinus[$run]['joinus_since'],1);
  }
  echo cs_subtemplate(__FILE__,$data,'joinus','users_home');
}
