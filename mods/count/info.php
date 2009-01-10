<?php
//CLANSPHERE.de CMS /mods/count/info.php
//Freitag, 8. Februar 2008 17:15:20

$cs_lang = cs_translate('count');

$mod_info['name']		= $cs_lang['mod_name'];
$mod_info['version']	= $cs_main['version_name'];
$mod_info['released']	= $cs_main['version_date'];
$mod_info['creator']	= 'Denni & Sickboy';
$mod_info['team']		= 'ClanSphere';
$mod_info['url']		= 'www.clansphere.de';
$mod_info['text']		= $cs_lang['mod_text'];
$mod_info['icon']		= 'xclock';
$mod_info['show']		= array('clansphere/admin' => 3, 'options/roots' => 5);
$mod_info['categories']	= FALSE;
$mod_info['comments']	= FALSE;
$mod_info['protected']	= FALSE;
$mod_info['tables']		= array('count','count_archiv'); 

?>
