<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('ajax');

$data = array();

$data['encoded']['uri']   = rawurlencode(cs_url_self(1, 0, 1));
$data['encoded']['title'] = rawurlencode($cs_main['def_title']);

$data['if']['share'] = empty($data['encoded']['uri']) ? 0 : 1;

echo cs_subtemplate(__FILE__,$data,'ajax','navaddthis');