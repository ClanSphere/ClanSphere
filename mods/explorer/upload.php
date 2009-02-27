<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('explorer');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['explorer'] . ' - ' . $cs_lang['upload2'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc');

if (empty($_POST['submit'])) {
  
  $dir = empty($_GET['dir']) ? '' : $_GET['dir'];
  $post_max_size = str_replace('M',' Mb', ini_get('post_max_size'));
  
  $name = empty($_POST['name']) ? '' : $_POST['name'];

  echo $cs_lang['max_upload'];
  echo $post_max_size . '.';
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_br(1);
  
  echo cs_html_form(1,'explorer_upload','explorer','upload',1);
  echo cs_html_table(1,'forum',1);
  
  echo cs_html_roco(1,'leftc',0,0,'25%');
  echo cs_icon('download') . $cs_lang['file'] . ' *';
  echo cs_html_roco(2,'leftb',0,0,'75%');
  echo cs_html_input('file','','file');
  echo cs_html_roco(0);
  
  echo cs_html_roco(1,'leftc');
  echo cs_icon('kedit') . $cs_lang['f_name'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('name',$name,'text',40,25);
  echo cs_html_br(1);
  $clip[1] = $cs_lang['infobox'];
  $clip[2] = nl2br($cs_lang['possible']);
  echo cs_abcode_clip($clip);
  echo cs_html_roco(0);
  
  if (isset($_POST['accessadd'])) {
    echo cs_html_roco(1,'leftc');
    echo cs_icon('access') . $cs_lang['minaccess'];
    echo cs_html_roco(2,'leftb');
    if (file_exists($dir.'/access.php')) {
      echo cs_html_select(1,'minaxx');
       echo cs_html_option('0 - '.$cs_lang['lev_0'],0);
       echo cs_html_option('1 - '.$cs_lang['lev_1'],1);
       echo cs_html_option('2 - '.$cs_lang['lev_2'],2);
       echo cs_html_option('3 - '.$cs_lang['lev_3'],3);
       echo cs_html_option('4 - '.$cs_lang['lev_4'],4);
       echo cs_html_option('5 - '.$cs_lang['lev_5'],5);
      echo cs_html_select(0);
    } else
      echo $cs_lang['no_accessfile'];
    echo cs_html_roco(0);
  }
  
  echo cs_html_roco(1,'leftc');
  echo cs_icon('ksysguard') . $cs_lang['options'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_vote('dir',$dir,'hidden');
  echo cs_html_vote('submit',$cs_lang['upload2'],'submit');
  if (substr($dir,0,5) == 'mods/' && strpos(substr($dir,5),'/') == strrpos(substr($dir,5),'/'))
    echo cs_html_vote('accessadd',$cs_lang['entry_in_accessfile'],'submit');
  echo cs_html_roco(0);
  
  echo cs_html_table(0);
  echo cs_html_form(0);
  
} else {
  
  $dir = empty($_POST['dir']) ? '' : $_POST['dir'];
  
  $filename = $dir;
  $extension = end(explode('.',$_FILES['file']['name']));
  
  if (empty($_POST['name'])) {
    $filename .= $_FILES['file']['name'];
    $action = substr($_FILES['file']['name'],0,strlen($_FILES['file']['name']) - strlen($extension) - 1);
  } else {
    $filename .= $_POST['name'];
    $filename .= '.' . strtolower($extension);
    $action = $_POST['name'];
  }
  
  if (@move_uploaded_file($_FILES['file']['tmp_name'],$filename)) {
    cs_redirect($cs_lang['success'],'explorer','roots','dir='.$dir);
  } else {
    cs_redirect($cs_lang['error_upload'],'explorer','roots','dir='.$dir);
  }
  
  if (isset($_POST['minaxx'])) {
    $array = file($dir.'/access.php');
    $string = '';
    $count_array = count($array);
    
    for ($run = 0; $run < $count_array; $run++) {
      if ($run == 4)
        $string .= '$axx_file[\''.$action.'\'] = '.$_POST['minaxx'].";\n\r";
      $string .= $array[$run];
    }
    
    $accessfile = fopen($dir.'/access.php','w');
    fwrite($accessfile, $string);
    fclose($accessfile);
  }
  
  echo cs_html_roco(0);
  echo cs_html_table(0);
  
}

?>