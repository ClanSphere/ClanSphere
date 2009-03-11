<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('explorer');

if (!empty($cs_main['mod_rewrite'])) $_GET['file'] = substr($_GET['params'], strpos($_GET['params'], 'explorer/information/file/')+26);
$source = str_replace('..', '', $_GET['file']);
$dir = strchr($source, '/');

if (empty($_GET['file'])) cs_redirect($cs_lang['no_object'], 'explorer', 'roots', 'dir=' . $dir);
if (!$info = stat($source)) cs_redirect($cs_lang['not_opened'], 'explorer', 'roots', 'dir=' . $dir);

$data = array();

$data['file']['name'] = $source;
$data['file']['size'] = cs_filesize($info[7]);
$data['file']['chmod'] = substr(sprintf('%o', fileperms($_GET['file'])), -4);
$data['file']['lastchange_date'] = date('d.m.Y', $info[10]);
$data['file']['lastchange_time'] = date('G:i', $info[10]);
$data['file']['lastaccess_date'] = date('d.m.Y', $info[8]);
$data['file']['lastaccess_time'] = date('G:i', $info[8]);
$data['file']['owner'] = fileowner($source);
$data['file']['ownergroup'] = filegroup($source);

echo cs_subtemplate(__FILE__, $data, 'explorer', 'information');

?>