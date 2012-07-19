<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('awards');

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'awards_time DESC';
$cs_sort[2] = 'awards_time ASC';
$cs_sort[3] = 'awards_rank DESC';
$cs_sort[4] = 'awards_rank ASC';
$cs_sort[5] = 'awards_event DESC';
$cs_sort[6] = 'awards_event ASC';
$cs_sort[7] = 'games_name DESC';
$cs_sort[8] = 'games_name ASC';
$cs_sort[9] = 'squads_name DESC';
$cs_sort[10] = 'squads_name ASC';

settype($_REQUEST['sort'],'integer'); 
$sort = empty($_REQUEST['sort']) ? 1 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$awards_count = cs_sql_count(__FILE__,'awards');

$data['awards'] = array();

$data['head']['all'] = sprintf($cs_lang['all'], $awards_count);
$data['head']['pages'] = cs_pages('awards','list',$awards_count,$start,0,$sort);

$data['sort']['date'] = cs_sort('awards','list',$start,0,1,$sort);
$data['sort']['event'] = cs_sort('awards','list',$start,0,5,$sort);
$data['sort']['place'] = cs_sort('awards','list',$start,0,3,$sort);
$data['sort']['game'] = cs_sort('awards','list',$start,0,7,$sort);
$data['sort']['squad'] = cs_sort('awards','list',$start,0,9,$sort);

$from = 'awards aws INNER JOIN {pre}_games gms ON aws.games_id = gms.games_id LEFT JOIN {pre}_squads sqd ON sqd.squads_id = aws.squads_id';
$select = 'aws.awards_id AS awards_id, aws.awards_time AS awards_time, aws.awards_event AS awards_event, aws.awards_event_url AS awards_event_url,';
$select .= ' aws.games_id AS games_id, aws.awards_rank AS awards_rank, gms.games_name AS games_name, sqd.squads_name AS squads_name,';
$select .= ' sqd.squads_id AS squads_id';
$cs_awards = cs_sql_select(__FILE__,$from,$select,0,$order,$start,$account['users_limit']);
$awards_loop = count($cs_awards);

for($run=0; $run<$awards_loop; $run++) {

  $data['awards'][$run]['awards_id'] = $cs_awards[$run]['awards_id'];
  $data['awards'][$run]['awards_time'] = cs_date('date',$cs_awards[$run]['awards_time']);
  $data['awards'][$run]['awards_event'] = cs_secure($cs_awards[$run]['awards_event']);
  $data['awards'][$run]['awards_event_url'] = $cs_awards[$run]['awards_event_url'];
  $data['awards'][$run]['awards_game_name'] = cs_secure($cs_awards[$run]['games_name']);
  $data['awards'][$run]['squads_name'] = cs_secure($cs_awards[$run]['squads_name']);
  $data['awards'][$run]['awards_game_id'] = $cs_awards[$run]['games_id'];
  $data['awards'][$run]['squads_id'] = $cs_awards[$run]['squads_id'];
  
  $cs_awards_place = $cs_awards[$run]['awards_rank'];
  if ($cs_awards_place == 1){
  $data['awards'][$run]['awards_place'] = cs_html_img("symbols/awards/pokal_gold.png"); } else if ($cs_awards_place == 2) {
  $data['awards'][$run]['awards_place'] = cs_html_img ("symbols/awards/pokal_silber.png"); } else if ($cs_awards_place == 3) {
  $data['awards'][$run]['awards_place'] = cs_html_img ("symbols/awards/pokal_bronze.png"); } else if ($cs_awards_place >= 4) {
  $data['awards'][$run]['awards_place'] = cs_secure($cs_awards[$run]['awards_rank']);
  }
  
}/*
$data['awards'] = $cs_awards;*/
echo cs_subtemplate(__FILE__,$data,'awards','list');