<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanshop');

$lanshop_form = 1;
$lanshop_id = $_REQUEST['id'];
settype($lanshop_id,'integer');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['remove'];
echo cs_html_roco(0);

if(isset($_POST['agree'])) {
  $lanshop_form = 0;
  cs_sql_delete(__FILE__,'lanshop_articles',$lanshop_id);

  cs_redirect($cs_lang['del_true'], 'lanshop');
}

if(isset($_POST['cancel'])) 
  cs_redirect($cs_lang['del_false'], 'lanshop');

if(!empty($lanshop_form)) {

  echo cs_html_roco(1,'leftb');
  echo sprintf($cs_lang['del_rly'],$lanshop_id);
  echo cs_html_roco(0);

  echo cs_html_roco(1,'centerc');
  echo cs_html_form(1,'lanshop_remove','lanshop','remove');
  echo cs_html_vote('id',$lanshop_id,'hidden');
  echo cs_html_vote('agree',$cs_lang['confirm'],'submit');
  echo cs_html_vote('cancel',$cs_lang['cancel'],'submit');
  echo cs_html_form (0);
  echo cs_html_roco(0);
  echo cs_html_table(0);
}

?>
