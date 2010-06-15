<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('database');

$data['if']['form'] = FALSE;
$data['if']['output_text'] = FALSE;

$tables = empty($_POST['tables']) ? 0 : $_POST['tables'];
$prefix = empty($_POST['prefix']) ? '{pre}' : $_POST['prefix'];
$truncate = empty($_POST['truncate']) ? 0 : $_POST['truncate'];
$output = empty($_POST['output']) ? 'text' : $_POST['output'];

if($output != 'file' OR empty($_POST['tables'])) {

  if(!empty($_POST['submit']) AND empty($tables)) {
    $data['head']['body'] = $cs_lang['no_tables'];
  }
  else {
    $data['head']['body'] = $cs_lang['body_export'];
  }
  $data['if']['head'] = TRUE; # ????
}

if(empty($_POST['tables'])) {

  $data['if']['form'] = TRUE;

  $modules = cs_checkdirs('mods');
  $static = array();

  foreach($modules as $mod) {

    if((isset($account['access_' . $mod['dir'] . '']) OR $mod['dir'] == 'captcha' OR $mod['dir'] == 'pictures') AND !empty($mod['tables'][0])) {

      foreach($mod['tables'] AS $mod_table) {

        if(isset($static[$mod_table])) {
          cs_error(__FILE__, 'SQL-Table "' . $mod_table . '" is owned by two modules: "' . $static[$mod_table] . '" and "' . $mod['dir'] . '"');
        }
        else {
          $static[$mod_table] = $mod['dir'];
        }
      }
    }
  }

  ksort($static);
  $run = 0;
  foreach($static AS $sql_table => $mod) {
    $data['tables'][$run]['option'] = cs_html_option($sql_table, $sql_table);
  $run++;
  }

  $data['output']['prefix'] = $prefix;

  $checked = 'checked="checked"';
  $data['output']['truncate_check'] = empty($truncate) ? '' : $checked;

  $array = $output == 'file' ? array('text' => 0, 'file' => 1) : array('text' => 1, 'file' => 0);
  $data['output']['text_check'] = empty($array['text']) ? '' : $checked;
  $data['output']['file_check'] = empty($array['file']) ? '' : $checked;

}
else {

  $sql_content = '-- ClanSphere ' . $cs_main['version_name'] . ' SQL EXPORT' . "\n";
  $sql_content .= '-- ' . $cs_lang['tables'] . ': ' . count($tables) . "\n";
  $sql_content .= '-- ' . $cs_lang['date'] . ': ' . cs_date('unix',cs_time(),1) . "\n";

  foreach($tables AS $sql_table) {
    $sql_content .= "\n" . '-- --------------------------------------------------';
    $sql_content .= "\n" . '-- ' . sprintf($cs_lang['sql_data_for'],$sql_table) . "\n\n";
    $sql_content .= empty($truncate) ? '' : 'TRUNCATE TABLE ' . $prefix . '_' . $sql_table . ";\n\n";
    $content = cs_sql_select(__FILE__, $sql_table, '*', 0, 0, 0, 0);
    if(!empty($content)) {
      $pattern = 'INSERT INTO ' . $prefix . '_' . $sql_table . ' (';
      foreach($content[0] AS $column => $var) {
        $pattern .= $column . ', ';
      }
      $pattern = substr($pattern,0,-2) . ') VALUES (';
      foreach($content AS $dataset) {
        $values = '';
        foreach($dataset AS $var) {
          $values .= "'" . cs_sql_escape($var) . "', ";
        }
        $sql_content .= $pattern . substr($values,0,-2) . ");\n";
      }
    }
  }

  if($output == 'file') {
    ob_end_clean();
    header("Pragma:no-cache");
    header("Content-Type:text/sql");
    header("Content-Disposition:attachment; filename=clansphere_export.sql");
    die($sql_content);
  }
  else {
    $data['if']['output_text'] = TRUE;
    $data['output']['text'] = nl2br(htmlentities($sql_content, ENT_QUOTES, $cs_main['charset']));
  }
}

echo cs_subtemplate(__FILE__,$data,'database','export');