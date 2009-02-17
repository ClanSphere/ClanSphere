<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cups');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['remove'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');

if(!isset($_POST['submit'])) {
  
  $cups_id = (int) $_GET['id'];
  
  if(empty($cups_id)) {
    cs_redirect($cs_lang['no_selection'],'cups','manage');
  } else {
    echo sprintf($cs_lang['del_rly'],$cups_id);
    echo cs_html_roco(0);
    echo cs_html_roco(1,'centerc');
    echo cs_html_form(1,'form1','cups','remove');
    echo cs_html_vote('id',$cups_id,'hidden');
    echo cs_html_vote('submit',$cs_lang['confirm'],'Submit');
    echo cs_html_form(0);
  }
} else {
  $cups_id = (int) $_POST['id'];
  cs_sql_delete(__FILE__,'cups',$cups_id);
  cs_redirect($cs_lang['del_true'], 'cups');
}

echo cs_html_roco(0);
echo cs_html_table(0);

?>