<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('categories');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['remove'];
echo cs_html_roco(0);

$categories_form = 1;
$categories_id = $_REQUEST['id'];
settype($categories_id,'integer');

if(isset($_POST['agree'])) {

	$categories_form = 0;
	$where = "categories_id = '" . $categories_id . "'";
	$getpic = cs_sql_select(__FILE__,'categories','categories_picture',$where);
	if(!empty($getpic['categories_picture'])) {
		cs_unlink('categories', $getpic['categories_picture']);
	}
	cs_sql_delete(__FILE__,'categories',$categories_id);	

	cs_redirect($cs_lang['del_true'], 'categories');
}

if(isset($_POST['cancel'])) 
  cs_redirect($cs_lang['del_false'], 'categories');

if(!empty($categories_form)) {
        
        $categorie = cs_sql_select(__FILE__,'categories','categories_mod','categories_id='.$categories_id,0,0,1);
        $count_use = cs_sql_count(__FILE__,$categorie['categories_mod'],'categories_id='.$categories_id);
	echo cs_html_roco(1,'leftb');
	echo sprintf($cs_lang['del_rly'],$categories_id);
	echo cs_html_roco(0);

	echo cs_html_roco(1,'centerc');
	echo cs_html_form(1,'categories_remove','categories','remove');
	echo cs_html_vote('id',$categories_id,'hidden');
	if(empty($count_use)) {
		echo cs_html_vote('agree',$cs_lang['confirm'],'submit');
		echo cs_html_vote('cancel',$cs_lang['cancel'],'submit');     
	} else {
		echo sprintf($cs_lang['del_no'],$count_use);	
	}
	echo cs_html_form (0);
	echo cs_html_roco(0);
	echo cs_html_table(0);
}
              
?>
