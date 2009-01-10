<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$
$cs_lang = cs_translate('converter');

$data = array();

// Wenn Starten
if(isset($_POST['submit'])) {

  $data['data']['dbplace'] = $_POST['dbplace'];
  $data['data']['dbuser'] = $_POST['dbuser'];
  $data['data']['dbpwd'] = $_POST['dbpwd'];
  $data['data']['dbname'] = $_POST['dbname'];
  $data['data']['dbprefix'] = $_POST['dbprefix'];


  $error = 0;
  $errormsg = '';

} else {
  $data['data']['dbplace'] = '';
  $data['data']['dbuser'] = '';
  $data['data']['dbpwd'] = '';
  $data['data']['dbname'] = '';
  $data['data']['dbprefix'] = '';
  $data['data']['cms'] = '1';
}

// Datenbank Daten eingeben etc.
if(!isset($_POST['submit']) or !empty($error)) {
  $cms = empty($_GET['cms']) ? 0 : $_GET['cms'];
	if(!empty($cms)) {
    $file = 'mods/converter/classes/' . $cms . '/info.php';
    if(file_exists($file)) {
      require_once($file);
      $data['import']['cms'] = $info['name'] . ' ' . $info['version'];
      $data['head']['msg'] = 'Informationen gefunden. Import kann gestartet werden';
      $data['display']['cms_import'] = 'block';
      $data['display']['error'] = 'none';
  	  for ($run = 0; $run < count($info['modules']); $run++) {
		 $data['cmsmod'][$run]['lang_cmsmod'] = $cs_lang['mod_'.$info['modules'][$run]];
		 $data['cmsmod'][$run]['modules'] = $info['modules'][$run];
		 asort($data['cmsmod']);
     }
     print_R($info['modules']);
    } else {
      $data['import']['cms'] = $cms;
      $data['head']['msg'] = 'Keine Informationen gefunden. Der Import kann nicht gestartet werden.';
      $data['head']['msg'] .= cs_html_br(1) . cs_link($cs_lang['back'],'converter','list');
      $data['display']['cms_import'] = 'none';
      $data['display']['error'] = 'block';
    }
  } else {
    $data['display']['cms_import'] = 'none';
    $data['import']['cms'] = '--';
    $data['head']['msg'] = 'Keine Informationen gefunden. Der Import kann nicht gestartet werden.';
    $data['head']['msg'] .= cs_html_br(1) . cs_link($cs_lang['back'],'converter','list');
  }
} else {
  // MySQL Class einbinden
  require_once('classes/mysql.class.php');

  // Neue MySQL Instanz erstellen
  $mysql = new MySQL;

  // MySQL Verbindung herstellen
  $mysql->connect($data['data']['dbplace'], $data['data']['dbuser'], $data['data']['dbpwd'], $data['data']['dbname']);

  // DZCP Artikel laden
  require_once('classes/dzcp1.0/dzcp_articles.php');


  // MySQL Verbindung schließen
  $mysql->disconnect();
}

echo cs_subtemplate(__FILE__,$data,'converter','convert');
?>
