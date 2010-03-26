<?php

function getNextThread($catid, $threads_time)
{
	settype($catid,'integer');

	$where = "board_id = '" . $catid . "' AND threads_time > '" . $threads_time . "'";
	$thread = cs_sql_select(__FILE__,'threads','threads_id',$where,'threads_time ASC');

	if (!empty($thread)) {
		return array(0 => $thread['threads_id'], 1 => -1);
	}

	$where = "board_id = '" . $catid . "' AND threads_time < '" . $threads_time . "'";
	$thread = cs_sql_select(__FILE__,'threads','threads_id',$where,'threads_time DESC');

	if (!empty($thread)) {
		return array(0 => -1, 1 => $thread['threads_id']);
	}
	return array(0 => -1, 1 => -1);

}

//-----------------------------------------------------------------------------
// Error Page for Errors(depending on language file)
//-----------------------------------------------------------------------------
function errorPage($section, $cs_lang, $error = 0)
{
	$data = array();
	$data['error']['section'] = empty($error) ? $cs_lang[$section.'_errortext'] : $error;
	echo cs_subtemplate(__FILE__,$data,'board','error_page');
}
//-----------------------------------------------------------------------------
// User Data Functions
//-----------------------------------------------------------------------------

function getUserAvatar($avatar = '')
{
	return empty($avatar) ? '' : cs_html_img('uploads/board/' . $avatar) . cs_html_br(1);
}

function getUserIcons($cs_lang,$users_id,$nick,$hidden = 0,$email=0,$icq=0, $msn=0, $url=0, $skype=0)
{
	global $account;
	$allow = $users_id == $account['users_id'] OR $account['access_users'] > 4 ? 1 : 0;
	$hidden = explode(',',$hidden);

	if (in_array('users_email',$hidden) && empty($allow)) $email = '';
	if (in_array('users_icq',$hidden) && empty($allow)) $icq = '';
	if (in_array('users_msn',$hidden) && empty($allow)) $msn = '';
	if (in_array('users_skype',$hidden) && empty($allow)) $skype = '';
	if (in_array('users_url',$hidden) && empty($allow)) $url = '';

	$icons = '';
	$icons .= !empty($email) ? cs_html_mail($email,cs_icon('mail_generic')) : '';
	$icons .= $account['access_users'] >= 2 ? cs_link(cs_icon('mail_send'),'messages','create','to=' . $nick,0,$cs_lang['send_message']) : '';
	$icons .= !empty($icq) ? cs_html_link('http://www.icq.com/scripts/search.dll?to=' . $icq,cs_icon('licq'),1,0,$cs_lang['icq']) : '';
	$icons .= !empty($msn) ? cs_html_link('http://members.msn.com/' . $msn,cs_icon('msn_protocol')) : '';
	$icons .= !empty($skype) ? cs_html_link('skype:' . $skype . '?userinfo',cs_html_img('http://mystatus.skype.com/smallicon/' . $skype,'16','16','0','Skype'),0,0,$cs_lang['skype']) : '';
	$icons .= !empty($url) ? cs_html_link('http://' . $url,cs_icon('gohome'),1,0,$cs_lang['homepage']) : '';

	return $icons;
}

function getUserPlace($cs_lang, $place = "")
{
	return empty($place) ? '' : $cs_lang['place'] . ': ' . cs_secure($place);
}

function getUserPosts($id)
{
	$cnt = cs_sql_count(__FILE__,'comments','users_id = \'' . $id . '\'');
	$topics = cs_sql_count(__FILE__,'threads','users_id = \'' . $id . '\'');
	return $cnt + $topics;
}

function getUserRank($posts,$data)
{
	$rank = 0;
	for($i=0;$i<sizeof($data);$i++)
	{
		if($data[$i]['boardranks_min'] < $posts)
		{
			if($i == 0)
			$range_bottom = 0;
			else
			$range_bottom = $data[$i]['boardranks_min'];
			if((sizeof($data)-1) == $i) // Wenn es der letzte rang i
			return cs_html_img("mods/board/rankimg.php?width=100");
			else
			$range_top = $data[$i+1]['boardranks_min'];
			if($posts < $range_top)
			{
				$rank = $range_top - $range_bottom;
				$posts = $posts - $range_bottom;
				$rank = (100 / $rank) * $posts;
				break;
			}
		}
	}
	$ranking = cs_html_img("mods/board/rankimg.php?width=" .$rank);
	return $ranking;
}

function getUserSignature($signature = '')
{
	if(!empty($signature))
	{
		$signature = cs_html_br(2) . "------------------". cs_html_br(1) . cs_secure($signature,1,1); //Formatierungen :D
	}
	return $signature;
}

function getReducedTitle($temp, $str)
{
	if(strlen($temp) > $str)
	{
		$temp = substr($temp,0,$str - 1);
		$cache = strrchr($temp," ");

		$temp = substr($temp,0,strlen($temp) - (strlen($cache)));
		$temp .= "...";
	}
	return $temp;
}
//-----------------------------------------------------------------------------
function getRankTitle($posts, $data)
{
	foreach ($data as $value)
	{
		if($posts >= $value['boardranks_min'])
		$rank = $value['boardranks_name'];
		else
		break;
	}
	return $rank;
}

function checkLastEdit($string ,$cs_lang ,$offset = 0)
{
	$sub_result = explode('/', $string);
	//Eigentlich w�rde ne Zahl oder Bool reichen, aber damit kann ich die Daten weiterverwenden
	if(empty($offset))
	{
		$result = cs_html_italic(1);
		$result .= $cs_lang['last_edit_by'];
		$result .= ' '.cs_user($sub_result[0],$sub_result[1]);
		$result .= ' '.$cs_lang['at'];
		$result .= ' '.cs_date('unix',$sub_result[2],1);
		$result .= ' ('.$sub_result[3].'x '.$cs_lang['overall_edit'].')';
		$result .= cs_html_italic(0);
		return $result;
	}
	else
	return $sub_result;
}
//-----------------------------------------------------------------------------
function last_comment($board_id,$users_id=0,$users_limit=20) {
	if(!empty($users_id)) {
		$comments_read = cs_sql_select(__FILE__,'read red','read_since','red.threads_id = ' . $board_id . ' AND red.users_id = ' . $users_id);
		if (!empty($comments_read['read_since'])) {
			$where = 'com.comments_fid = ' . $board_id . ' AND com.comments_mod = \'board\' AND com.comments_time > ' . $comments_read['read_since'];
			$comments_new = cs_sql_count(__FILE__,'comments com',$where);
			$comments_all = cs_sql_select(__FILE__,'threads thr','threads_comments','threads_id = '.$board_id);
			$opt_board_sort = cs_sql_select(__FILE__,'options opt','opt.options_value','opt.options_mod = \'board\' AND opt.options_name = \'sort\'');
			if ($opt_board_sort['options_value'] == 'ASC') {
				$comments_new = $comments_new-- > 0 ? $comments_all['threads_comments'] - $comments_new : $comments_all['threads_comments'];
				$com_start = (int) ($comments_new / $users_limit) * $users_limit;
			}
			else {
        if($comments_new <= 1)
          return '';
        else {
          $comments_new--;
          $com_start = (int) ($comments_new / $users_limit) * $users_limit;
          $comments_new = $comments_all['threads_comments'] - $comments_new;
        }
			}
			return '&amp;start=' . $com_start . '#com' . $comments_new;
		}
		else
			return '';
	}
	else
		return '';
}
//-----------------------------------------------------------------------------
function users_comments_toplist($count_limit=0, $start=0, $count_users_active=0, $count_comments=1, $count_threads=1) {
  $array_result = array();
  $toplist = array();
  $return = array();
  $count = 0;

  $comments = empty($count_comments) ? 0 : cs_sql_select(__FILE__, 'comments GROUP BY (users_id)', 'COUNT(*) AS important, users_id', 0, 'important DESC', 0, 0);
  $threads = empty($count_threads) ? 0 : cs_sql_select(__FILE__, 'threads GROUP BY (users_id)', 'COUNT(*) AS important, users_id', 0, 'important DESC', 0, 0);

  if (!empty($threads))
    foreach ($threads as $array)
      $array_result[ $array['users_id'] ] = empty($array_result[ $array['users_id'] ]) ? $array['important'] : $array_result[ $array['users_id'] ] +  $array['important'];
  if (!empty($comments))
    foreach ($comments as $array)
      $array_result[ $array['users_id'] ] = empty($array_result[ $array['users_id'] ]) ? $array['important'] : $array_result[ $array['users_id'] ] +  $array['important'];

  if (is_array($array_result))
    arsort($array_result);
  
  $count_limit = empty($count_limit) ? count($array_result) : $count_limit;
  
  if(!empty($count_users_active)) {
    $user_cond = '(';
    foreach ($array_result as $users_id => $comments)
      $user_cond .= 'users_id = "' . $users_id . '" OR ';
    $user_cond = substr($user_cond, 0, -4);
    $user_cond .= ') AND users_active = 1 AND users_delete = 0';

    $users_active = cs_sql_select (__FILE__, 'users', 'users_id, users_nick, users_active, users_delete', $user_cond, 0, 0, 0);
    return empty($users_active) ? 0 : count($users_active);
  }
  else {
    if(is_array($array_result)) {
      $toplist = array_slice ($array_result, $start, $count_limit, true);
      $count = count($array_result);
    }
    
    $user_cond = '';
    foreach ($toplist as $users_id => $noneed) $user_cond .= 'users_id = "' . $users_id . '" OR '; // Select only the users needed
    $user_cond = substr($user_cond, 0, -4);

    $user = cs_sql_select (__FILE__, 'users', 'users_id, users_nick, users_active, users_delete', $user_cond, 0, 0, 0);
    
    $array_result = array();
    foreach($user as $array)
      $array_result[ $array['users_id'] ] = $array;
    
    if (!empty($toplist))
      foreach ($toplist as $users_id => $comments) {
        $array_return[ $users_id ] = $array_result[$users_id];
        $array_return[ $users_id ]['comments'] = $comments;
      }
    
    return $array_return;
  }
}
//-----------------------------------------------------------------------------
