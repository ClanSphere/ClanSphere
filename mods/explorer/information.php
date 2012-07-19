<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('explorer');

include_once('mods/explorer/functions.php');

$dir = cs_explorer_path($_GET['file'], 'raw');
$lsd = cs_explorer_path($dir, 'escape');
$red_lsd = cs_explorer_path($dir, 'escape', 1);

if (empty($_GET['file'])) cs_redirect($cs_lang['no_object'], 'explorer', 'roots', 'dir=' . $red_lsd);
if (!$info = stat($dir)) cs_redirect($cs_lang['not_opened'], 'explorer', 'roots', 'dir=' . $red_lsd);

$data = array();

$data['var']['dir'] = $red_lsd;

$data['file']['name'] = $dir;
$data['file']['size'] = cs_filesize($info[7]);
$data['file']['chmod'] = substr(sprintf('%o', fileperms($dir)), -4);
$data['file']['lastchange_date'] = date('d.m.Y', $info[10]);
$data['file']['lastchange_time'] = date('G:i', $info[10]);
$data['file']['lastaccess_date'] = date('d.m.Y', $info[8]);
$data['file']['lastaccess_time'] = date('G:i', $info[8]);
$data['file']['owner'] = fileowner($dir);
$data['file']['ownergroup'] = filegroup($dir);

echo cs_subtemplate(__FILE__, $data, 'explorer', 'information');