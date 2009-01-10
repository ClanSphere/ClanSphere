<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('install');

if(isset($_POST['create']) OR isset($_POST['view'])) {

	$cs_db['hash'] = $_POST['hash'];
	$cs_db['type'] = $_POST['type'];
	$cs_db['place'] = $_POST['place'];
	$cs_db['user'] = $_POST['user'];
	$cs_db['pwd'] = $_POST['pwd'];
	$cs_db['name'] = $_POST['name'];
	$cs_db['prefix'] = $_POST['prefix'];
	$log['save_actions'] = !empty($_POST['save_actions']) ? $_POST['save_actions'] : 0;
	$log['save_errors'] = !empty($_POST['save_errors']) ? $_POST['save_errors'] : 0;

  $error = 0;
  $errormsg = '';

  if(empty($cs_db['hash'])) {
    $error++;
    $errormsg .= $cs_lang['no_hash'] . cs_html_br(1);
  }
  if(empty($cs_db['type'])) {
    $error++;
    $errormsg .= $cs_lang['no_type'] . cs_html_br(1);
  }
  if(empty($cs_db['name'])) {
    $error++;
    $errormsg .= $cs_lang['no_name'] . cs_html_br(1);
  }
	if(!preg_match("=^[a-z0-9]+$=i",$cs_db['prefix'])) {
	  $error++;
    $errormsg .= $cs_lang['prefix_err'] . cs_html_br(1);
  }
	if(empty($error)) {

		@ini_set('track_errors', 1);
		$dberr = '';
		if($cs_db['type'] == 'mysql') {
			$cs_db['con'] = @mysql_connect($cs_db['place'],$cs_db['user'],$cs_db['pwd']) OR 
				$dberr = mysql_error();
			if(empty($dberr)) {
				mysql_select_db($cs_db['name']) OR $dberr = mysql_error($cs_db['con']);
			}
		}
		elseif($cs_db['type'] == 'mysqli') {
			$cs_db['con'] = @mysqli_connect($cs_db['place'],$cs_db['user'],$cs_db['pwd'],$cs_db['name']) OR 
				$dberr = mysqli_connect_error();
		}
		elseif($cs_db['type'] == 'pgsql') {
			$connect = empty($cs_db['place']) ? '' : 'host=' . $cs_db['place'] . ' ';
			$connect .= 'dbname=' . $cs_db['name'];
			$connect .= ' user=' . $cs_db['user'] . ' password=' . $cs_db['pwd'];
			$cs_db['con'] = @pg_connect($connect) OR $dberr = $php_errormsg;
		}
		elseif($cs_db['type'] == 'mssql') {
			$cs_db['con'] = @mssql_connect($cs_db['place'],$cs_db['user'],$cs_db['pwd']) OR 
				$dberr = $php_errormsg;
			if(empty($dberr)) {
				mssql_select_db($cs_db['name'],$cs_db['con']) OR $dberr = mssql_get_last_message();
			}
		}
		elseif($cs_db['type'] == 'sqlite') {
			$cs_db['con'] = @sqlite_open($cs_db['name']) OR $dberr = cs_sql_error();
		}
		elseif(preg_match('=pdo_=',$cs_db['type'])) {

			require('mods/install/pdo_check.php');
		}
		@ini_set('track_errors', 0);
	}
	if(!empty($dberr)) {
		$error++;
		$errormsg = $cs_lang['db_err'] . ' ' . $dberr;
	}
	if(empty($error)) {

		$setup_php = "<?php\n\n\$cs_db['hash'] = '" . $cs_db['hash'] . "'; # don't change!\n";
		$setup_php .= "\$cs_db['type'] = '" . $cs_db['type'] . "';\n";
		$setup_php .= "\$cs_db['place'] = '" . $cs_db['place'] . "';\n";
		$setup_php .= "\$cs_db['user'] = '" . $cs_db['user'] . "';\n";
		$setup_php .= "\$cs_db['pwd'] = '" . $cs_db['pwd'] . "';\n";
		$setup_php .= "\$cs_db['name'] = '" . $cs_db['name'] . "';\n";
		$setup_php .= "\$cs_db['prefix'] = '" . $cs_db['prefix'] . "';\n\n";
		$setup_php .= "\$cs_logs['save_actions'] = " . $log['save_actions'] . ";\n";
		$setup_php .= "\$cs_logs['save_errors'] = " . $log['save_errors'] . ";\n\n?>";

		if(isset($_POST['create'])) {
			$flerr = 0;
			$create_setup = @fopen('setup.php','w') OR $flerr++;
			@fwrite($create_setup,$setup_php) OR $flerr++;
			@fclose($create_setup) OR $flerr++;
		}
		if(!empty($flerr)) {
			$error++;
			$errormsg = $cs_lang['file_err'];
			
			$cs_db['pwd'] = ''; # Don't show password, if file creation was denied
		}
	}
}
else {

	$cs_db = array('hash' => '', 'type' => '', 'place' => 'localhost',
	'user' => '', 'pwd' => '', 'name' => '', 'prefix' => 'cs');
	$log = array('save_actions' => 0, 'save_errors' => 0);
}

$setup_exists = file_exists('setup.php') ? 1 : 0;

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_settings'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc');
if(!empty($error)) {
  echo $errormsg;
}
elseif(isset($_POST['create']) AND !empty($setup_exists)) {
  echo $cs_lang['inst_create_done'];
}
elseif(!empty($setup_exists)) {
  echo $cs_lang['setup_exists'];
}
else {
  echo $cs_lang['body_settings'];
}
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

if(!empty($setup_exists)) {
	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'centerb');
	echo cs_link($cs_lang['full_install'],'install','sql','lang=' . $account['users_lang']);
	echo cs_html_br(2);
	echo cs_link($cs_lang['module_select'],'install','sql_select','lang=' . $account['users_lang']);
	echo cs_html_roco(0);
	echo cs_html_table(0);
}
elseif(isset($_POST['view']) AND empty($error)) {
	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'headb');
	echo 'setup.php';
	echo cs_html_roco(0);
	echo cs_html_roco(1,'leftc');
	echo cs_html_textarea('setup_php',$setup_php,'50','15',1);
	echo cs_html_roco(0);
	echo cs_html_roco(1,'leftb');
	echo $cs_lang['save_file'];
	echo cs_html_roco(0);
	echo cs_html_table(0);
}
else {
	echo cs_html_form(1,'install_settings','install','settings');
	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'leftc');
	echo $cs_lang['hash'] . ' *';
	echo cs_html_roco(2,'leftb');
	$hash[0]['hash'] = 'md5';
	$hash[0]['name'] = 'Md5 = Message-Digest Algorithm';
	$hash[1]['hash'] = 'sha1';
	$hash[1]['name'] = 'Sha1 = Secure Hash Algorithm 1';
	echo cs_dropdown('hash','name',$hash,$cs_db['hash']);
	echo cs_html_br(1);
	echo $cs_lang['hash_info'];
	echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo $cs_lang['type'] . ' *';
	echo cs_html_roco(2,'leftb');

  $type = array();
	$run = 0;

	if(extension_loaded('mssql')) {
		$type[$run]['type'] = 'mssql';
		$type[$run]['name'] = 'Microsoft SQL Server (mssql)';
		$run++;
	}
	if(extension_loaded('mysql')) {
		$type[$run]['type'] = 'mysql';
		$type[$run]['name'] = 'MySQL (mysql)';
		$run++;
	}
	if(extension_loaded('mysqli')) {
		$type[$run]['type'] = 'mysqli';
		$type[$run]['name'] = 'MySQL (mysqli)';
		$run++;
	}
	if(extension_loaded('pgsql')) {
		$type[$run]['type'] = 'pgsql';
		$type[$run]['name'] = 'PostgreSQL (pgsql)';
		$run++;
	}
	if(extension_loaded('sqlite')) {
		$type[$run]['type'] = 'sqlite';
		$type[$run]['name'] = 'SQLite 2 (sqlite)';
		$run++;
	}
	if(extension_loaded('pdo')) {

		if(extension_loaded('pdo_mysql')) {
			$type[$run]['type'] = 'pdo_mysql';
			$type[$run]['name'] = 'MySQL (pdo_mysql)';
			$run++;
		}
		if(extension_loaded('pdo_pgsql')) {
			$type[$run]['type'] = 'pdo_pgsql';
			$type[$run]['name'] = 'PostgreSQL (pdo_pgsql)';
			$run++;
		}
		if(extension_loaded('pdo_sqlite')) {
			$type[$run]['type'] = 'pdo_sqlite';
			$type[$run]['name'] = 'SQLite 3 (pdo_sqlite)';
		}
	}
	echo cs_dropdown('type','name',$type,$cs_db['type']);
	echo cs_html_br(1);
	echo $cs_lang['type_info'];
	echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo $cs_lang['place'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_input('place',$cs_db['place'],'text',200,50);
	echo cs_html_br(1);
	echo $cs_lang['place_info'];
	echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo $cs_lang['db_name'] . ' *';
	echo cs_html_roco(2,'leftb');
	echo cs_html_input('name',$cs_db['name'],'text',80,40);
	echo cs_html_br(1);
	echo $cs_lang['sqlite_info'];
	echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo $cs_lang['prefix'] . ' *';
	echo cs_html_roco(2,'leftb');
	echo cs_html_input('prefix',$cs_db['prefix'],'text',8,8);
	echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo $cs_lang['user'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_input('user',$cs_db['user'],'text',50,25);
	echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo $cs_lang['pwd'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_input('pwd',$cs_db['pwd'],'password',50,25);
	echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo $cs_lang['more'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_vote('save_actions','1','checkbox',$log['save_actions']);
	echo $cs_lang['save_actions'];
	echo cs_html_br(1);
	echo cs_html_vote('save_errors','1','checkbox',$log['save_errors']);
	echo $cs_lang['save_errors'];
	echo cs_html_roco(0);
  
  echo cs_html_roco(1,'leftc');
  echo $cs_lang['options'];
  echo cs_html_roco(2,'leftb');
	echo cs_html_input('lang',$account['users_lang'],'hidden');
  echo cs_html_vote('create',$cs_lang['create'],'submit');
  echo cs_html_vote('view',$cs_lang['show'],'submit');
  echo cs_html_vote('reset',$cs_lang['reset'],'reset');
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_form(0);
}

?>