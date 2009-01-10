<?php
// ClanSphere 2008 - www.clansphere.net
// Id: functions.php (Tue Nov 18 00:19:18 CET 2008) fAY-pA!N

function cs_comments_view($com_fid,$mod,$action,$sum,$asc = true,$limit = 0) {

	$cs_lang = cs_translate('comments');

	$options = cs_sql_option(__FILE__,'comments');

	global $account;

	$class = 'leftb';
	$on_now = cs_time() - 300;
	$on_week = cs_time() - 604800;
	$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
	settype($start,'integer');
	settype($com_fid,'integer');
	settype($asc, 'boolean');
	settype($limit, 'integer');

	$data['comments']['sum'] = $sum;
    $data['comments']['message'] = cs_getmsg();
	$data['comments']['pages'] = cs_pages($mod,$action,$sum,$start,$com_fid);


	$where = "comments_mod = '" . cs_sql_escape($mod) . "' AND comments_fid = '" . $com_fid . "'";
	$from = 'comments com INNER JOIN {pre}_users usr ON com.users_id = usr.users_id ';
	$select = 'com.comments_id AS comments_id, com.comments_ip AS comments_ip, com.comments_time AS comments_time, com.comments_text AS comments_text, com.comments_edit AS comments_edit, com.users_id AS users_id, usr.users_nick as users_nick, usr.users_laston as users_laston, usr.users_place AS users_place, usr.users_country AS users_country, usr.users_avatar AS users_avatar, usr.users_hidden AS users_hidden, usr.users_active AS users_active, usr.users_invisible AS users_invisible';
	$order = $asc == true ? 'comments_id ASC' : 'comments_id DESC';
	$limit = !empty($limit) ? $limit : $account['users_limit'];
	$cs_com = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$limit);
	$com_loop = count($cs_com);
	for($run=0; $run<$com_loop; $run++) {

		$class = ($class == 'leftb') ? 'leftc' : 'leftb';
		$current = $start + $run + 1;

		$content[$run]['class'] = $class;
		$content[$run]['img_url'] = 'symbols/countries/' . $cs_com[$run]['users_country'] . '.png';
		$content[$run]['users_link'] = cs_user($cs_com[$run]['users_id'], $cs_com[$run]['users_nick'], $cs_com[$run]['users_active']);
		$content[$run]['comments_time'] = cs_date('unix',$cs_com[$run]['comments_time'],1);
		$content[$run]['users_status'] = cs_userstatus($cs_com[$run]['users_laston'],$cs_com[$run]['users_invisible']);
		$content[$run]['users_laston'] = !empty($cs_com[$run]['users_invisible']) ? '--' : cs_date('unix',$cs_com[$run]['users_laston']);
		$content[$run]['run'] = $asc == true ? ($run+1) : ($com_loop - $run);

		$content_place = cs_secure($cs_com[$run]['users_place']);
		$hidden = explode(',',$cs_com[$run]['users_hidden']);
		if(in_array('users_place',$hidden)) {
		  $content_place = ($account['access_users'] > 4 OR $cs_com[$run]['users_id'] == $account['users_id']) ? cs_html_italic(1) . $content_place . cs_html_italic(0) : '';
		}

		$content[$run]['users_avatar'] = empty($options['show_avatar']) || empty($cs_com[$run]['users_avatar']) ? '' : cs_html_img('uploads/board/' . $cs_com[$run]['users_avatar']);

		$users_place = empty($content_place);
		$content[$run]['content_place'] = !empty($users_place) ? '-' : $cs_com[$run]['users_place'];

		$who = "users_id = '" . $cs_com[$run]['users_id'] . "'";
		$count_user_com = cs_sql_count(__FILE__,'comments',$who);

		$content[$run]['posts'] = $count_user_com;
		$content[$run]['current'] = $current;
		$content[$run]['comments_text'] = cs_secure($cs_com[$run]['comments_text'],1,1);

		if(!empty($cs_com[$run]['comments_edit'])) {
			$edits = explode('/',$cs_com[$run]['comments_edit']);
			$euser = cs_user($edits[0],$edits[1]);
			$content[$run]['comments_edit'] = cs_html_br(3);
			$content[$run]['comments_edit'] .= cs_html_italic(1);
			$content[$run]['comments_edit'] .= sprintf($cs_lang['lastcom'],$euser,cs_date('unix',$edits[2],1),$edits[3]);
			$content[$run]['comments_edit'] .= cs_html_italic(0);
		} else { $content[$run]['comments_edit'] = ''; }


		if(!empty($account['users_id'])) {
			$content[$run]['edit_delete'] = cs_html_br(2);
			$content[$run]['edit_delete'] .= cs_html_div(1,'float:right');
			$img_quote = cs_icon('editcut',16,$cs_lang['quote']);
			$content[$run]['edit_delete'] .= cs_link($img_quote,$mod,'com_create','id=' . $cs_com[$run]['comments_id'],0,$cs_lang['quote']);

			if($cs_com[$run]['users_id'] == $account['users_id'] OR $account['access_comments'] >= 4) {
				$img_edit = cs_icon('edit',16,$cs_lang['edit']);
				$content[$run]['edit_delete'] .= cs_link($img_edit,$mod,'com_edit','id=' . $cs_com[$run]['comments_id'],0,$cs_lang['edit']);
			}
			if($account['access_comments'] >= 5) {
				$img_del = cs_icon('editdelete',16,$cs_lang['remove']);
				$content[$run]['edit_delete'] .=  cs_link($img_del,$mod,'com_remove','id=' . $cs_com[$run]['comments_id'],0,$cs_lang['remove']);
			}
			$content[$run]['edit_delete'] .= cs_html_div(0);
		}
		else { $content[$run]['edit_delete'] = ''; }

	}

	$data['content'] = !empty($content) ? $content : '';
	echo cs_subtemplate(__FILE__,$data,'comments','com_view');
}


function cs_comments_add($com_fid,$mod,$close = 0) {

	$cs_lang = cs_translate('comments');

	global $account;
	$cs_abcode = cs_sql_option(__FILE__,'abcode');
	
	$data['if']['adv_com'] = TRUE;

	settype($com_fid,'integer');
	settype($close,'integer');
	$where = "comments_mod = '" . cs_sql_escape($mod) . "' AND comments_fid = '" . $com_fid . "'";
	$last_from = cs_sql_select(__FILE__,'comments','users_id',$where,'comments_id DESC');

	if(empty($account['users_id'])) {
		$data['lang']['need_user'] = $cs_lang['need_user'];
	  echo cs_subtemplate(__FILE__,$data,'comments','need_user');
	}
	elseif(!empty($close)) {
		$data['lang']['closed'] = $cs_lang['closed'];
	  echo cs_subtemplate(__FILE__,$data,'comments','close');
	}
	elseif($account['users_id'] == $last_from['users_id']) {
		$data['lang']['last_own'] = $cs_lang['last_own'];
	  echo cs_subtemplate(__FILE__,$data,'comments','last_own');
	}
	else {

		if(empty($cs_abcode['def_abcode'])) {
			$data['comments']['abcode'] =  '';
			$data['comments']['smilies'] = '';
		}
		else {
			$data['if']['adv_com'] = FALSE;
			$data['comments']['abcode'] =  cs_abcode_features('comments_text',1);
			$data['comments']['smilies'] = cs_abcode_smileys('comments_text');
		}

		$data['url']['create'] = cs_url($mod,'com_create','fid=' . $com_fid);

		$data['comments']['fid'] = $com_fid;
	  echo cs_subtemplate(__FILE__,$data,'comments','com_add');
	}
}


function cs_commments_create($com_fid,$mod,$action,$quote_id,$mod_name,$close = 0,$more = 'id') {

	$cs_lang = cs_translate('comments');

	global $account, $cs_main;
	
	settype($com_fid,'integer');
	settype($quote_id,'integer');
	settype($close,'integer');

	$data['head']['mod'] = $mod_name;
	$data['if']['preview'] = false;

	if(!empty($quote_id)) {
		$cells = 'users_id, comments_text, comments_time, comments_fid';
		$cs_com = cs_sql_select(__FILE__,'comments',$cells,"comments_id = '" . $quote_id . "'");
		$com_fid = $cs_com['comments_fid'];
		$cs_users = cs_sql_select(__FILE__,'users','users_nick',"users_id = '" . $cs_com['users_id'] . "'");
		$url = cs_url('users','view','id=' . $cs_com['users_id']);
		$text = cs_date('unix',$cs_com['comments_time'],1) . ' - [url=' . $url . ']';
		$text .= $cs_users['users_nick'] . "[/url]:\r\n[quote]" . $cs_com['comments_text'] . '[/quote]';
	}
	elseif(isset($_POST['submit']) OR isset($_POST['preview']) OR isset($_POST['advanced'])) {

		$text = $_POST['comments_text'];

		$error = '';

		if(empty($text)) {
			$error .= $cs_lang['no_text'] . cs_html_br(1);
		}

		$find = "comments_mod = '".$mod."' AND comments_fid = '" . $com_fid . "'";
		$last_from = cs_sql_select(__FILE__,'comments','users_id',$find,'comments_id DESC');
		if($account['users_id'] == $last_from['users_id']) {
    		$error .= $cs_lang['last_own'] . cs_html_br(1);
		}

		$where = "users_id = '" . $account['users_id'] . "' AND comments_mod = '".$mod."'";
		$flood = cs_sql_select(__FILE__,'comments','comments_time',$where,'comments_time DESC');
		$maxtime = $flood['comments_time'] + $cs_main['def_flood'];
		if($maxtime > cs_time()) {
			$diff = $maxtime - cs_time();
			$error .= sprintf($cs_lang['flood_on'], $diff);
		}

		if(!empty($close)) {
    		$error .= $cs_lang['closed'] . cs_html_br(1);
		}
	}
	else {
		$text = '';
	}

	if(!isset($_POST['submit']) AND !isset($_POST['preview'])) {
  		$data['head']['body'] = $cs_lang['body_com_create'];
	}
	elseif(!empty($error)) {
  		$data['head']['body'] = $error;
	}
	elseif(isset($_POST['preview'])) {
  		$data['head']['body'] = $cs_lang['preview'];
	}

	if(isset($_POST['preview']) AND empty($error)) {

		$data['if']['preview'] = true;
		$userid = $account['users_id'];
		$select = 'users_nick, users_laston, users_place, users_country, users_active, users_invisible';
		$cs_user = cs_sql_select(__FILE__,'users',$select,"users_id = '" . $userid . "'");

		$user = cs_secure($cs_user['users_nick']);
		$url = 'symbols/countries/' . $cs_user['users_country'] . '.png';
		$data['prev']['flag'] = cs_html_img($url,11,16);
		$data['prev']['user'] = cs_user($userid,$cs_user['users_nick'], $cs_user['users_active']);

		$data['prev']['status'] = cs_userstatus($cs_user['users_laston'],$cs_user['users_invisible']);
		$data['prev']['laston'] = empty($cs_user['users_invisible']) ? '--' : cs_date('unix',$cs_user['users_laston']);

		$place = empty($cs_user['users_place']) ? '-' : $cs_user['users_place'];
		$data['prev']['place'] = cs_secure($place);

		$who = "users_id = '" . $userid . "'";
		$count_com[$userid] = cs_sql_count(__FILE__,'comments',$who);
		$data['prev']['posts'] = $count_com[$userid];

		$opt = "comments_mod = '".$mod."' AND comments_fid = '" . $com_fid . "'";
		$count_com = cs_sql_count(__FILE__,'comments',$opt);
		$data['prev']['count_com'] = ($count_com + 1);
		$data['prev']['date'] = cs_date('unix',cs_time(),1);
		$data['prev']['text'] = cs_secure($text,1,1);
	}

	if(!empty($error) OR isset($_POST['preview']) OR !isset($_POST['submit'])) {

		$data['com']['form_name'] = $mod . '_com_create';
		$data['com']['form_url'] = cs_url($mod,'com_create');
		$data['com']['smileys'] = cs_abcode_smileys('comments_text');
		$data['com']['abcode'] = cs_abcode_features('comments_text');
		$data['com']['text'] = $text;
		$data['com']['fid'] = $com_fid;

	  echo cs_subtemplate(__FILE__,$data,'comments','com_create');
		
		require_once('mods/comments/functions.php');
		$com_where = "comments_mod = '".$mod."' AND comments_fid = '".$com_fid."'";
		$count = cs_sql_count(__FILE__,'comments',$com_where);
	  cs_comments_view($com_fid,$mod,'com_create',$count,false,5);
		
	}
	else {
		$opt = "comments_mod = '" . $mod . "' AND comments_fid = '" . $com_fid . "'";
		$count_com = cs_sql_count(__FILE__,'comments',$opt);
		$start = floor($count_com / $account['users_limit']) * $account['users_limit'];

		$user_ip = $_SERVER['REMOTE_ADDR'];
		$com_cells = array('users_id', 'comments_fid', 'comments_mod', 'comments_ip', 'comments_time', 'comments_text');
		$com_save = array($account['users_id'], $com_fid, $mod, $user_ip, cs_time(), $text);
	  cs_sql_insert(__FILE__,'comments',$com_cells,$com_save);

		$more_action = $more. '=' . $com_fid . '&amp;start=' . $start . '#com' . ++$count_com;
		
	  cs_redirect($cs_lang['create_done'],$mod,$action,$more_action);
	}
}


function cs_comments_edit($mod,$action,$com_id,$mod_name,$more = 'id') {
	
	$cs_lang = cs_translate('comments');
	
	global $account;
	
	settype($com_id,'integer');
	
	$cells = 'users_id, comments_text, comments_time, comments_fid, comments_edit';
	$cs_comments = cs_sql_select(__FILE__,'comments',$cells,"comments_id = '" . $com_id . "'");
	$com_fid = $cs_comments['comments_fid'];
	
	$data['head']['mod'] = $mod_name;
	$data['if']['preview'] = false;

	if(isset($_POST['submit']) OR isset($_POST['preview'])) {

		$cs_comments['comments_text'] = $_POST['comments_text'];

		$error = '';

		if(empty($cs_comments['comments_text'])) {
			$error .= $cs_lang['no_text'] . cs_html_br(1);
		}
		if($cs_comments['users_id'] != $account['users_id'] AND $account['access_comments'] < 4) {
			$error .= $cs_lang['low_axx'] . cs_html_br(1);
		}
	}
	
	if(!isset($_POST['submit']) AND !isset($_POST['preview'])) {
	  $data['head']['body'] = $cs_lang['body_com_edit'];
	}
	elseif(!empty($error)) {
	  $data['head']['body'] = $error;
	}
	elseif(isset($_POST['preview'])) {
	  $data['head']['body'] = $cs_lang['preview'];
	}

	if(isset($_POST['preview']) AND empty($error)) {

		$data['if']['preview'] = true;
		$userid = $account['users_id'];
		$select = 'users_nick, users_laston, users_place, users_country, users_active, users_invisible';
		$cs_user = cs_sql_select(__FILE__,'users',$select,"users_id = '" . $userid . "'");

		$user = cs_secure($cs_user['users_nick']);
		$url = 'symbols/countries/' . $cs_user['users_country'] . '.png';
		$data['prev']['flag'] = cs_html_img($url,11,16);
		$data['prev']['user'] = cs_user($userid,$cs_user['users_nick'], $cs_user['users_active']);

		$data['prev']['status'] = cs_userstatus($cs_user['users_laston'],$cs_user['users_invisible']);
		$data['prev']['laston'] = empty($cs_user['users_invisible']) ? '--' : cs_date('unix',$cs_user['users_laston']);

		$place = empty($cs_user['users_place']) ? '-' : $cs_user['users_place'];
		$data['prev']['place'] = cs_secure($place);

		$who = "users_id = '" . $userid . "'";
		$count_com[$userid] = cs_sql_count(__FILE__,'comments',$who);
		$data['prev']['posts'] = $count_com[$userid];

		$opt = "comments_mod = '".$mod."' AND comments_fid = '" . $com_fid . "'";
		$count_com = cs_sql_count(__FILE__,'comments',$opt);
		$data['prev']['count_com'] = ($count_com + 1);
		$data['prev']['date'] = cs_date('unix',cs_time(),1);
		$data['prev']['text'] = cs_secure($cs_comments['comments_text'],1,1);
	}

	if(!empty($error) OR isset($_POST['preview']) OR !isset($_POST['submit'])) {

		$data['com']['form_name'] = $mod . '_com_edit';
		$data['com']['form_url'] = cs_url($mod,'com_edit');
		$data['com']['smileys'] = cs_abcode_smileys('comments_text');
		$data['com']['abcode'] = cs_abcode_features('comments_text');
		$data['com']['text'] = $cs_comments['comments_text'];
		$data['com']['id'] = $com_id;

	  echo cs_subtemplate(__FILE__,$data,'comments','com_edit');
	}
	else {
		$opt = "comments_mod = '" . $mod . "' AND comments_fid = '" . $com_fid . "'";
		$opt .= " AND comments_id <= '" . $com_id . "'";
		$count_com = cs_sql_count(__FILE__,'comments',$opt);
		$start = floor($count_com / $account['users_limit']) * $account['users_limit'];

		if(!empty($cs_comments['comments_edit'])) {
			$edits = explode('/',$cs_comments['comments_edit']);
			$edits_count = $edits[3] + 1;
		}
		else {
			$edits_count = 1;
		}
		$com_edits = $account['users_id'].'/'.$account['users_nick'].'/'.cs_time().'/'.$edits_count;	

		$com_cells = array('comments_text','comments_edit');
		$com_save = array($cs_comments['comments_text'],$com_edits);
	  cs_sql_update(__FILE__,'comments',$com_cells,$com_save,$com_id);

		$more_action = $more .'=' . $com_fid . '&amp;start=' . $start . '#com' . $count_com;
		
	  cs_redirect($cs_lang['changes_done'],$mod,$action,$more_action);
	}
	
}


function cs_comments_remove($mod,$action,$com_id,$mod_name,$more = 'id') {

	$cs_lang = cs_translate('comments');

	global $account;
	
	$data['head']['mod'] = $mod_name;
	
	$cells = 'comments_fid, comments_id';
	$cs_comments = cs_sql_select(__FILE__,'comments',$cells,"comments_id = '" . $com_id . "'");
	$com_fid = $cs_comments['comments_fid'];
	$where = "comments_id > '" . $com_id . "' AND comments_fid = '" . $com_fid . "'";
	$where .= " AND comments_mod = '" . $mod . "'";
	$before = cs_sql_count(__FILE__,'comments',$where);
	$start = floor($before / $account['users_limit']) * $account['users_limit'];

	$more_action = $more . '=' . $com_fid . '&amp;start=' . $start;

	if(isset($_POST['agree'])) {
	  cs_sql_delete(__FILE__,'comments',$com_id);
	  cs_redirect($cs_lang['del_true'],$mod,$action,$more_action);
	}

	if(isset($_POST['cancel'])) {
	  cs_redirect($cs_lang['del_false'],$mod,$action,$more_action);
	}

	if(!empty($com_id)) {
		$data['com']['form_name'] = $mod . '_com_remove';
		$data['com']['form_url'] = cs_url($mod,'com_remove');
		$data['head']['body_com_remove'] = sprintf($cs_lang['del_rly'],$com_id);
		$data['com']['id'] = $com_id;
		
	  echo cs_subtemplate(__FILE__,$data,'comments','com_remove');
	}
}

?>