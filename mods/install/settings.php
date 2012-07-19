<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('install');

$sql_files = cs_paths('system/database');
unset($sql_files['pdo.php']);

$setup_exists = file_exists('setup.php') ? 1 : 0;

if(empty($setup_exists) AND (isset($_POST['create']) OR isset($_POST['view']))) {

  $cs_db['hash'] = $_POST['hash'];
  $cs_db['type'] = $_POST['type'];
  $cs_db['subtype'] = $_POST['subtype'];
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

    if(isset($sql_files['' . $cs_db['type'] . '.php'])) {
      include_once 'system/database/' . $cs_db['type'] . '.php';
      $dberr = cs_sql_connect($cs_db, 1);
    }
    else {
      $dberr = 'Extension could not be found';
    }
  }
  if(!empty($dberr)) {
    $error++;
    $errormsg = $cs_lang['db_err'] . ' ' . nl2br($dberr);
  }
  if(empty($error)) {

    $setup_php = "<?php\n\n\$cs_db['hash'] = '" . $cs_db['hash'] . "'; # don't change!\n";
    $setup_php .= "\$cs_db['type'] = '" . $cs_db['type'] . "';\n";
    $setup_php .= "\$cs_db['subtype'] = '" . $cs_db['subtype'] . "';\n";
    $setup_php .= "\$cs_db['place'] = '" . $cs_db['place'] . "';\n";
    $setup_php .= "\$cs_db['user'] = '" . $cs_db['user'] . "';\n";
    $setup_php .= "\$cs_db['pwd'] = '" . $cs_db['pwd'] . "';\n";
    $setup_php .= "\$cs_db['name'] = '" . $cs_db['name'] . "';\n";
    $setup_php .= "\$cs_db['prefix'] = '" . $cs_db['prefix'] . "';\n\n";
    $setup_php .= "\$cs_logs['save_actions'] = " . $log['save_actions'] . ";\n";
    $setup_php .= "\$cs_logs['save_errors'] = " . $log['save_errors'] . ";\n\n";
    $setup_php .= "\$cs_main['charset'] = '" . $cs_main['charset'] . "';";

    if(isset($_POST['create'])) {
      $flerr = 0;
      $create_setup = fopen('setup.php','w') OR $flerr++;
      # set stream encoding if possible to avoid converting issues
      if(function_exists('stream_encoding'))
        stream_encoding($create_setup, $cs_main['charset']);
      fwrite($create_setup,$setup_php) OR $flerr++;
      fclose($create_setup) OR $flerr++;

      # check again to skip form page and prohibite errors
      $setup_exists = file_exists('setup.php') ? 1 : 0;
      if(empty($setup_exists))
        $flerr++;
    }
    if(!empty($flerr)) {
      $error++;
      $errormsg = $cs_lang['file_err'];

      $cs_db['pwd'] = ''; # Don't show password, if file creation was denied
    }
  }
}
else {

  $cs_db = array('hash' => '', 'type' => '', 'subtype' => '', 'place' => 'localhost', 'user' => '', 'pwd' => '', 'name' => '', 'prefix' => 'cs');
  $log = array('save_actions' => 0, 'save_errors' => 0);
}

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
  $data['data']['setup'] = htmlentities($setup_php, ENT_QUOTES, $cs_main['charset']);

} else {

  $data['if']['display_form'] = true;

  $data['selected']['md5'] = $cs_db['hash'] == 'md5' ? ' selected="selected"' : '';
  $data['selected']['sha1'] = $cs_db['hash'] == 'sha1' ? ' selected="selected"' : '';

  $data['data']['types'] = '';

  foreach($sql_files AS $sql_file => $num) {

    $extension = substr($sql_file, 0, -4);
    if(extension_loaded($extension)) {
        $selected = $cs_db['type'] == $extension ? 1 : 0;
        $data['data']['types'] .= cs_html_option($extension, $extension, $selected);
    }
  }

  $data['value']['subtype'] = $cs_db['subtype'];
  $data['value']['charset'] = $cs_main['charset'];
  $data['value']['place'] = $cs_db['place'];
  $data['value']['name'] = $cs_db['name'];
  $data['value']['prefix'] = $cs_db['prefix'];
  $data['value']['user'] = $cs_db['user'];
  $data['value']['pwd'] = $cs_db['pwd'];

  $data['checked']['save_actions'] = empty($log['save_actions']) ? '' : ' checked="checked"';
  $data['checked']['save_errors'] = empty($log['save_errors']) ? '' : ' checked="checked"';
}

echo cs_subtemplate(__FILE__, $data, 'install', 'settings');