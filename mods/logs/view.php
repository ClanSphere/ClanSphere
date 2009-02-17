<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('logs');

global $cs_logs;
if(!empty($_REQUEST['art']))
  $log_id = $_REQUEST['art'];

if($log_id == 1)
  $folder = 'errors';
elseif($log_id == 2)
  $folder = 'actions';
  
$log = $_REQUEST['log'];

$cs_sort[1] = 'logs_name DESC';
$cs_sort[2] = 'logs_name ASC';
$sort = empty($_REQUEST['sort']) ? 2 : $_REQUEST['sort'];
$order = $cs_sort[$sort];

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,2);
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_view'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb'); 
echo $cs_lang['body_view'];      
echo cs_html_roco(2,'rightb');
echo cs_link($cs_lang['back'],'logs','roots','where=' .$log_id);
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

function cs_filename($file)
{ 
  $extension = strlen(strrchr($file,".")); 
  $name = strlen($file); 
  $filename = substr($file,0,$name-$extension); 
  return $filename; 
}
$run = 0;
$handle = opendir($cs_logs['dir'] . '/' .$folder);
while ($file = readdir ($handle)) 
{
   if ($file != "." && $file != ".." && strrchr($file,".") == ".log")
   {
   $temp_file[$run] = $file;
   $run++;
   }
}
closedir($handle);
if(empty($temp_file)) {
  $temp_file = array();
}
$count_handle = count($temp_file);
if($sort == 2)
{
  rsort($temp_file);
}

$handle = file_get_contents($cs_logs['dir'] . '/' . $folder . '/' . $temp_file[$log]);
$handle = explode('--------',$handle); 
$handle_use = array();
$run1 = -1;
foreach($handle AS $temps)
{       
  $handle_use[$run1] = explode("\n",$temps);
  $run1++;  
}    
$handle_count = count($handle) - 1; 

echo cs_html_table(1,'forum',1);
for ($run = 0; $run < $handle_count; $run++)
{
  echo cs_html_roco(1,'leftc');
  echo $handle_use[$run][1];
  echo cs_html_roco(2,'leftb');
  echo $handle_use[$run][3];
  echo cs_html_roco(3,'leftc');
  echo cs_link($cs_lang['details'],'logs','view','art=' .$log_id .'&log=' . $log . '&id=' . $run .'#1');
}
echo cs_html_table(0);
echo cs_html_br(1); 
echo cs_html_anchor('1');
if(isset($_REQUEST['id']) AND $log_id == 1)
{
  $id = $_REQUEST['id'];
  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'leftc');
  echo cs_icon('1day') . $cs_lang['log_date'];
  echo cs_html_roco(2,'leftb');
  echo cs_filename($temp_file[$log]);
  echo ' / ' . $handle_use[$id][1];
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('mail_generic') . $cs_lang['name'];
  echo cs_html_roco(2,'leftb');
  echo $handle_use[$id][3];
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('access') . $cs_lang['error'];
  echo cs_html_roco(2,'leftb');
  echo $handle_use[$id][2];
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('access') . $cs_lang['error_2'];
  echo cs_html_roco(2,'leftb');
  echo $handle_use[$id][4];
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('history') . $cs_lang['ip'];
  echo cs_html_roco(2,'leftb');
  echo $handle_use[$id][6];
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('history') . $cs_lang['browser'];
  echo cs_html_roco(2,'leftb');
  echo $handle_use[$id][5];
  echo cs_html_roco(0);
  echo cs_html_table(0);
}
elseif(isset($_REQUEST['id']) AND $log_id == 2)
{
  $id = $_REQUEST['id'];
  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'leftc');
  echo cs_icon('1day') . $cs_lang['log_date'];
  echo cs_html_roco(2,'leftb');
  echo cs_filename($temp_file[$log]);
  echo ' / ' . $handle_use[$id][1];
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('access') . $cs_lang['error'];
  echo cs_html_roco(2,'leftb');
  echo $handle_use[$id][2];
  echo cs_html_roco(0);
  
  echo cs_html_roco(1,'leftc',0,2);
  echo cs_icon('mail_generic') . $cs_lang['name'];
  echo cs_html_roco(1,'leftb',0,2);
  echo $handle_use[$id][3];
  echo cs_html_roco(0);
  echo cs_html_table(0);
}

?>