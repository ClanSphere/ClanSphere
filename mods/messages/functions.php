<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

function cs_new_date($mode,$data,$show_time = 0) {
	global $com_lang;
	if($mode=='date' AND preg_match('=-=',$data)) {
		$explode = explode('-', $data);
		$data = mktime(0,0,1,$explode[1],$explode[2],$explode[0]);
	}
	else {
		global $account;
		$data = $data + $account['users_timezone'];
		$data = empty($account['users_dstime']) ?	$data : $data + 3600;
	}
	$var = date($com_lang['dateset'],$data);
	if(!empty($show_time)) {
		$var .= cs_html_br(1);
		$var .= ' ' . $com_lang['dtcon'] . ' ';
		$var .= date($com_lang['timeset'],$data);
		$var .= ' ' . $com_lang['timename'];
	}
	return $var;
}
function cs_box_head($box,$messages_id,$start,$sort) {
	global $cs_lang;
	global $account;
	$var = cs_html_table(1,'forum',1);
	$var .= cs_html_roco(1,'headb',0,5);
	$var .= $cs_lang['mod'] . ' - ' . $cs_lang['head_center_msg'];
	$var .= cs_html_roco(0);
	$var .= cs_html_roco(1,'leftb');
	$new_message = cs_icon('mail_new') . $cs_lang['new_message'];
	$var .= cs_link($new_message,'messages','create');
	$var .= cs_html_roco(2,'leftb');
	$users_id = $account['users_id'];
	$count_inbox = cs_sql_count(__FILE__,'messages',"users_id_to = '$users_id' AND messages_show_receiver = '1'");
	$inbox = cs_icon('inbox') . $cs_lang['inbox'] . $count_inbox;
	$var .= cs_link($inbox,'messages','inbox');
	$var .= cs_html_roco(3,'leftb');
	$count_outbox = cs_sql_count(__FILE__,'messages',"users_id = '$users_id' AND messages_show_sender = '1'");
	$outbox = cs_icon('outbox') . $cs_lang['outbox'] . $count_outbox;
	$var .= cs_link($outbox,'messages','outbox');
	$var .= cs_html_roco(4,'leftb');
	$count_archiv = cs_sql_count(__FILE__,'messages',"users_id = '$users_id' AND messages_archiv_sender = '1' OR users_id_to = '$users_id' AND messages_archiv_receiver = '1'");
	$img_archiv = cs_icon('queue') . $cs_lang['archivbox'] . $count_archiv;
	$var .= cs_link($img_archiv,'messages','archivbox');
	$var .=  cs_html_roco(5,'rightb');
	if($box == 'inbox') {
		$count = $count_inbox;
	} elseif($box == 'outbox') {
		$count = $count_outbox;
	} elseif($box == 'archivbox') {
		$count = $count_archiv;
	}
	$var .=  cs_pages('messages',$box,$count,$start,$users_id,$sort);
	$var .=  cs_html_roco(0);
	$var .=  cs_html_roco(1,'leftb');
	$var .=  cs_icon('email');
	$count_new = cs_sql_count(__FILE__,'messages',"users_id_to = '$users_id' AND messages_show_receiver = '1' AND messages_view = '0'");
	$var .= cs_link($count_new . $cs_lang['new_messages'],'messages','inbox','page=new');
	$var .= cs_html_roco(2,'leftb',0,4);
	$messages_data = cs_time_array();
	$var .= cs_html_form (1,'messages_filter','messages',$box);
	$var .= cs_dropdown('messages_id','messages_name',$messages_data,$messages_id);
	$var .= cs_html_vote('submit',$cs_lang['show'],'submit');
	$var .= cs_html_form (0);
	$var .= cs_html_roco(0);
	$var .= cs_html_table(0);
	return $var;
}
function cs_box($cs_messages,$run,$archiv = 0) {

	global $cs_lang;
  
	$var = cs_html_roco(1,'centerc');
	$messages_view = $cs_messages[$run]['messages_view'];
	$message_id = $cs_messages[$run]['messages_id'];
	if($messages_view == 0) {
		$var .= cs_icon('email',16,$cs_lang['new']);
	}
	if($messages_view == 1) {
		$var .= cs_icon('mail_generic',16,$cs_lang['read']);
	}
	if($messages_view == 2) {
		$var .= cs_icon('mail_replay',16,$cs_lang['answered']);
	}
	$var .= cs_html_roco(2,'leftc');
	$cs_messages_subject = cs_secure($cs_messages[$run]['messages_subject']);
	$var .= cs_link($cs_messages_subject,'messages','view','id=' . $cs_messages[$run]['messages_id']);
	$var .= cs_html_roco(3,'leftc');
	$cs_messages_user = cs_secure($cs_messages[$run]['users_nick']);
	$var .= cs_user($cs_messages[$run]['users_id'],$cs_messages[$run]['users_nick'], $cs_messages[$run]['users_active']);
  $var .= cs_html_roco(4,'leftc');
	$var .= cs_date('unix',$cs_messages[$run]['messages_time'],1);
  $var .= cs_html_roco(5,'centerc');
	$var .= cs_html_vote('select_' . $message_id,'1','checkbox');
	$var .= cs_html_roco(6,'centerc');
	$img_del = cs_icon('mail_delete',16,$cs_lang['remove']);
	$var .= cs_link($img_del,'messages','remove','id=' . $message_id,0,$cs_lang['remove']);
	if($archiv == 0) {
		$img_archiv = cs_icon('ark',16,$cs_lang['archiv']);
    $var .= cs_html_roco(7,'centerc');
		$var .= cs_link($img_archiv,'messages','archiv','id=' . $message_id,0,$cs_lang['archiv']);
	}
  ;
	$var .= cs_html_roco(0);
	return $var;
}
function cs_box_footer($box,$id = 0) {
	global $cs_lang;
	$messages_data = array (
	0 => array('id' => '1', 'name' => $cs_lang['do_delete']),
	1 => array('id' => '2', 'name' => $cs_lang['do_read']),
	2 => array('id' => '3', 'name' => $cs_lang['do_unread']),
	3 => array('id' => '4', 'name' => $cs_lang['do_archive']));
	$var = cs_html_roco(1,'rightb',0,7);
	$var .= cs_dropdown('id','name',$messages_data,$id);
	$var .= cs_html_vote('submit',$cs_lang['show'],'submit');
	$var .= cs_html_roco(0);
	$var .= cs_html_table(0);
	$var .= cs_html_form (0);
	return $var;
}
function cs_inbox_head($start,$sort) {

	global $cs_lang;
  
	$var = cs_html_table(1,'forum',1);
	$var .= cs_html_roco(1,'headb',0,0,'40px');
	$var .= cs_sort('messages','inbox',$start,'',5,$sort);
	$var .= cs_html_roco(2,'headb');
	$var .= cs_sort('messages','inbox',$start,'',3,$sort);
	$var .= $cs_lang['subject'];
	$var .= cs_html_roco(3,'headb');
	$var .= cs_sort('messages','inbox',$start,'',7,$sort);
	$var .= $cs_lang['from'];
	$var .= cs_html_roco(4,'headb');
	$var .= cs_sort('messages','inbox',$start,'',1,$sort);
	$var .= $cs_lang['date'];
	$var .= cs_html_roco(5,'headb',0,3,'80px');
	$var .= $cs_lang['options'];
	$var .= cs_html_roco(0);
  
	return $var;
}

function cs_archivbox_head($start,$sort) {

	global $cs_lang;
  
	$var = cs_html_table(1,'forum',1);
	$var .= cs_html_roco(1,'headb',0,0,'40px');
	$var .= cs_sort('messages','archivbox',$start,'',5,$sort);
	$var .= cs_html_roco(2,'headb');
	$var .= cs_sort('messages','archivbox',$start,'',3,$sort);
	$var .= $cs_lang['subject'];
	$var .= cs_html_roco(3,'headb');
	$var .= cs_sort('messages','archivbox',$start,'',7,$sort);
	$var .= $cs_lang['from'];
	$var .= cs_html_roco(4,'headb');
	$var .= cs_sort('messages','archivbox',$start,'',1,$sort);
	$var .= $cs_lang['date'];
	$var .= cs_html_roco(5,'headb',0,3,'80px');
	$var .= $cs_lang['options'];
	$var .= cs_html_roco(0);
  
	return $var;
}
function cs_outbox_head($start,$sort) {

	global $cs_lang;
  
	$var = cs_html_form (1,'messages_options','messages','more');
	$var .= cs_html_table(1,'forum',1);
	$var .= cs_html_roco(1,'headb',0,0,'40px');
	$var .= cs_sort('messages','outbox',$start,'',5,$sort);
	$var .= cs_html_roco(2,'headb');
	$var .= cs_sort('messages','outbox',$start,'',3,$sort);
	$var .= $cs_lang['subject'];
  $var .= cs_html_roco(3,'headb');
	$var .= cs_sort('messages','outbox',$start,'',7,$sort);
	$var .= $cs_lang['to'];
  $var .= cs_html_roco(4,'headb');
	$var .= cs_sort('messages','outbox',$start,'',1,$sort);
	$var .= $cs_lang['date'];
	$var .= cs_html_roco(5,'headb',0,3);
	$var .= $cs_lang['options'];
	$var .= cs_html_vote('allbox','1','checkbox',0,'id="checkall_all" onclick="js_check_all(this.form)"');
	$var .= cs_html_roco(0);
  
	return $var;
}
function cs_days($d = 0,$m = 0,$y = 0) {

	global $account;
	$var = mktime(0, 0, 0, date("m") - $m, date("d") - $d, date("Y")-$y) - $account['users_timezone'];
  
	return $var;
}
function cs_time_array() {
	global $cs_lang;
	$last_day      = cs_time() - 60 * 60 * 24;
	$last_2_days   = cs_time() - 60 * 60 * 24 *   2;
	$last_4_days   = cs_time() - 60 * 60 * 24 *   4;
	$last_7_days   = cs_time() - 60 * 60 * 24 *   7;
	$last_14_days  = cs_time() - 60 * 60 * 24 *  14;
	$last_21_days  = cs_time() - 60 * 60 * 24 *  21;
	$last_50_days  = cs_time() - 60 * 60 * 24 *  50;
	$last_100_days = cs_time() - 60 * 60 * 24 * 100;
	$last_365_days = cs_time() - 60 * 60 * 24 * 365;
	$last_730_days = cs_time() - 60 * 60 * 24 * 730;
  
	$messages_data = array (
	0 => array('messages_id' => '1', 'messages_time' => $last_day, 'messages_name' => $cs_lang['last_day']),
	1 => array('messages_id' => '2', 'messages_time' => $last_2_days, 'messages_name' => $cs_lang['last_2days']),
	2 => array('messages_id' => '3', 'messages_time' => $last_4_days, 'messages_name' => $cs_lang['last_4days']),
	3 => array('messages_id' => '4', 'messages_time' => $last_7_days, 'messages_name' => $cs_lang['last_week']),
	4 => array('messages_id' => '5', 'messages_time' => $last_14_days, 'messages_name' => $cs_lang['last_2weeks']),
	5 => array('messages_id' => '6', 'messages_time' => $last_21_days, 'messages_name' => $cs_lang['last_3weeks']),
	6 => array('messages_id' => '7', 'messages_time' => $last_50_days, 'messages_name' => $cs_lang['last_50days']),
	7 => array('messages_id' => '8', 'messages_time' => $last_100_days, 'messages_name' => $cs_lang['last_100days']),
	8 => array('messages_id' => '9', 'messages_time' => $last_365_days, 'messages_name' => $cs_lang['last_year']),
	9 => array('messages_id' => '10', 'messages_time' => $last_730_days, 'messages_name' => $cs_lang['last_2years']));
  
  return $messages_data;
}
function fetch_pm_period($array,$value) {
	$loop = count($array);
	for($run=0; $run<$loop; $run++) {
		if (empty($periods)) {
			$i = 0;
			$daynum = -1;
			$weekstart = 1 - 1;
			$timestamp = cs_days();
			$timestamp = $timestamp + 3600;
			$periods = array('today' => $timestamp);
			while ($daynum != $weekstart AND $i++ < 7) {
				$timestamp -= 86400;
				$daynum = date('w', $timestamp);
				if ($i == 1) {
					$periods['yesterday'] = $timestamp;
				} else {
					$periods[strtolower(date('l', $timestamp))] = $timestamp;
				}
			}
			$periods['last_week'] = $timestamp -= (7 * 86400);
			$periods['2_weeks_ago'] = $timestamp -= (7 * 86400);
			$periods['3_weeks_ago'] = $timestamp -= (7 * 86400);
			$periods['last_month'] = $timestamp -= (28 * 86400);
		}
		$periodtime2 = cs_time();
		foreach ($periods AS $periodname => $periodtime) {
			if ($array[$run][$value] >= $periodtime AND $array[$run][$value] <= $periodtime2) {
				$periodtime2 = $periodtime;
				$array[$run]['period'] = $periodname;
			}
		}
		if(empty($array[$run]['period'])) {
			$array[$run]['period'] = 'older';
		}
	}
	return $array;
}
function fetch_pm_period_count($array) {
	$loop = count($array);
	if(!empty($loop)) {
		for($run=0; $run<$loop; $run++) {
			if($run == 0) {
				$period = $array[$run]['period'];
				$count[$period] = 1;
			} elseif($period == $array[$run]['period']) {
				$count[$period]++;
			} elseif($period != $array[$run]['period']) {
				$period = $array[$run]['period'];
				$count[$period] = 1;
			}
		}
		return $count;
	}
}
function cs_period_roco($period,$count) {

	global $cs_lang, $account;
	
	$var = cs_html_roco(1,'leftb',0,7);
	$var .= cs_html_div(1,'float:left');
	$var .= $cs_lang[$period];
	$var .= cs_html_div(0);
	$var .= cs_html_div(1,'float:right');
	$var .= $cs_lang['mod'] . ': '. $count;
	$var .= cs_html_div(0);
	$var .= cs_html_roco(0);
  
	return $var;
}
function remove_dups($array, $row_element) {

	$new_array[0] = $array[0];
	foreach ($array as $current) {
		$add_flag = 1;
		foreach ($new_array as $temp) {
			if ($current[$row_element] == $temp[$row_element]) {
			 	$add_flag = 0;
				break;
			}
		}
		if ($add_flag) $new_array[] = $current;
	}
	return $new_array;
}
?>