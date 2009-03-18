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

$data = array();

$data['head']['message'] = $cs_lang['body_settings'];
if (!empty($error)) $data['head']['message'] = $errormsg;
elseif (isset($_POST['create']) AND !empty($setup_exists)) $data['head']['message'] = $cs_lang['inst_create_done'];
elseif (!empty($setup_exists)) $data['head']['message'] = $cs_lang['setup_exists'];

$data['data']['lang'] = $account['users_lang'];

$data['if']['setup'] = false;
$data['if']['display_setup'] = false;
$data['if']['display_form'] = false;

if(!empty($setup_exists)) {
	
	$data['if']['setup'] = true;
	
} elseif(isset($_POST['view']) AND empty($error)) {

	$data['if']['display_setup'] = true;
	$data['data']['setup'] = $setup_php;
	
} else {
	
	$data['if']['display_form'] = true;
	
	$data['selected']['md5'] = $cs_db['hash'] == 'md5' ? ' selected="selected"' : '';
	$data['selected']['sha1'] = $cs_db['hash'] == 'sha1' ? ' selected="selected"' : '';
	
	$data['types'] = array();
	$i = 0;
	
	$types = array();
	$types['mysql'] = 'MySQL (mysql)';
	$types['mysqli'] = 'MySQL (mysqli)';
	$types['pgsql'] = 'PostgreSQL (pgsql)';
	$types['sqlite'] = 'SQLite 2 (sqlite)';
	
	$types_pdo = array();
	$types_pdo['pdo_mysql'] = 'MySQL (pdo_mysql)';
	$types_pdo['pdo_pgsql'] = 'PostgreSQL (pdo_pgsql)';
	$types_pdo['pdo_sqlite'] = 'SQLite 3 (pdo_sqlite)';
	
	foreach ($types AS $type => $name) {
		if (extension_loaded($type)) {
			$data['types'][$i]['type'] = $type;
			$data['types'][$i]['name'] = $name;
			$data['types'][$i]['selected'] = $cs_db['type'] == $type ? ' selected="selected"' : '';
			$i++;
		}
	}
	
	if (extension_loaded('pdo')) {
	  foreach ($types_pdo AS $type => $name) {
	    if (extension_loaded($type)) {
	      $data['types'][$i]['type'] = $type;
	      $data['types'][$i]['name'] = $name;
	      $data['types'][$i]['selected'] = $cs_db['type'] == $type ? ' selected="selected"' : '';
	      $i++;
	    }
	  }
	}
	
	$data['value']['place'] = $cs_db['place'];
	$data['value']['name'] = $cs_db['name'];
	$data['value']['prefix'] = $cs_db['prefix'];
	$data['value']['user'] = $cs_db['user'];
	$data['value']['pwd'] = $cs_db['pwd'];
	
	$data['checked']['save_actions'] = empty($log['save_actions']) ? '' : ' checked="checked"';
	$data['checked']['save_errors'] = empty($log['save_errors']) ? '' : ' checked="checked"';
	
}


echo cs_subtemplate(__FILE__, $data, 'install', 'settings');


?>