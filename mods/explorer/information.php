<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('explorer');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['information'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc');

if(empty($_GET['file'])) {
  
  echo $cs_lang['no_object'] . ' ' . cs_link($cs_lang['back'],'explorer','roots');
  
} else {
  
  $dir = '';
  $single_dirs = explode('/',$_GET['file']);
  $count_dirs = count($single_dirs) - 1;
  
  for ($x = 0; $x < $count_dirs; $x++) {
    $dir .= $single_dirs[$x] . '/';
  }
  
  $file = @stat($_GET['file']);
  
  if (empty($file)) {
    
    echo $cs_lang['not_opened'];
    echo ' ' . cs_link($cs_lang['back'],'explorer','roots','dir='.$dir);
  
  } else {
  
    echo $cs_lang['get_information'] . ' ' . cs_link($cs_lang['back'],'explorer','roots','dir='.$dir);
    echo cs_html_roco(0);
    echo cs_html_table(0);
    echo cs_html_br(1);
  
    echo cs_html_table(1,'forum',1);
    echo cs_html_roco(1,'leftc');
    echo $cs_lang['f_name'];
    echo cs_html_roco(2,'leftb');
    echo $_GET['file'];
    echo cs_html_roco(0);
    echo cs_html_roco(1,'leftc');
    echo $cs_lang['f_size'];
    echo cs_html_roco(2,'leftb');
    $f_size = number_format($file[7]);
    $f_size = str_replace(',','.',$f_size);
    echo $f_size. ' ' . $cs_lang['bytes'];
    echo cs_html_roco(0);
    echo cs_html_roco(1,'leftc');
    echo $cs_lang['f_chmod'];
    echo cs_html_roco(2,'leftb');
    echo substr(sprintf('%o', fileperms($_GET['file'])), -4);
    echo cs_html_roco(0);
    echo cs_html_roco(1,'leftc');
    echo $cs_lang['f_change'];
    echo cs_html_roco(2,'leftb');
    echo date('d.m.Y',$file[10]) .', '. date('G:i',$file[10]) .' '.$cs_lang['o_clock'];
    echo cs_html_roco(0);
    echo cs_html_roco(1,'leftc');
    echo $cs_lang['f_last_access'];
    echo cs_html_roco(2,'leftb');
    echo date('d.m.Y',$file[8]) .', '. date('G:i',$file[8]) .' '.$cs_lang['o_clock'];
    echo cs_html_roco(0);
    echo cs_html_roco(1,'leftc');
    echo $cs_lang['f_owner'];
    echo cs_html_roco(2,'leftb');
    echo fileowner($_GET['file']);
    echo cs_html_roco(0);
    echo cs_html_roco(1,'leftc');
    echo $cs_lang['f_ownergroup'];
    echo cs_html_roco(2,'leftb');
    echo filegroup($_GET['file']);
    
  }
}
echo cs_html_roco(0);
echo cs_html_table(0);

?>