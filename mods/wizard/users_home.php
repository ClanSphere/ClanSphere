<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_options = cs_sql_option(__FILE__,'wizard');

if(!empty($cs_options['welcome'])) {

  $cs_lang = cs_translate('wizard');

  $data = array();

  echo cs_subtemplate(__FILE__,$data,'wizard','users_home');

}