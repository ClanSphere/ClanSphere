<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('replays');

$data = array();

$replays_id = $_GET['id'];
settype($replays_id,'integer');

if(isset($_GET['agree'])) {
  $replays = cs_sql_select(__FILE__,'replays','replays_mirrors',"replays_id = '" . $replays_id . "'");
	$replays_string = $replays['replays_mirrors'];
	$replays_pics = empty($replays_string) ? array() : explode("\n",$replays_string);
	foreach($replays_pics AS $pics) {
		cs_unlink('replays',$pics);
	}
  
  cs_sql_delete(__FILE__,'replays',$replays_id);
  cs_redirect($cs_lang['del_true'], 'replays');
}
elseif(isset($_GET['cancel'])) 
  cs_redirect($cs_lang['del_false'], 'replays');  
else {
	$data['head']['topline'] = sprintf($cs_lang['del_rly'],$replays_id);
	$data['replays']['content'] = cs_link($cs_lang['confirm'],'replays','remove','id=' . $replays_id . '&amp;agree');
	$data['replays']['content'] .= ' - ';
	$data['replays']['content'] .= cs_link($cs_lang['cancel'],'replays','remove','id=' . $replays_id . '&amp;cancel');
}

echo cs_subtemplate(__FILE__,$data,'replays','remove');

?>
