<?php
// ClanSphere 2008 - www.clansphere.net
// Id: remove.php (Sun Nov 16 15:28:32 CET 2008) fAY-pA!N

$cs_lang = cs_translate('comments');

$data = array();

if(isset($_POST['agree'])) {
	$com_id = $_POST['id'];
    settype($com_id, 'integer');
	cs_sql_delete(__FILE__,'comments',$com_id);
	
	cs_redirect($cs_lang['del_true'],'comments');
}
elseif(isset($_POST['cancel'])) 
	cs_redirect($cs_lang['del_false'],'comments');
	
else {
	$data['com']['id'] = $_GET['id'];
	$data['head']['body'] = sprintf($cs_lang['del_rly'],$data['com']['id']);
	echo cs_subtemplate(__FILE__,$data,'comments','remove');
}

?>