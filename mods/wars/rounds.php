<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('wars');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['rounds'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc');

if (!empty($_GET['up']) || !empty($_GET['down'])) {
  
  $warid = (int) $_GET['id'];
  $roundid = !empty($_GET['up']) ? (int) $_GET['up'] : $_GET['down'];
  
  $round = cs_sql_select(__FILE__,'rounds','rounds_order','rounds_id = \''.$roundid.'\'');
  
  $new_order = !empty($_GET['up']) ? $round['rounds_order'] - 1 : $round['rounds_order'] + 1;
  $where = 'wars_id = \'' . $warid . '\' AND rounds_order = \'' . $new_order . '\'';
  $round_old = cs_sql_select(__FILE__,'rounds','rounds_id',$where);
  
  $cells = array('rounds_order');
  
  if (empty($round_old)) {
  
    $rounds = cs_sql_select(__FILE__,'rounds','rounds_id','wars_id = \''.$warid.'\'','rounds_id ASC',0,0);
    $count_rounds = count($rounds);
    for ($run = 0; $run < $count_rounds; $run++) {
      $values = array($run + 1);
      cs_sql_update(__FILE__,'rounds', $cells, $values, $rounds[$run]['rounds_id']);
    }
    
    $round = cs_sql_select(__FILE__,'rounds','rounds_order','rounds_id = \''.$roundid.'\'');
    $new_order = !empty($_GET['up']) ? $round['rounds_order'] - 1 : $round['rounds_order'] + 1;
    $where = 'wars_id = \'' . $warid . '\' AND rounds_order = \'' . $new_order . '\'';
    $round_old = cs_sql_select(__FILE__,'rounds','rounds_id',$where);
  
  }
  
  $values = array($round['rounds_order']);
  cs_sql_update(__FILE__,'rounds', $cells, $values, $round_old['rounds_id']);
  
  $values = array($new_order);
  cs_sql_update(__FILE__,'rounds', $cells, $values, $roundid);   
  
}

if (empty($_POST['submit'])) {
	
	$id = (int) $_GET['id'];
	
	$cs_wars = cs_sql_select(__FILE__,'wars','games_id','wars_id = \''.$id.'\'');

	echo $cs_lang['rounds_management'];
	echo ' ' . cs_link($cs_lang['back'],'wars','manage');
	echo cs_html_roco(0);
	echo cs_html_table(0);
	echo cs_html_br(1);
	
	echo cs_html_form(1,'roundadd','wars','rounds');
	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'headb',0,2);
	echo $cs_lang['new_round'];
	echo cs_html_roco(0);
	echo cs_html_roco(1,'leftc');
	echo cs_icon('atlantikdesigner') . $cs_lang['map'] . ' *';
	echo cs_html_roco(2,'leftb');
	echo cs_html_select(1,'maps_id');
	echo cs_html_option('----',0,1);
	$cs_maps = cs_sql_select(__FILE__,'maps','maps_name, maps_id','games_id = \''.$cs_wars['games_id'].'\'','maps_name',0,0);
	if(!empty($cs_maps)) {
		foreach ($cs_maps AS $map) {
			echo cs_html_option($map['maps_name'],$map['maps_id']);
		}
	}
	echo cs_html_select(0) . ' - ' . cs_html_input('new_map','','text');
	echo cs_html_roco(0);
	echo cs_html_roco(1,'leftc');
	echo cs_icon('smallcal') . $cs_lang['result'] . ' *';
	echo cs_html_roco(2,'leftb');
	echo cs_html_input('score1','','text',8,5) . ' : ' . cs_html_input('score2','','text',8,5);
	echo cs_html_roco(0);
	echo cs_html_roco(1,'leftc');
	echo cs_icon('kate') . $cs_lang['text'];
  echo cs_html_br(2);
  echo cs_abcode_smileys('rounds_description');
	echo cs_html_roco(2,'leftb');
  echo cs_abcode_features('rounds_description');
	echo cs_html_textarea('rounds_description','',20,15);
	echo cs_html_roco(0);
	echo cs_html_roco(1,'leftc');
	echo cs_icon('ksysguard') . $cs_lang['options'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_input('id',(int) $_GET['id'],'hidden');
	echo cs_html_input('submit',$cs_lang['create'],'submit');
	echo cs_html_input('reset',$cs_lang['reset'],'reset');
	echo cs_html_roco(0);
	echo cs_html_table(0);
	echo cs_html_form(0);
	echo cs_html_br(1);
	
  echo cs_getmsg();
  
	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'headb');
	echo $cs_lang['map'];
	echo cs_html_roco(2,'headb');
	echo $cs_lang['result'];
	echo cs_html_roco(3,'headb',0,4);
	echo $cs_lang['options'];
	echo cs_html_roco(0);
	
	$tables = 'rounds rnd LEFT JOIN {pre}_maps mps ON rnd.maps_id = mps.maps_id';
	$cells  = 'rnd.rounds_id AS rounds_id, rnd.rounds_score1 AS rounds_score1, ';
  $cells .= 'rnd.rounds_score2 AS rounds_score2, mps.maps_name AS maps_name, ';
  $cells .= 'rnd.rounds_order AS rounds_order';
  $sort = 'rnd.rounds_order ASC, rnd.rounds_id ASC';
	$select = cs_sql_select(__FILE__,$tables,$cells,'rnd.wars_id = \''.$id.'\'',$sort,0,0);
	
	if (!empty($select)) {
	
		$img_edit = cs_icon('edit');
		$img_del = cs_icon('editdelete');
    $img_up = cs_html_img('symbols/clansphere/up_arrow.png');
    $img_down = cs_html_img('symbols/clansphere/down_arrow.png');
		$run = 0;
    $count = count($select);
    
		foreach ($select AS $round) {
			
      $run++;
      
			echo cs_html_roco(1,'leftb');
			echo $round['maps_name'];
			echo cs_html_roco(2,'leftb');
			echo $round['rounds_score1'] . ' : ' . $round['rounds_score2'];
			echo cs_html_roco(3,'leftb');
			echo cs_link($img_edit,'wars','roundsedit','id='.$round['rounds_id'],0,$cs_lang['edit']);
			echo cs_html_roco(4,'leftb');
			echo cs_link($img_del,'wars','roundsremove','id='.$round['rounds_id'],0,$cs_lang['remove']);
      echo cs_html_roco(5,'leftb');
      echo $run != 1 ? cs_link($img_up,'wars','rounds','id='.$id.'&amp;up='.$round['rounds_id']) : '-';
      echo cs_html_roco(6,'leftb');
      echo $run != $count ? cs_link($img_down,'wars','rounds','id='.$id.'&amp;down='.$round['rounds_id']) : '-';
			echo cs_html_roco(0);
      
		}
	}

} else {
		
	$error = '';
	
	if (empty($_POST['maps_id']) AND empty($_POST['new_map'])) {
		
		$error .= cs_html_br(1) . '- ' . $cs_lang['no_map'];
	
	}
	
	if (!empty($error)) {
		
		echo $cs_lang['errors'] . $error;
	
	} else {
    
    $cs_rounds['wars_id'] = (int) $_POST['id'];
    $cs_rounds['rounds_score1'] = (int) $_POST['score1'];
    $cs_rounds['rounds_score2'] = (int) $_POST['score2'];
		$cs_rounds['rounds_description'] = empty($_POST['rounds_description']) ? '' : $_POST['rounds_description'];
    $cs_rounds['rounds_order'] = cs_sql_count(__FILE__,'rounds','wars_id = \''.$cs_rounds['wars_id'].'\'') + 1;
    
		if (!empty($_POST['new_map'])) {
      
      $get_game_id = cs_sql_select(__FILE__,'wars','games_id','wars_id = \''.$cs_rounds['wars_id'].'\'');
			
			$cells1 = array('maps_name','games_id');
			$values1 = array($_POST['new_map'],$get_game_id['games_id']);
			
			cs_sql_insert(__FILE__,'maps',$cells1,$values1);
			
			$cs_rounds['maps_id'] = cs_sql_insertid(__FILE__);
			
		} else {
			
			$cs_rounds['maps_id'] = (int) $_POST['maps_id'];
		
		}
		
		$cells2 = array_keys($cs_rounds);
		$values2 = array_values($cs_rounds);
		
		cs_sql_insert(__FILE__,'rounds',$cells2,$values2);
		
		cs_redirect($cs_lang['create_done'],'wars','rounds','id='.$cs_rounds['wars_id']);
		
	}
	echo cs_html_roco(0);
}
echo cs_html_table(0);

?>