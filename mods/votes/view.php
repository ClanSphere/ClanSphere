<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('votes');

$cs_votes_tpl = array();
$cs_votes_tpl['head']['mod'] = $cs_lang['mod_name'];
$cs_votes_tpl['head']['action'] = $cs_lang['head_list'];
$cs_votes_tpl['head']['body'] = $cs_lang['body_list'];
$cs_votes_tpl['lang']['vote_archive'] = $cs_lang['vote_archiv'];

echo cs_subtemplate(__FILE__,$cs_votes_tpl,'votes','view_head');

if(empty($_REQUEST['where'])) {
  cs_redirect($cs_lang['no_id'],'votes','list');
} else {
  $cs_votes_id = empty($_REQUEST['where']) ? $_GET['id'] : $_REQUEST['where'];
  settype($cs_votes_id,'integer');
  $from = 'votes';
  $select = 'votes_access, votes_question, votes_election, votes_close, votes_end, votes_several';
  $cs_votes = cs_sql_select(__FILE__,$from,$select,"votes_id = '" . $cs_votes_id . "'");
  $votes_access = $cs_votes['votes_access'];
  $cs_votes_save['voted_ip'] = cs_getip();
  $cs_votes_save['users_id'] = $account['users_id'];
  $user_id = $account['access_votes'];
  $votes_form = '1';
  if($votes_access > $user_id) {
    cs_redirect($cs_lang['no_access'],'votes','list');
    }
  else {
    $from = 'voted';
    $select = 'voted_id, users_id, voted_ip, voted_answer, voted_fid';
    $where = "voted_mod = 'votes' AND voted_fid = '" . $cs_votes_id . "'";
    $cs_voted = cs_sql_select(__FILE__,$from,$select,$where,'','0','0');
    $voted_loop = count($cs_voted);

    if(isset($_POST['submit']) )
    {
      if(!empty($voted_loop))
      {
        $where = "voted_mod = 'votes' AND voted_fid = '" . $cs_votes_id . "' AND voted_ip = '" . cs_sql_escape($cs_votes_save['voted_ip']) . "'";
        if($cs_votes_save['users_id'] > 0)
        {
          $where = "voted_mod = 'votes' AND voted_fid = '" . $cs_votes_id . "' AND users_id = '" . $cs_votes_save['users_id'] . "'";
        }
        $checkit_userip = cs_sql_count(__FILE__,'voted',$where);
      }

      $error = '';
      $errormsg = '';

      if(!empty($checkit_userip))
      {
        $error++;
        $errormsg .= $cs_lang['is_voted'] . cs_html_br(1);
      }
      $cs_votes_save['voted_time'] = cs_time();
      $cs_votes_save['voted_mod'] = 'votes';
      $cs_votes_save['voted_answer'] = empty($_POST['voted_answer']) ? 0 : $_POST['voted_answer'];

      $cs_votes_save['voted_fid'] = $_POST['votes_id'];
      if(empty($cs_votes_save['voted_answer']))
      {
        $error++;
        $errormsg .= $cs_lang['no_answer'] . cs_html_br(1);
      }
      if(empty($cs_votes_save['voted_fid']))
      {
        $error++;
        $errormsg .= $cs_lang['no_id'] . cs_html_br(1);
      }

      if(empty($error))
      {
        $votes_form = 0;
        if(isset($_POST['votes_several']) && !empty($cs_votes['votes_several'])) {
          
          $temp = explode("\n", $cs_votes['votes_election']);
          $count_election = count($temp);
          $count_voted = count($_POST['voted_answer']);
          $error_several = 0;
          $where = "voted_fid = '" . $cs_votes_id . "' AND voted_mod = 'votes' AND voted_ip = '" . cs_sql_escape($cs_votes_save['voted_ip']) . "'";
          $where .= ' AND users_id = "' . $cs_votes_save['users_id'] . '" AND (';
          $voting = array();
          
          foreach ($_POST['voted_answer'] AS $answer) {
            settype($answer, 'integer');
            if ($answer < 1 || $answer >= $count_election || in_array($answer, $voting)) {
              $error_several = 1;
              break;
            }
            $voting[] = $answer;
            $where .= 'voted_answer = "' . $answer . '" OR ';
          }
          $where = substr($where,0,-4) . ')';
          
          $error_several += cs_sql_count(__FILE__, 'voted', $where);
          
          if (!empty($error_several)) die('Multivote triggered an error with answers -> Execution halted.');
          
          foreach($_POST['voted_answer'] AS $answer) {
            $cs_votes_save['voted_answer'] = $answer;
            $votes_cells = array_keys($cs_votes_save);
            $votes_save = array_values($cs_votes_save);
            if(!empty($cs_votes_save['voted_answer']))
              cs_sql_insert(__FILE__,'voted',$votes_cells,$votes_save);
            else
              cs_error(__FILE__, 'Empty answer for multivote with ID ' . $cs_votes_id);
          }
        } else {
          $votes_cells = array_keys($cs_votes_save);
          $votes_save = array_values($cs_votes_save);
          if(!empty($cs_votes_save['voted_answer']))
            cs_sql_insert(__FILE__,'voted',$votes_cells,$votes_save);
          else
            cs_error(__FILE__, 'Empty answer for singlevote with ID ' . $cs_votes_id);
        }
        
        cs_redirect($cs_lang['success'],'votes','view','where='.$cs_votes_id);
      }
      else
      {
        $cs_votes_tpl['lang']['error_occurred'] = $cs_lang['error_occurred'];
        $cs_votes_tpl['error']['message'] = $errormsg;
        echo cs_subtemplate(__FILE__,$cs_votes_tpl,'votes','error');
      }
    }
    $check_user_voted = '';
    for ($run = 0; $run < $voted_loop; $run++)
    {
      $voted_users = $cs_voted[$run]['users_id'];
      $voted_ip = $cs_voted[$run]['voted_ip'];
      if($cs_votes_save['users_id'] > 0)
      {
        if($voted_users == $cs_votes_save['users_id'])
        {
          $check_user_voted++;
        }
      } else {
        if($voted_ip == $cs_votes_save['voted_ip'])
        {
          $check_user_voted++;
        }
      }
    }
    if (cs_time() >= $cs_votes['votes_end']) {
      $check_user_voted = 1;
    }
    if(!empty($votes_form))
    {
      if(empty($check_user_voted))
      {
        $cs_votes_tpl['lang']['create'] = $cs_lang['create'];
        $cs_votes_tpl['votes']['id']       = $cs_votes_id;
        $cs_votes_tpl['votes']['question'] = $cs_votes['votes_question'];
        $cs_votes_tpl['votes']['action']   = cs_url('votes','view','where='.$cs_votes_id);
        $cs_votes_tpl['if']['several'] = empty($cs_votes['votes_several']) ? 0 : 1;
         $cs_votes_tpl['if']['several_name'] = empty($cs_votes['votes_several']) ? 0 : 1;
        $cs_votes_tpl['votes']['type'] = empty($cs_votes['votes_several']) ? 'radio' : 'checkbox';

        $temp = explode("\n", $cs_votes['votes_election']);
        $answers_stop = count($temp) - 1;
        for ($run = 0; $run < $answers_stop; $run++)
        {
          $cs_votes_tpl['answers'][$run]['value'] = ($run + 1);
          $cs_votes_tpl['answers'][$run]['answer'] = $temp[($run + 1)];
        }
        echo cs_subtemplate(__FILE__,$cs_votes_tpl,'votes','view_vote');
      }
      elseif(!empty($cs_votes['votes_question']))
      {
        $cs_sort[0] = '';
        $cs_sort[1] = array('answer',SORT_DESC);
        $cs_sort[2] = array('answer',SORT_ASC);
        $cs_sort[3] = array('count',SORT_DESC);
        $cs_sort[4] = array('count',SORT_ASC);
        empty($_REQUEST['sort']) ? $sort = 0 : $sort = $_REQUEST['sort'];
        $order = $cs_sort[$sort];

        function cs_array_sort($array,$sort,$key)
        {
          foreach($array as $k) $s[] = $k[$key];
          array_multisort($s, $sort, $array);
          return $array;
        }

        $answers_count = '';
        for ($run = 0; $run < $voted_loop; $run++)
        {
          $voted_fid = $cs_voted[$run]['voted_fid'];
          if($voted_fid == $cs_votes_id)
          {
            $answers_count++;
          }
        }
        $temp = explode("\n", $cs_votes['votes_election']);
        $vote = array();
        $count_temp = count($temp);
        for ($run = 1; $run < $count_temp; $run++)
        {
          $answer_count = 0;
          for ($run_2 = 0; $run_2 < $voted_loop; $run_2++)
          {
            $voted_answer = $cs_voted[$run_2]['voted_answer'];
            $voted_fid = $cs_voted[$run_2]['voted_fid'];
            if($voted_answer == $run AND $voted_fid == $cs_votes_id)
            {
              $answer_count++;
            }
          }
          $num = $run - 1;
          $vote[$num] = array('count' => $answer_count, 'answer' => $temp[$run]);
        }
        if($sort !== 0)
        {
          $vote = cs_array_sort($vote,$order['1'],$order['0']);
        }
        $vote_loop = count($vote);
        for ($run = 0; $run < $vote_loop; $run++)
        {
          if(!empty($voted_loop))
          {
            $answer_proz = $vote[$run]['count'] / $answers_count * 100;
          }
          else
          {
            $answer_proz = '0';
          }
          $answer_proz = round($answer_proz,1);

          if(!empty($vote[$run]['count']))
          {
            $cs_votes_tpl['answers'][$run]['end_img'] = cs_html_img('symbols/votes/vote02.png','13','2');
          } else {
            $cs_votes_tpl['answers'][$run]['end_img'] = '';
          }

          $cs_votes_tpl['answers'][$run]['answer']  = $vote[$run]['answer'];
          $cs_votes_tpl['answers'][$run]['percent'] = $answer_proz;
          $cs_votes_tpl['answers'][$run]['count']    = $vote[$run]['count'];
        }

        $cs_votes_tpl['votes']['question'] = cs_secure($cs_votes['votes_question']);
        $cs_votes_tpl['votes']['answers_count'] = $answers_count;

        $cs_votes_tpl['lang']['answer']    = $cs_lang['answer'];
        $cs_votes_tpl['lang']['bar']      = $cs_lang['bar'];
        $cs_votes_tpl['lang']['percent']  = $cs_lang['percent'];
        $cs_votes_tpl['lang']['elections'] = $cs_lang['elections'];
        $cs_votes_tpl['lang']['total']    = $cs_lang['total'];

        $cs_votes_tpl['sort']['answer'] = cs_sort('votes','view',0,$cs_votes_id,1,$sort);
        $cs_votes_tpl['sort']['bar']    = cs_sort('votes','view',0,$cs_votes_id,3,$sort);
        $cs_votes_tpl['sort']['percent'] = cs_sort('votes','view',0,$cs_votes_id,3,$sort);
        $cs_votes_tpl['sort']['elections'] = cs_sort('votes','view',0,$cs_votes_id,3,$sort);

        echo cs_subtemplate(__FILE__,$cs_votes_tpl,'votes','view_result');

        $where3 = "comments_mod = 'votes' AND comments_fid = '" . $cs_votes_id . "'";
        $count_com = cs_sql_count(__FILE__,'comments',$where3);

        include_once('mods/comments/functions.php');

        if(!empty($count_com)) {
          echo cs_html_br(1);
          echo cs_comments_view($cs_votes_id,'votes','view',$count_com);
        }
        echo cs_comments_add($cs_votes_id,'votes',$cs_votes['votes_close']);
      }
    }
  }
}