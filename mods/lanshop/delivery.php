<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanshop');
$data = array();

$data['head']['getmsg'] = cs_getmsg();

if(isset($_POST['submit'])) {

  $categories_id = $_POST['categories_id'];
  settype($categories_id,'integer');
  $since = cs_datepost('since','unix');
  $lanshop_cells = array('lanshop_orders_status');
  $lanshop_save = array(3);

  $where = "categories_id = '" . $categories_id . "'";
  $articles = cs_sql_select(__FILE__,'lanshop_articles','lanshop_articles_id',$where,0,0,0);
  $art_count = count($articles);

  if(!empty($art_count)) {
    $targets = "lanshop_orders_status = '2' AND lanshop_orders_since < '" . $since . "'";
    foreach($articles AS $change) {
      $art = " AND lanshop_articles_id = '" . $change['lanshop_articles_id'] . "'";    
     cs_sql_update(__FILE__,'lanshop_orders',$lanshop_cells,$lanshop_save,0,$targets . $art);
    }
  }
 cs_redirect($cs_lang['delivery_done'],'lanshop','delivery');
}
else {

  $categories_id = 0;
  $since = cs_time();

  $lanshopmod = "categories_mod='lanshop'";
  $categories_data = cs_sql_select(__FILE__,'categories','*',$lanshopmod,'categories_name',0,0);
  $data['ls']['cat_sel'] = cs_dropdown('categories_id','categories_name',$categories_data,$categories_id);

  $data['ls']['date_sel'] = cs_dateselect('since','unix',$since);
  
 echo cs_subtemplate(__FILE__,$data,'lanshop','delivery');
}

?>
