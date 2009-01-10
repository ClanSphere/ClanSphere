<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cups');

$cups_id = empty($_POST['cups_id']) ? $_GET['id'] : $_POST['cups_id'];
settype($cups_id,'integer');

$cs_cup = cs_sql_select(__FILE__,'cups','cups_start, cups_system, cups_teams',"cups_id = '" . $cups_id . "'");
$started = cs_sql_count(__FILE__,'cupmatches','cups_id = \''.$cups_id.'\'');
$joined = cs_sql_count(__FILE__,'cupsquads','cups_id = \''.$cups_id.'\'');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['join'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc');

$form = 1;
$full = 0;

if ($joined >= $cs_cup['cups_teams']) {
  $full = 1;
}

if ($cs_cup['cups_system'] == 'teams' && empty($full)) {
  $membership = cs_sql_count(__FILE__,'members',"users_id = '" . $account['users_id'] . "' AND members_admin = '1'");
  
  if(!empty($membership)) {
    $tables = 'cupsquads cs INNER JOIN {pre}_members mem ON cs.squads_id = mem.squads_id';
    $where = "mem.users_id = '" . $account['users_id'] . "' AND cs.cups_id = '" . $cups_id . "'";
    $participant = cs_sql_count(__FILE__,$tables,$where);
  }
} elseif(empty($full)) {
  $membership = 1;
  $participant = cs_sql_count(__FILE__,'cupsquads','cups_id = \''.$cups_id.'\' AND squads_id = \''.$account['users_id'].'\'');
}

if($account['access_cups'] >= 2 && cs_time() < $cs_cup['cups_start'] && empty($started) && empty($full)) {
  if(!empty($participant)) {
    $content = $cs_lang['join_done'];
    $form = 0;
  }
  elseif(empty($membership)) {
    $content = cs_link($cs_lang['need_squad'],'squads','center');
    $form = 0;
  }
  elseif(empty($_POST['submit'])) {
    
    if ($cs_cup['cups_system'] == 'teams') {
        
    	echo $cs_lang['which_squad'];
    	echo cs_html_roco(0);
    	echo cs_html_table(0);
    	echo cs_html_br(1);
  
    	$tables = 'members mm INNER JOIN {pre}_squads sq ON mm.squads_id = sq.squads_id';
    	$cells = 'mm.squads_id AS squads_id, sq.squads_name AS squads_name';
      $where = 'mm.members_admin = \'1\' AND mm.users_id = \'' . $account['users_id'] . '\'';
    	$select = cs_sql_select(__FILE__,$tables,$cells,$where,'sq.squads_name',0,0);
  
    	echo cs_html_form(1,'cupsjoin','cups','join');
    	echo cs_html_table(1,'forum',1);
    	echo cs_html_roco(1,'leftc');
    	echo cs_icon('yast_group_add') . $cs_lang['squad'];
    	echo cs_html_roco(2,'leftb');
    	echo cs_html_select(1,'squads_id');
    	echo cs_html_option('----',0,1);
    	foreach ($select AS $squad) {
    		echo cs_html_option($squad['squads_name'],$squad['squads_id']);
    	}
    	echo cs_html_select(0);
    	echo cs_html_roco(0);
      
      echo cs_html_roco(1,'leftc');
    	echo cs_icon('configure') . $cs_lang['options'];
    	echo cs_html_roco(2,'leftb');
    	echo cs_html_vote('cups_id',$cups_id,'hidden');
      echo cs_html_vote('system','teams','hidden');
    	echo cs_html_vote('submit',$cs_lang['take_part'],'submit');
    	echo cs_html_roco(0);
    	echo cs_html_table(0);
    	echo cs_html_form(0);
        
    } else {
    
      echo $cs_lang['really'];
      echo cs_html_roco(0);
      echo cs_html_roco(1,'centerb');
      echo cs_html_form(1,'cupsjoin','cups','join');
      echo cs_html_vote('cups_id',$cups_id,'hidden');
      echo cs_html_vote('system','users','hidden');
      echo cs_html_vote('submit',$cs_lang['confirm'],'submit');
      echo cs_html_form(0);
      echo cs_html_roco(0);
      echo cs_html_table(0);
      
    }
    
  } else {
  	
  	$cs_cups['cupsquads_time'] = cs_time();
    
    if ($_POST['system'] == 'teams') {
      
      $cs_cups['squads_id'] = (int) $_POST['squads_id'];
      
    	$cond = 'squads_id = \''.$cs_cups['squads_id'].'\' AND users_id = \''.$account['users_id'].'\' AND members_admin = \'1\'';
    	$access = cs_sql_count(__FILE__,'members',$cond);
    } else {
      $access = ($account['access_cups'] >= 2) ? 1 : 0;
      $cs_cups['squads_id'] = $account['users_id'];
      
    }
  
  	if(!empty($access)) {
      $cs_cups['cups_id'] = $cups_id;
  		$cells = array_keys($cs_cups);
  		$values = array_values($cs_cups);
  		cs_sql_insert(__FILE__,'cupsquads',$cells,$values);
  		$msg = $cs_lang['successfully_joined'];
  	} else {
  		$msg = $cs_lang['no_access'];
  	}

	cs_redirect($msg,'cups','center');
  }

} else {
  $content =  empty($full) ? $cs_lang['no_access'] : $cs_lang['cup_full'];
  $form = 0;
}
if(empty($form)) {
  echo $content;
	echo cs_html_roco(0);
	echo cs_html_table(0);
}

?>