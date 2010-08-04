<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('ajax');

$data = array();

$data['bookmark']['uri']   = cs_url_self(1);
$data['bookmark']['title'] = $cs_main['def_title'];

$data['if']['share'] = empty($data['bookmark']['uri']) ? 0 : 1;

echo cs_subtemplate(__FILE__,$data,'ajax','navbookmark');