<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('errors');

$data = array();
$data['head']['mod'] = $cs_lang['mod_name'];
$data['head']['action'] = $cs_lang['500_action'];

if(empty($cs_main['error_internal']) OR empty($cs_lang['500_err_' . $cs_main['error_internal'] . '']))
  $data['head']['error'] = $cs_lang['500_body'];
else
  $data['head']['error'] = $cs_lang['500_err_' . $cs_main['error_internal'] . ''];

$data['head']['report'] = empty($cs_main['error_reported']) ? '' : $cs_main['error_reported'];

echo cs_subtemplate(__FILE__,$data,'errors','500');