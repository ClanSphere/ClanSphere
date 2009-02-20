<?php
$cs_lang = cs_translate('abcode');
$data = array();

// Hole Aktuelle Smilies aus der Datenbank
$select = "abcode_pattern, abcode_file";
$where = "abcode_func = 'img'";
$smilies = cs_sql_select(__FILE__,'abcode',$select,$where,0,0,0);

if(isset($_POST['submit'])) {

    $error = 0;
    $errormsg = $cs_lang['error'] . cs_html_br(1);
    
    // Doppelte Muster finden und löschen
    $_POST['pattern'] = array_unique($_POST['pattern']);
    
    for($run=0; $run<count($_POST['file']); $run++) {
        if(!empty($_POST['pattern'][$run])) {
            $data['file'][$run]['name'] = $_POST['file'][$run];
            $data['file'][$run]['preview'] = cs_html_img('uploads/abcode/' . $_POST['file'][$run]);
            if(!empty($smilies)) {
                for($runb=0; $runb<count($smilies); $runb++) {
                    if($_POST['pattern'][$run] == $smilies[$runb]['abcode_pattern']) {
                        $error++;
                        $errormsg .= sprintf($cs_lang['error_pattern_sql'], $_POST['file'][$run]) . cs_html_br(1);
                        $data['file'][$run]['run'] = '';
                    } else {
                        $data['file'][$run]['run'] = $_POST['pattern'][$run];
                    }
                }
            }
        } else {
            $error++;
            $errormsg .= sprintf($cs_lang['error_pattern'], $_POST['file'][$run]) . cs_html_br(1);
            $data['file'][$run]['name'] = $_POST['file'][$run];
            $data['file'][$run]['preview'] = cs_html_img('uploads/abcode/' . $_POST['file'][$run]);
            $data['file'][$run]['run'] = isset($_POST['pattern'][$run]) ? $_POST['pattern'][$run] : '' ;
        }
    }
} 

if(!empty($error)) {
    $data['head']['msg'] = $errormsg;
} else {
    $data['head']['msg'] = $cs_lang['new_import'];
}   

if(!isset($_POST['submit']) OR !empty($error)) {
	   $act_smilies = array();
     $all_smilies = array();	   
     if(!empty($smilies)) {
          for($run=0; $run<count($smilies); $run++) {
            $act_smilies[] = $smilies[$run]['abcode_file'];
          }
      }        
        
      // Hole alle Smilies aus dem uploads Ordner
      $pfad = "uploads/abcode";
      if ($handle = opendir($pfad)) {
          while (false !== ($file = readdir($handle))) {
              $substr = substr($file,-3);
              if ($file{0} != '.' AND $file != "index.html" AND ($substr == 'gif' OR $substr == 'jpg' OR $substr == 'png')) {
                  $all_smilies[] = $file;
              }
          }
      }
      $result = array_values(array_diff($all_smilies, $act_smilies));
      if(!empty($result)) {
          for($run=0; $run<count($result); $run++) {
              $data['file'][$run]['name'] = $result[$run];
              $data['file'][$run]['preview'] = cs_html_img('uploads/abcode/' . $result[$run]);
              $data['file'][$run]['run'] = empty($data['file'][$run]['run']) ? '' : $data['file'][$run]['run'];
          }
      }
} else {
    // SQL IMPORT
    for($run=0; $run<count($data['file']); $run++) {
        $sql_cells = array('abcode_func','abcode_pattern','abcode_file');
        $sql_saves = array('img',$data['file'][$run]['run'],$data['file'][$run]['name']);
        cs_sql_insert(__FILE__,'abcode',$sql_cells,$sql_saves);
    }
    cs_redirect($cs_lang['changes_done'],'abcode','manage');
}    
if(empty($data['file'])) {
  $data['if']['no_smilies'] = true;
  $data['if']['smilies'] = false;
}
else {
  $data['if']['no_smilies'] = false;
  $data['if']['smilies'] = true;	
}
echo cs_subtemplate(__FILE__,$data,'abcode','import');
?>
