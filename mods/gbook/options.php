<?php
$cs_lang = cs_translate('gbook');

if(isset($_POST['submit'])) {
  $data['options']['lock'] = (int) $_POST['lock'];
  $opt_where = "options_mod = 'gbook' AND options_name = ";
  cs_sql_update(__FILE__,'options',array('options_value'),array((int) $_POST['lock']),0,$opt_where . "'lock'");
  cs_redirect($cs_lang['changes_done'],'gbook','manage');
} else {
  $cs_options = cs_sql_option(__FILE__,'gbook');
  $data['action']['form'] = cs_url('gbook','options');
  $data['option']['lock'] = $cs_options['lock'];
  $data['select']['no'] = $cs_options['lock'] == 0 ? 'selected="selected"' : '';
  $data['select']['yes'] = $cs_options['lock'] == 1 ? 'selected="selected"' : '';
}

echo cs_subtemplate(__FILE__,$data,'gbook','options');
?>