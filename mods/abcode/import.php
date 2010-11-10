<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$
$cs_lang = cs_translate('abcode');
$cs_post = cs_post();
$data = array();

$select = "abcode_pattern, abcode_file";
$where = "abcode_func = 'img'";
$smileys = cs_sql_select(__FILE__,'abcode',$select,$where,0,0,0);

if(isset($cs_post['submit'])) {
  $error = 0;
  $errormsg = $cs_lang['error'] . cs_html_br(1);
  
  $cs_post['pattern'] = array_unique($cs_post['pattern']);
  
  $counter = 0;
  for($run=0; $run<count($cs_post['file']); $run++) {
    if(!empty($cs_post['pattern'][$run])) {
      if(!empty($smileys)) {
        for($runb=0; $runb<count($smileys); $runb++) {
          if($cs_post['pattern'][$run] == $smileys[$runb]['abcode_pattern']) {
            $error++;
            $errormsg .= sprintf($cs_lang['error_pattern_sql'], $cs_post['file'][$run]) . cs_html_br(1);
            $data['file'][$run]['run'] = '';
          } else {
            $data['file'][$run]['run'] = $cs_post['pattern'][$run];
          }
        }
      }
    } else {
      $error++;
      $errormsg .= sprintf($cs_lang['error_pattern'], $cs_post['file'][$run]) . cs_html_br(1);
      $data['file'][$run]['run'] = isset($cs_post['pattern'][$run]) ? $cs_post['pattern'][$run] : '';
    }
    $data['file'][$run]['name'] = $cs_post['file'][$run];
    $data['file'][$run]['preview'] = cs_html_img('uploads/abcode/' . $cs_post['file'][$run]);
    $data['file'][$run]['order'] = empty($cs_post['order_'.$counter]) ? 0 : (int) $cs_post['order_'.$counter];
    $data['file'][$run]['counter'] = $counter;
    $counter++;
  }
}

if(!empty($error)) {
  $data['head']['msg'] = $errormsg;
}
else {
  $data['head']['msg'] = $cs_lang['new_import'];
}

if(!isset($cs_post['submit']) OR !empty($error)) {
   $act_smileys = array();
   $all_smileys = array();     
   if(!empty($smileys)) {
      for($run=0; $run<count($smileys); $run++) {
      $act_smileys[] = $smileys[$run]['abcode_file'];
      }
    }    
    
    $pfad = "uploads/abcode";
    $allowed = array('.gif', '.GIF', '.jpg', '.JPG', '.png', '.PNG', 'jpeg', 'JPEG');
    if ($handle = opendir($pfad)) {
      while (false !== ($file = readdir($handle))) {
        $cs_substr = cs_substr($file,-4);
        if ($file{0} != '.' AND in_array($cs_substr, $allowed)) {
          $all_smileys[] = $file;
        }
      }
    }
    $result = array_values(array_diff($all_smileys, $act_smileys));
    if(!empty($result)) {
      $counter = 0;
      for($run=0; $run<count($result); $run++) {
        $data['file'][$run]['name'] = $result[$run];
        $data['file'][$run]['preview'] = cs_html_img('uploads/abcode/' . $result[$run]);
        $data['file'][$run]['run'] = empty($data['file'][$run]['run']) ? '' : $data['file'][$run]['run'];
        $data['file'][$run]['order'] = empty($cs_post['order_'.$counter]) ? '' : (int) $cs_post['order_'.$counter];
        $data['file'][$run]['counter'] = $counter;
        $counter++;
      }
    }
}
else {
  for($run=0; $run<count($data['file']); $run++) {
    $sql_cells = array('abcode_func', 'abcode_pattern', 'abcode_file', 'abcode_order');
    $sql_saves = array('img', $data['file'][$run]['run'], $data['file'][$run]['name'], $data['file'][$run]['order']);
    cs_sql_insert(__FILE__,'abcode',$sql_cells,$sql_saves);
  }

  cs_cache_delete('abcode_smileys');
  cs_cache_delete('abcode_content');

  cs_redirect($cs_lang['changes_done'],'abcode','manage');
}

if(empty($data['file'])) {
  $data['if']['no_smileys'] = true;
  $data['if']['smileys'] = false;
}
else {
  $data['if']['no_smileys'] = false;
  $data['if']['smileys'] = true;  
}

echo cs_subtemplate(__FILE__,$data,'abcode','import');