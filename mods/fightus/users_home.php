<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('fightus');
$cs_option = cs_sql_option(__FILE__,'fightus');
$data = array();

$select = 'games_id, fightus_clan, fightus_date, fightus_since, fightus_id';
$cs_fightus = cs_sql_select(__FILE__,'fightus',$select,0,'fightus_since DESC',0,$cs_option['max_usershome']);

if(!empty($cs_fightus)) {

  $run = 0;
  foreach($cs_fightus AS $fight) {
    $data['fightus'][$run]['game'] = '-';
    if(!empty($fight['games_id'])) {
      $data['fightus'][$run]['game'] = cs_html_img('uploads/games/' . $fight['games_id'] . '.gif');
    }
    $data['fightus'][$run]['url_view'] = cs_url('fightus','view','id=' . $fight['fightus_id']);
    $data['fightus'][$run]['clan'] = cs_secure($fight['fightus_clan']);
    $data['fightus'][$run]['date'] = cs_date('unix',$fight['fightus_date']);
    $data['fightus'][$run]['since'] = cs_date('unix',$fight['fightus_since'],1);
    $run++;
  }
  echo cs_subtemplate(__FILE__,$data,'fightus','users_home');
}
