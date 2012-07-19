<?php
// ClanSphere 2010 - www.clansphere.net 
// $Id$

$cs_lang = cs_translate('maps');

$data = array();

if(empty($_GET['id'])) {
  
  $data['maps']['link'] = cs_url('maps','manage');
  $data['maps']['action'] = $cs_lang['details'];
  echo cs_subtemplate(__FILE__,$data,'maps','no_selection');
  
} else {
  
  $maps_id = (int) $_GET['id'];
  
  $cells = 'games_id, maps_name, maps_text, maps_picture';
  $select = cs_sql_select(__FILE__,'maps',$cells,'maps_id = \''.$maps_id.'\'');
  $select2 = cs_sql_select(__FILE__,'games','games_id, games_name','games_id = \''.$select['games_id'].'\'');
  
  $data['maps'] = $select;
  
  $url = 'uploads/games/' . $select2['games_id'] . '.gif';
  $data['games']['games_picture'] = !file_exists($url) ? '' : cs_html_img($url);
  $data['games']['games_name'] = cs_link($select2['games_name'],'games','view','id='.$select2['games_id']);
  
  $data['maps']['maps_text'] = cs_secure($select['maps_text'],1,1);
  
  $data['if']['picture_set_map'] = empty($select['maps_picture']) ? false : true;
  $data['maps']['maps_picture'] = empty($select['maps_picture']) ? '' : cs_html_img('uploads/maps/' . $select['maps_picture']);
  
  echo cs_subtemplate(__FILE__,$data,'maps','view');
  
}