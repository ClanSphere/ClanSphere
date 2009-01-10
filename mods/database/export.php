<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('database');

$tables = empty($_POST['tables']) ? 0 : $_POST['tables'];
$prefix = empty($_POST['prefix']) ? '{pre}' : $_POST['prefix'];
$truncate = empty($_POST['truncate']) ? 0 : $_POST['truncate'];
$output = empty($_POST['output']) ? 'text' : $_POST['output'];

if($output != 'file' OR empty($_POST['tables'])) {

  if(!empty($_POST['submit']) AND empty($tables)) {
    $msg = $cs_lang['no_tables'];
  }
  else {
    $msg = $cs_lang['body_export'];
  }
  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'headb');
  echo $cs_lang['mod'] . ' - ' . $cs_lang['export'];
  echo cs_html_roco(0);
  echo cs_html_roco(1,'leftc');
  echo $msg;
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_br(1);
}

if(empty($_POST['tables'])) {

  echo cs_html_form(1,'database_export','database','export');
  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'headb',0,0,'200px');
  echo $cs_lang['sql_tables'];
  echo cs_html_roco(2,'headb',0,2);
  echo $cs_lang['sql_options'];
  echo cs_html_roco(0);
  echo cs_html_roco(1,'centerb',4,0);

  $modules = cs_checkdirs('mods');
  $static = array();

  echo cs_html_select(1, 'tables[]', 'id="sql_tables" multiple="multiple" size="8" style="width:90%"');

  foreach($modules as $mod) {

  	if((isset($account['access_' . $mod['dir'] . '']) OR $mod['dir'] == 'captcha') AND !empty($mod['tables'][0])) {

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
  foreach($static AS $sql_table => $mod) {
    echo cs_html_option($sql_table, $sql_table);
  }

  echo cs_html_select(0);
  echo cs_html_link("javascript:cs_select_multiple('sql_tables',1)",$cs_lang['all'],0) . ' - ';
  echo cs_html_link("javascript:cs_select_multiple('sql_tables',0)",$cs_lang['none'],0) . ' - ';
  echo cs_html_link("javascript:cs_select_multiple('sql_tables','reverse')",$cs_lang['reverse'],0);
  echo cs_html_roco(2,'leftc');
  echo $cs_lang['prefix'];
  echo cs_html_roco(3,'leftb');
  echo cs_html_input('prefix',$prefix,'text',20,20);
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo $cs_lang['datasets'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_vote('truncate',1,'checkbox',$truncate) . ' ' . $cs_lang['send_truncate'];
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo $cs_lang['output'];
  echo cs_html_roco(2,'leftb');
  $array = $output == 'file' ? array('text' => 0, 'file' => 1) : array('text' => 1, 'file' => 0);
  echo cs_html_vote('output','text','radio',$array['text']) . ' ' . $cs_lang['text'];
  echo cs_html_vote('output','file','radio',$array['file']) . ' ' . $cs_lang['file'];
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo $cs_lang['options'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_vote('submit',$cs_lang['export'],'submit');
  echo cs_html_roco(0);

  echo cs_html_table(0);
  echo cs_html_form(0);
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
    global $com_lang;
    echo cs_html_table(1,'forum',1);
    echo cs_html_roco(1,'leftb');
    echo nl2br(htmlentities($sql_content, ENT_QUOTES, $com_lang['charset']));
    echo cs_html_roco(0);
    echo cs_html_table(0);
  }
}

?>