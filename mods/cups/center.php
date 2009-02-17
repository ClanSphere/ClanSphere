<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cups');

$get_memberships = cs_sql_select(__FILE__,'members','squads_id','users_id = \''.$account['users_id'].'\'',0,0,0);
$condition = '(cs.squads_id = \''.$account['users_id'].'\' AND cp.cups_system = \'users\')';
$matchcond = '';

if(!empty($get_memberships)) {

  $x = 0;
  $condition .= ' OR (';
  
  foreach($get_memberships AS $membership) {
    $x++;

    if ($x != 1) {
      $condition .= ' OR ';
      $matchcond .= ' OR ';
    }

    $condition .= 'squads_id = \''.$membership['squads_id'].'\' OR ';
    $condition .= 'squads_id = \''.$account['users_id'].'\'';
    $matchcond .= 'squad1_id = \''.$membership['squads_id'].'\' OR ';
    $matchcond .= 'squad2_id = \''.$membership['squads_id'].'\'';
    $squads[] = $membership['squads_id'];
  }
  $condition .= ')';
}


$tables = 'cupsquads cs INNER JOIN {pre}_cups cp ON cs.cups_id = cp.cups_id';
$cells  = 'cs.cups_id AS cups_id, cp.games_id AS games_id, cp.cups_name AS cups_name, ';
$cells .= 'cp.cups_system AS cups_system, cs.squads_id AS squads_id, cp.cups_start AS cups_start';
$select = cs_sql_select(__FILE__,$tables,$cells,$condition,0,0,0);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,2);
echo $cs_lang['mod'] .' - '. $cs_lang['center'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc');
echo sprintf($cs_lang['take_part_in_cups'],count($select));
echo cs_html_roco(2,'rightc');
echo cs_link($cs_lang['list'],'cups','list');
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

echo cs_getmsg();

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['game'];
echo cs_html_roco(2,'headb');
echo $cs_lang['name'];
echo cs_html_roco(3,'headb');
echo $cs_lang['next_match'];
echo cs_html_roco(0);

if(!empty($select)){
  
  foreach ($select AS $cup) {
  
    echo cs_html_roco(1,'leftb');
    if(file_exists('uploads/games/' . $cup['games_id'] . '.gif')) {
      echo cs_html_img('uploads/games/' . $cup['games_id'] . '.gif');
    }
    echo cs_html_roco(2,'leftb');
    echo cs_link($cup['cups_name'],'cups','view','id='.$cup['cups_id']);
    echo cs_html_roco(3,'leftb');
  
    $cond = $cup['cups_system'] == 'teams' ? $matchcond : 'squad1_id = \''.$account['users_id']
    .'\' OR squad2_id = \''.$account['users_id'].'\'';
    $cond .= ' AND cups_id = \''.$cup['cups_id'].'\'';
    $get_matchid = cs_sql_select(__FILE__,'cupmatches','cupmatches_id',$cond,'cupmatches_round ASC');
    if (!empty($get_matchid)) {
      echo cs_link($cs_lang['show'],'cups','match','id='.$get_matchid['cupmatches_id']);
    } else {
      echo $cs_lang['no_match_upcoming'];
    }
    echo cs_html_roco(0);
  }
}

echo cs_html_table(0);

?>