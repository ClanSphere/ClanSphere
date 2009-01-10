<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('wars');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['rounds_edit'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc');

if (empty($_POST['submit'])) {
	
	$id = (int) $_GET['id'];
	
	$data = cs_sql_select(__FILE__,'rounds','maps_id, rounds_score1, rounds_score2, rounds_description','rounds_id = \''.$id.'\'');
	
	echo $cs_lang['edit_round'];
	echo cs_html_roco(0);
	echo cs_html_table(0);
	echo cs_html_br(1);
	
	echo cs_html_form(1,'roundsedit','wars','roundsedit');
	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'leftc');
	echo cs_icon('atlantikdesigner') . $cs_lang['map'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_select(1,'maps_id');
	echo cs_html_option('----',0,1);
	
	$cs_maps = cs_sql_select(__FILE__,'maps','maps_name, maps_id',0,'maps_name',0,0);
	
	if(!empty($cs_maps)) {
		
		foreach ($cs_maps AS $map) {
			
			$sel = $map['maps_id'] == $data['maps_id'] ? 'selected="selected"' : '';
			
			echo cs_html_option($map['maps_name'],$map['maps_id'],$sel);
		}
	}
	
	echo cs_html_select(0) . ' - ' . cs_html_input('new_map','','text');
	echo cs_html_roco(0);
	echo cs_html_roco(1,'leftc');
	echo cs_icon('smallcal') . $cs_lang['result'] . ' *';
	echo cs_html_roco(2,'leftb');
	echo cs_html_input('score1',$data['rounds_score1'],'text',8,5) . ' : ' . cs_html_input('score2',$data['rounds_score2'],'text',8,5);
	echo cs_html_roco(0);
	echo cs_html_roco(1,'leftc');
	echo cs_icon('kate') . $cs_lang['text'];
  echo cs_html_br(2);
  echo cs_abcode_smileys('rounds_description');
	echo cs_html_roco(2,'leftb');
  echo cs_abcode_features('rounds_description');
	echo cs_html_textarea('rounds_description',$data['rounds_description'],20,15);
	echo cs_html_roco(0);
	echo cs_html_roco(1,'leftc');
	echo cs_icon('ksysguard') . $cs_lang['options'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_input('id',$id,'hidden');
	echo cs_html_input('submit',$cs_lang['edit'],'submit');
	echo cs_html_input('reset',$cs_lang['reset'],'reset');
	echo cs_html_roco(0);
	echo cs_html_table(0);
	echo cs_html_form(0);

} else {
	
	$id = (int) $_POST['id'];
	
	if (!empty($_POST['new_map'])) {
			
		$tables = 'wars wrs INNER JOIN {pre}_games gms ON wrs.games_id = gms.games_id';
		$cells = 'gms.games_id AS games_id';
		$where = 'wrs.wars_id = \''.$warid.'\'';
		
		$get_game_id = cs_sql_select(__FILE__,$tables,$cells,$where);
		
		$cells1 = array('maps_name','games_id');
		$values1 = array($_POST['new_map'],$get_game_id['games_id']);
		
		cs_sql_insert(__FILE__,'maps',$cells1,$values1);
		
		$mapid = cs_sql_insertid(__FILE__);
		
	} else {
		
		$mapid = (int) $_POST['maps_id'];
	
	}
	
	$cells2 = array('maps_id','rounds_score1','rounds_score2','rounds_description');
	$values2 = array($mapid,$_POST['score1'],$_POST['score2'],$_POST['rounds_description']);
	
	cs_sql_update(__FILE__,'rounds',$cells2,$values2,$id);
	
	$warid = cs_sql_select(__FILE__,'rounds','wars_id','rounds_id = \''.$id.'\'');
	
	cs_redirect($cs_lang['create_done'],'wars','rounds','id='.$warid['wars_id']);

}

?>