<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

if($cs_db['type'] == 'pdo_sqlite') {

  try {
    $cs_db['con'] = new PDO('sqlite:' . $cs_db['name']);
  }
  catch(PDOException $error) {
    $dberr = $error->getMessage();
  }
}
else {

  $param = empty($cs_db['place']) ? '' : 'host=' . $cs_db['place'] . ';';
  $param .= 'dbname=' . $cs_db['name'];

  try {
    $cs_db['con'] = new PDO(substr($cs_db['type'],4) . ':' . $param, $cs_db['user'], $cs_db['pwd']);
  }
  catch(PDOException $error) {
    $dberr = $error->getMessage();
  }
}

?>