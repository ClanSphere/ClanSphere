<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('install');

function cs_uninstall($old_query = '') {
  global $cs_db;
  $error = $cs_db['last_error'];
	$sql_uninstall = file_get_contents('uninstall.sql');
	$sql_array = preg_split("=;[\n\r]+=",$sql_uninstall); 
	foreach($sql_array AS $sql_query) {
		@cs_sql_query(__FILE__, $sql_query);
	}
	die('Database error caused SQL uninstall: ' . $error . ' - Query: ' . $old_query);
}

$sql_install = file_get_contents('install.sql');
$sql_install = str_replace('{time}',cs_time(),$sql_install);

$sql_install = str_replace('{def_lang}',$account['users_lang'],$sql_install);
$sql_install = str_replace('{guest}',$cs_lang['guest'],$sql_install);
$sql_install = str_replace('{community}',$cs_lang['community'],$sql_install);
$sql_install = str_replace('{member}',$cs_lang['member'],$sql_install);
$sql_install = str_replace('{orga}',$cs_lang['orga'],$sql_install);
$sql_install = str_replace('{admin}',$cs_lang['admin'],$sql_install);

global $cs_db;
if($cs_db['hash'] == 'md5') { 
	$sec_pwd = md5('admin');
}
elseif($cs_db['hash'] == 'sha1') { 
	$sec_pwd = sha1('admin');
}
$sql_install = str_replace('{pwd}',$sec_pwd,$sql_install);

if($cs_db['type'] == 'mysql') {
	$sql_install = str_replace('{serial}','int(8) unsigned NOT NULL auto_increment',$sql_install);
	$sql_install = str_replace('{engine}',' TYPE=MyISAM',$sql_install);
	$sql_install = preg_replace("=create index (\S+) on (\S+) (\S+)=si",'ALTER TABLE $2 ADD KEY $1 $3',$sql_install);
}
elseif($cs_db['type'] == 'mysqli' OR $cs_db['type'] == 'pdo_mysql') {
	$sql_install = str_replace('{serial}','int(8) unsigned NOT NULL auto_increment',$sql_install);
	$sql_install = str_replace('{engine}',' ENGINE=MyISAM',$sql_install);
	$sql_install = preg_replace("=create index (\S+) on (\S+) (\S+)=si",'ALTER TABLE $2 ADD KEY $1 $3',$sql_install);
}
elseif($cs_db['type'] == 'pgsql' OR $cs_db['type'] == 'pdo_pgsql') {
	$sql_install = str_replace('{serial}','serial NOT NULL',$sql_install);
	$sql_install = str_replace('{engine}','',$sql_install);
	$sql_install = preg_replace("=int\((.*?)\)=si",'integer',$sql_install);
}
elseif($cs_db['type'] == 'mssql') {
	$sql_install = str_replace('{serial}','int IDENTITY(1,1)',$sql_install);
	$sql_install = str_replace('{engine}','',$sql_install);
	$sql_install = preg_replace("=int\((.*?)\)=si",'int',$sql_install);
}
elseif($cs_db['type'] == 'sqlite' OR $cs_db['type'] == 'pdo_sqlite') {
	$sql_install = str_replace('{serial}','integer',$sql_install);
	$sql_install = str_replace('{engine}','',$sql_install);
	$sql_install = preg_replace("=int\((.*?)\)=si",'integer',$sql_install);
}

$sql_array = preg_split("=;[\n\r]+=",$sql_install); 
foreach($sql_array AS $sql_query) {
	$sql_query = trim($sql_query);
	if(!empty($sql_query)) {
		if (!cs_sql_query(__FILE__, $sql_query)) {
  		cs_uninstall($sql_query);
		}
	}
}

if(isset($_POST['module_select'])) {
  $mods = array('articles','awards','banners','board','boardmods','boardranks','buddys','cash','clans','computers','cups','events','explorer','faq','fightus','files','gallery','games','gbook','history','joinus','links','linkus','maps','members','messages','news','newsletter','partner','quotes','ranks','replays','rules','search','servers','shoutbox','squads','static','usersgallery','votes','wars','wizard');
  $mods_count = count($mods);
  for($run=0; $run < $mods_count; $run++) {
    if(!isset($_POST[$mods[$run]])) {
	  cs_sql_query(__FILE__,"UPDATE {pre}_access SET access_" . $mods[$run] . " = '0'");
    }
  }
}

cs_redirect('','install','admin','lang=' . $account['users_lang']);

?>