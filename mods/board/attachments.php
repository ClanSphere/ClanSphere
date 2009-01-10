<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

$from  = 'boardfiles bdf INNER JOIN {pre}_threads thr ON bdf.threads_id = thr.threads_id ';
$from .= 'INNER JOIN {pre}_users usr ON thr.users_id = usr.users_id '; 
$select = 'bdf.boardfiles_id AS boardfiles_id, bdf.boardfiles_name AS boardfiles_name, bdf.boardfiles_downloaded AS boardfiles_downloaded, thr.threads_headline AS threads_headline, thr.threads_id AS threads_id, thr.threads_headline AS threads_headline, usr.users_nick AS users_nick';
$order = 'bdf.boardfiles_id DESC';
$where = "bdf.users_id = '" . $account['users_id'] . "'";
$cs_att = cs_sql_select(__FILE__,$from,$select,$where,$order,0,0);

$count_abo = cs_sql_count(__FILE__,'abonements','users_id = \'' .$account['users_id'] . '\'');
$count_att = count($cs_att);

$data['link']['abos'] = cs_url('board','center');
$data['link']['abos_count'] = $count_abo;
$data['link']['attachments_count'] = $count_att;
$data['link']['avatar'] = cs_url('board','avatar');
$data['link']['signature'] = cs_url('board','signature');

if(empty($count_att)) {
  $data['attachments'] = '';
}

for($run = 0; $run < $count_att; $run++) { 
  $file = $cs_att[$run]['boardfiles_name'];
  $extension = strlen(strrchr($file,"."));
  $name = strlen($file);
  $ext = substr($file,$name - $extension + 1,$name); 
  
  $data['attachments'][$run]['img'] = cs_html_img('symbols/files/filetypes/' . $ext . '.gif',0,0,0,$ext);

  
  if(file_exists('uploads/board/files/' . $cs_att[$run]['boardfiles_id'] . '.' . $ext)) {
    $file_file = filesize('uploads/board/files/' . $cs_att[$run]['boardfiles_id'] . '.' . $ext);
    $data['attachments'][$run]['filename'] = cs_html_link('mods/board/attachment.php?id=' . $cs_att[$run]['boardfiles_id'],$file,1);
	$data['attachments'][$run]['size'] = cs_filesize($file_file);
  }
  elseif(file_exists('uploads/board/files/' . $file)) {
    $file_file = filesize('uploads/board/files/' . $file);
    $data['attachments'][$run]['filename'] = cs_html_link('mods/board/attachment.php?name='  .$file,$file,1);
	$data['attachments'][$run]['size'] = cs_filesize($file_file);
  }
  else {
    $data['attachments'][$run]['filename'] = $cs_lang['no_att_exist'];
	$data['attachments'][$run]['size'] = cs_filesize(0);
  }			

  $headline = strlen($cs_att[$run]['threads_headline']) <= 15 ? $cs_att[$run]['threads_headline'] : substr($cs_att[$run]['threads_headline'],0,15) . '...';
  $data['attachments'][$run]['topics'] = cs_link($headline,'board','thread','where=' . $cs_att[$run]['threads_id'],0,$cs_att[$run]['threads_headline']);
     
  $data['attachments'][$run]['downloaded'] = $cs_att[$run]['boardfiles_downloaded'];

  $img_del = cs_icon('editdelete',16,$cs_lang['remove']);
  $data['attachments'][$run]['remove'] = cs_link($img_del,'board','delatt','id=' . $cs_att[$run]['boardfiles_id'],0,$cs_lang['remove']);

}  

echo cs_subtemplate(__FILE__,$data,'board','attachments');
?>