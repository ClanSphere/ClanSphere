<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

$from  = 'boardfiles bdf INNER JOIN {pre}_threads thr ON bdf.threads_id = thr.threads_id ';
$from .= 'INNER JOIN {pre}_users usr ON thr.users_id = usr.users_id '; 
$select = 'bdf.boardfiles_id AS boardfiles_id, bdf.boardfiles_name AS boardfiles_name, bdf.boardfiles_downloaded AS boardfiles_downloaded, thr.threads_headline AS threads_headline, thr.threads_id AS threads_id, thr.threads_headline AS threads_headline, usr.users_nick AS users_nick';
$select .=', usr.users_id AS users_id';
$order = 'bdf.boardfiles_id DESC';
$cs_att = cs_sql_select(__FILE__,$from,$select,0,$order,0,0);

$count_att = count($cs_att);
$board_count = cs_sql_count(__FILE__,'board');


$data['count']['all'] = $count_att;

if(empty($count_att)) {
  $data['attachments'] = '';
}

require_once 'mods/clansphere/filetype.php';

for($run = 0; $run < $count_att; $run++) { 
  $file = $cs_att[$run]['boardfiles_name'];
  $extension = strlen(strrchr($file,"."));
  $name = strlen($file);
  $ext = substr($file,$name - $extension + 1,$name); 
  $ext_lower = strtolower($ext);
  
  $data['attachments'][$run]['icon'] = cs_filetype($ext_lower);

  if(file_exists('uploads/board/files/'.$cs_att[$run]['boardfiles_id'].'.'.$ext)) {
    $file_file = filesize('uploads/board/files/'.$cs_att[$run]['boardfiles_id'].'.'.$ext);
    $data['attachments'][$run]['filename'] = cs_html_link($cs_main['php_self']['dirname'].'mods/board/attachment.php?id='.$cs_att[$run]['boardfiles_id'],$file,1);
    $data['attachments'][$run]['size'] = cs_filesize($file_file);
  } elseif(file_exists('uploads/board/files/'.$file)) {
    $file_file = filesize('uploads/board/files/'.$file);
    $data['attachments'][$run]['filename'] = cs_html_link($cs_main['php_self']['dirname'].'mods/board/attachment.php?name='.$file,$file,1);
    $data['attachments'][$run]['size'] = cs_filesize($file_file);
  } else {
    $data['attachments'][$run]['filename'] = $cs_lang['no_att_exist'];
    $data['attachments'][$run]['size'] = cs_filesize(0);
  }
  
  $threads_headline = $cs_att[$run]['threads_headline'];
  $data['attachments'][$run]['topics'] = strlen($threads_headline) <= 15 ? $threads_headline : cs_substr($threads_headline,0,15) . '...';
  $data['attachments'][$run]['threads_headline'] = $threads_headline;
  
  $data['attachments'][$run]['topics_link'] = cs_url('board','thread','where=' . $cs_att[$run]['threads_id']);

  $data['attachments'][$run]['downloaded'] = $cs_att[$run]['boardfiles_downloaded'];
   
  $data['attachments'][$run]['user'] = $cs_att[$run]['users_nick'];
  $data['attachments'][$run]['user_link'] = cs_url('users','view','id=' . $cs_att[$run]['users_id']);
  $data['attachments'][$run]['remove'] = cs_url('board','delatt_admin','id=' . $cs_att[$run]['boardfiles_id']);
}  

echo cs_subtemplate(__FILE__,$data,'board','attachements_admin');