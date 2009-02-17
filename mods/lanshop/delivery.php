<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanshop');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,3);
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_delivery'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo cs_link($cs_lang['manage'],'lanshop','manage');
echo cs_html_roco(2,'centerb');
echo cs_link($cs_lang['export'],'lanshop','export');
echo cs_html_roco(3,'rightb');
echo cs_link($cs_lang['cashdesk'],'lanshop','cashdesk');
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);
echo cs_getmsg();
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

  echo cs_html_form (1,'lanshop_delivery','lanshop','delivery');
  echo cs_html_table(1,'forum',1);
  
  echo cs_html_roco(1,'leftc');
  echo cs_icon('folder_yellow') . $cs_lang['category'];
  echo cs_html_roco(2,'leftb');
  $lanshopmod = "categories_mod='lanshop'";
  $categories_data = cs_sql_select(__FILE__,'categories','*',$lanshopmod,'categories_name',0,0);
  echo cs_dropdown('categories_id','categories_name',$categories_data,$categories_id);
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('today') . $cs_lang['since'];
  echo cs_html_roco(2,'leftb');
  echo cs_dateselect('since','unix',$since);
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('ksysguard') . $cs_lang['options'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_vote('submit',$cs_lang['submit'],'submit');
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_form(0);
}

?>
