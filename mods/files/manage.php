<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('files');

$categories_id = empty($_REQUEST['where']) ? 0 : $_REQUEST['where'];
settype($categories_id,'integer');
$where = empty($categories_id) ? 0 : 'categories_id = ' . cs_sql_escape($categories_id);

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'files_name DESC';
$cs_sort[2] = 'files_name ASC';
$cs_sort[3] = 'files_time DESC';
$cs_sort[4] = 'files_time ASC';
$sort = empty($_REQUEST['sort']) ? 3 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$files_count = cs_sql_count(__FILE__,'files',$where);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,3);
echo $cs_lang['mod'] . ' - ' . $cs_lang['manage'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo cs_icon('editpaste') . cs_link($cs_lang['new_file'],'files','create');
echo cs_html_roco(2,'leftb');
echo cs_icon('contents') . $cs_lang['total'] . ': ' . $files_count;
echo cs_html_roco(3,'rightb');
echo cs_pages('files','manage',$files_count,$start,$categories_id,$sort);
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb',0,3);
echo $cs_lang['category'];
echo cs_html_form(1,'files_manage','files','manage');
$filesmod = "categories_mod = 'files'";
$categories_data = cs_sql_select(__FILE__,'categories','*',$filesmod,'categories_name',0,0);
echo cs_dropdown('where','categories_name',$categories_data,$categories_id,'categories_id');
echo cs_html_vote('submit',$cs_lang['show'],'submit');
echo cs_html_form(0);
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

echo cs_getmsg();

$from = 'files fls LEFT JOIN {pre}_users usr ON fls.users_id = usr.users_id';
$select = 'fls.files_name AS files_name, fls.users_id AS users_id, usr.users_nick'; 
$select .= ' AS users_nick, usr.users_active AS users_active, fls.files_time AS files_time, fls.files_id AS files_id';
$select .= ', fls.files_mirror AS files_mirror';
$cs_files = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);
$files_loop = count($cs_files);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['typ'];
echo cs_html_roco(2,'headb');
echo cs_sort('files','manage',$start,$categories_id,1,$sort);
echo $cs_lang['headline'];
echo cs_html_roco(3,'headb');
echo $cs_lang['user'];
echo cs_html_roco(4,'headb');
echo cs_sort('files','manage',$start,$categories_id,3,$sort);
echo $cs_lang['date'];
echo cs_html_roco(5,'headb',0,3);
echo $cs_lang['options'];
echo cs_html_roco(0);

$img_del = cs_icon('editdelete',16,$cs_lang['remove']);
$img_edit = cs_icon('edit',16,$cs_lang['edit']);
$img_picture = cs_icon('image',16,$cs_lang['preview']);

for($run=0; $run<$files_loop; $run++)
{       
	echo cs_html_roco(1,'leftc');
	$files_mirror = $cs_files[$run]['files_mirror'];
	$temp = explode("-----", $files_mirror);
	$temp_loop = count($temp);
	$file_typ_array = array();
	$run_3 = '0';
	for ($run_2 = 1; $run_2 < $temp_loop; $run_2++)
	{
	  	$temp_a = explode("\n", $temp[$run_2]);
		if(in_array($temp_a['3'],$file_typ_array,TRUE))
		{}
		else
		{
			$file_typ_array[$run_3] = $temp_a['3'];
			$run_3++;
		}
	}
	$loop_file_typ_array = count($file_typ_array);
	for ($run_2 = 0; $run_2 < $loop_file_typ_array; $run_2++)
	{
		$ext = $file_typ_array[$run_2];
		echo cs_html_img('symbols/files/filetypes/' . $ext . '.gif',0,0,0,$ext);
	}
	echo cs_html_roco(2,'leftc');
	echo cs_link($cs_files[$run]['files_name'],'files','view','where=' .$cs_files[$run]['files_id']);
	echo cs_html_roco(3,'leftc');
	$cs_files_user = cs_secure($cs_files[$run]['users_nick']);
	echo cs_user($cs_files[$run]['users_id'],$cs_files[$run]['users_nick'], $cs_files[$run]['users_active']);
	echo cs_html_roco(4,'leftc');
	echo cs_date('unix',$cs_files[$run]['files_time'],1);
	echo cs_html_roco(5,'leftc');
	echo cs_link($img_picture,'files','picture','id=' . $cs_files[$run]['files_id'],0,$cs_lang['preview']);
	echo cs_html_roco(5,'leftc');
	echo cs_link($img_edit,'files','edit','id=' . $cs_files[$run]['files_id'],0,$cs_lang['edit']);
	echo cs_html_roco(6,'leftc');
	
	echo cs_link($img_del,'files','remove','id=' . $cs_files[$run]['files_id'],0,$cs_lang['remove']);
	echo cs_html_roco(0);
}
echo cs_html_table(0);
?>