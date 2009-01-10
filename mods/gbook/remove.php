<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gbook');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod_name'] . ' - ' . $cs_lang['remove'];
echo cs_html_roco(0);

$gbook_form = 1;
$gbook_id = $_REQUEST['id'];

if (isset($_POST['agree'])) {
  $gbook_form = 0;
  cs_sql_delete(__FILE__,'gbook',$gbook_id);
  cs_redirect($cs_lang['del_true'],'gbook');
}
if (isset($_POST['cancel'])) { cs_redirect($cs_lang['del_false'], 'gbook'); }

if(!empty($gbook_form)) {
  echo cs_html_roco(1,'leftb');
  echo sprintf($cs_lang['del_rly'],$gbook_id);
  echo cs_html_roco(0);

  echo cs_html_roco(1,'centerc');
  echo cs_html_form(1,'gbook_remove','gbook','remove');
  echo cs_html_vote('id',$gbook_id,'hidden');
  echo cs_html_vote('agree',$cs_lang['confirm'],'submit');
  echo cs_html_vote('cancel',$cs_lang['cancel'],'submit');
  echo cs_html_form (0);
  echo cs_html_roco(0);
  echo cs_html_table(0);
}
?>