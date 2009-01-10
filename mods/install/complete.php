<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('install');

function cs_set_env($dir) {

	$error = 0;
	$dir = $dir . '/';
	$dh = opendir($dir);

	while (false !== ($filename = readdir($dh))) {
		if($filename != '.' AND $filename != '..') {
			$nextcheck = $dir . $filename;
			@chmod($dir,0777) OR $error++;
		}
	}
	closedir($dh);
	empty($error) ? $result = true : $result = false;
	return $result;
}

$set_logs = cs_set_env('logs');
$set_uploads = cs_set_env('uploads');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_complete'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc');
echo $cs_lang['rem_install'];
echo cs_html_br(1);
echo $cs_lang['set_chmod'];
echo cs_html_br(2);

if(!unlink('uninstall.sql')) {
	echo $cs_lang['remove_file'] . " 'uninstall.sql'" . cs_html_br(1);
}
if(!unlink('install.sql')) {
	echo $cs_lang['remove_file'] . " 'install.sql'" . cs_html_br(1);
}
if(!unlink('install.php')) {
	echo $cs_lang['remove_file'] . " 'install.php'" . cs_html_br(1);
}
if(empty($set_logs) OR empty($set_uploads) OR empty($set_cache)) {
	echo $cs_lang['err_chmod'];
}

echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'centerb');
echo cs_html_link('index.php?mod=users&amp;action=login',$cs_lang['login'],0);
echo cs_html_roco(0);
echo cs_html_table(0);

?>