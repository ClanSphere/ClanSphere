<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

$data = array();

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'boardreport_time DESC';
$cs_sort[2] = 'boardreport_time ASC';
$cs_sort[3] = 'boardreport_done DESC, boardreport_time DESC';
$cs_sort[4] = 'boardreport_done ASC, boardreport_time DESC';
$cs_sort[5] = 'threads_headline DESC';
$cs_sort[6] = 'boardreport_time ASC';
$sort = empty($_REQUEST['sort']) ? 1 : $_REQUEST['sort'];
$order = $cs_sort[$sort];

$data['lang']['getmsg'] = cs_getmsg();

$data['head']['boardreport_count'] = cs_sql_count(__FILE__,'boardreport');
$data['head']['pages'] = cs_pages('board','reportlist',$data['head']['boardreport_count'],$start,0,$sort);

$data['sort']['boardreport_time'] = cs_sort('board','reportlist',$start,0,1,$sort);
$data['sort']['boardreport_done'] = cs_sort('board','reportlist',$start,0,3,$sort);
$data['sort']['threads_headline'] = cs_sort('board','reportlist',$start,0,5,$sort);

$from    = 'boardreport bdr INNER JOIN {pre}_threads thr ON bdr.threads_id = thr.threads_id';
$select  = 'bdr.boardreport_time AS boardreport_time, bdr.boardreport_done AS boardreport_done, bdr.threads_id AS threads_id, thr.threads_headline AS threads_headline, bdr.comments_id AS comments_id';

$cs_report = cs_sql_select(__FILE__,$from,$select,0,$order,$start,$account['users_limit']);
$report_loop = count($cs_report);
$data['boardreport'] = array();
for($run=0; $run<$report_loop; $run++) {

  $data['boardreport'][$run]['boardreport_time'] = cs_date('date',$cs_report[$run]['boardreport_time'],1);
  $data['boardreport'][$run]['boardreport_done'] = empty($cs_report[$run]['boardreport_done']) ? $cs_lang['no'] : $cs_lang['yes'];

  $headline = cs_secure($cs_report[$run]['threads_headline']);
  // $comments_count = empty($cs_report[$run]['comments_id']) ? 0 : cs_sql_count(__FILE__,'comments',"comments_mod = 'board' AND comments_fid = '" . $cs_report[$run]['threads_id'] . "'");
  // $goto = floor($comments_count / $account['users_limit']) * $account['users_limit'] . '#com' . $comments_count;
  $link = cs_link($headline,'board','thread','where=' . $cs_report[$run]['threads_id']); // . '&amp;start=' . $goto);
  $data['boardreport'][$run]['threads_headline'] = $link . ' #' . $cs_report[$run]['comments_id'];
}
echo cs_subtemplate(__FILE__,$data,'board','reportlist');