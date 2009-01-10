<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

$cs_usertime = cs_sql_select(__FILE__,'users','users_readtime',"users_id = '" . $account["users_id"] . "'");
$cs_readtime = cs_time() - $cs_usertime['users_readtime'];

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,4);
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_new'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo $cs_lang['body_new'];
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

$from = 'threads thr INNER JOIN {pre}_board frm ON frm.board_id = thr.board_id';
$conditions = "thr.threads_comments = 0 AND frm.board_access <= '" . $account['access_board'] . "' AND frm.board_pwd = '' AND thr.threads_last_time > '" . $cs_readtime . "'";
$cs_count = cs_sql_count(__FILE__,$from,$conditions);

$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'bottom',0,6); 
echo cs_html_div(1,'float:left');
echo $cs_lang['threads'] . ' ' . $cs_count;
echo cs_html_div(0);
echo cs_html_div(1,'float:right');
echo cs_pages('board','new',$cs_count,$start);
echo cs_html_div(0);
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc',0,2);
echo $cs_lang['thread'];
echo cs_html_roco(3,'leftc');
echo $cs_lang['replies'];
echo cs_html_roco(4,'leftc');
echo $cs_lang['hits'];
echo cs_html_roco(5,'leftc');
echo $cs_lang['lastpost'];
echo cs_html_roco(0);

$from = "threads thr INNER JOIN {pre}_board frm ON frm.board_id = thr.board_id INNER JOIN {pre}_categories cat ON cat.categories_id = frm.categories_id INNER JOIN {pre}_users usr ON thr.threads_last_user = usr.users_id LEFT JOIN {pre}_read red ON thr.threads_id = red.threads_id AND red.users_id = '" . $account['users_id'] . "'";
$select = 'thr.threads_id AS threads_id, thr.threads_headline AS threads_headline, thr.threads_view AS threads_view, thr.threads_comments AS threads_comments, thr.threads_important AS threads_important, thr.threads_close AS threads_close, thr.threads_last_time AS threads_last_time, usr.users_id AS users_id, usr.users_nick AS users_nick, usr.users_active AS users_active, red.read_since AS read_since';
$order = 'thr.threads_last_time DESC';
$cs_threads = cs_sql_select(__FILE__,$from,$select,$conditions,$order,$start,$account['users_limit']);

if(empty($cs_threads)) {
	echo cs_html_roco(1,'centerb',0,6);
	echo $cs_lang['no_threads'];
	echo cs_html_roco(0);
}
else {
	foreach($cs_threads AS $thread) {

		if(empty($thread['threads_comments'])) {
			include_once('mods/board/repair.php');
			$thread['threads_comments'] = cs_threads_comments($thread['threads_id']);
		}
		echo cs_html_roco(1,'leftb',0,0,'36px');
		$icon = 'post_';
		$tid = $thread['threads_id']; 
		if(!empty($account['users_id']) AND $thread['threads_last_time'] > $thread['read_since'])
			$icon .= 'unread_';
		if(!empty($thread['threads_close'])) 
			$icon .= 'close_';
		if($thread['threads_important'])
			$icon .= 'important_';	
			echo cs_html_img('symbols/board/' .$icon. '.png');
		echo cs_html_roco(2,'leftb');
		echo cs_html_big(1);
		if(!empty($thread['threads_important'])) {
			echo $cs_lang['important'] . ' ';
		}
		$headline = cs_secure($thread['threads_headline']);
		echo cs_link($headline,'board','thread','where=' . $thread['threads_id']);
		echo cs_html_big(0);
		if($thread['threads_comments'] > $account['users_limit']) {
			echo cs_html_br(1);
			echo $cs_lang['page'] . ' ';
			echo cs_pages('board','thread',$thread['threads_comments'],0,$thread['threads_id'],0,0,1);
		}
		echo cs_html_roco(3,'rightb',0,0,'60px');
		echo $thread['threads_comments'];
		echo cs_html_roco(4,'rightb',0,0,'60px');
		echo $thread['threads_view'];
		echo cs_html_roco(5,'leftb',0,0,'180px');
		if(!empty($thread['threads_last_time'])) {
			$date = cs_date('unix',$thread['threads_last_time'],1);
			$goto = floor($thread['threads_comments'] / $account['users_limit']) * $account['users_limit'];
			$goto .= '#' . $thread['threads_comments'];
			echo cs_link($date,'board','thread','where=' . $thread['threads_id'] . '&amp;start=' . $goto);
			if(!empty($thread['users_id'])) {
				echo cs_html_br(1);
				echo $cs_lang['from'] . ' ';
				echo cs_user($thread['users_id'],$thread['users_nick'], $thread['users_active']);
			}
		}
		echo cs_html_roco(0);
	}
}

echo cs_html_roco(1,'bottom',0,6); 
echo cs_html_div(1,'float:left');
echo $cs_lang['threads'] . ' ' . $cs_count;
echo cs_html_div(0);
echo cs_html_div(1,'float:right');
echo cs_pages('board','new',$cs_count,$start);
echo cs_html_div(0);
echo cs_html_roco(0);
echo cs_html_table(0);

?>