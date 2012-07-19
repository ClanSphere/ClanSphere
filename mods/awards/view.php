<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('awards');

$cs_awards_id = $_GET['id'];
settype($cs_awards_id,'integer');
$cs_awards = cs_sql_select(__FILE__,'awards','*',"awards_id = '" . $cs_awards_id . "'");

$cs_awards_id = $cs_awards['games_id'];
$cs_awards_game = cs_sql_select(__FILE__,'games','*',"games_id = '" . $cs_awards_id . "'");

$data['awards']['event'] = cs_secure($cs_awards['awards_event']);
$data['awards']['date'] = cs_date('date',$cs_awards['awards_time']);
$data['awards']['place'] = cs_secure($cs_awards['awards_rank']) . '. ' . $cs_lang['place']; 
$data['awards']['game'] = cs_secure($cs_awards_game['games_name']);

echo cs_subtemplate(__FILE__,$data,'awards','view');