<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');

$data = array();

$guests_search = empty($_POST['guests_search']) ? 0 : $_POST['guests_search'];
$guests_search = empty($_REQUEST['where']) ? $guests_search : $_REQUEST['where'];
$data['guests']['search'] = empty($guests_search) ? '' : cs_secure($guests_search);
$guests_url = rawurlencode(str_replace(array('/', '&', '\\'), '', $guests_search));

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'users_nick DESC';
$cs_sort[2] = 'users_nick ASC';
$cs_sort[3] = 'usr.users_surname DESC, egt.eventguests_surname DESC';
$cs_sort[4] = 'usr.users_surname ASC, egt.eventguests_surname ASC';
$sort = empty($_REQUEST['sort']) ? 4 : $_REQUEST['sort'];
$order = $cs_sort[$sort];

$search_fields = array('usr.users_nick', 'usr.users_name', 'usr.users_surname',
                       'egt.eventguests_name', 'egt.eventguests_surname');
$search_terms = (strlen($guests_search) > 2) ? explode(' ', $guests_search) : array();

$where = '';
foreach($search_terms AS $term) {
  if(strlen(trim($term)) > 2) {
    $where .= '(';
    foreach($search_fields AS $field) {
      $where .= $field . ' LIKE \'%' . cs_sql_escape($term) . '%\' OR ';
    }
    $where = substr($where, 0, -4) . ') AND ';
  }
}
$where = substr($where, 0, -5);

$data['if']['search'] = (strlen($where) > 5) ? 1 : 0;

$from = 'eventguests egt INNER JOIN {pre}_events evt ON egt.events_id = evt.events_id LEFT JOIN {pre}_users usr ON egt.users_id = usr.users_id';

$data['head']['count'] = empty($data['if']['search']) ? 0 : cs_sql_count(__FILE__, $from, $where);

$data['head']['pages'] = cs_pages('events','guestsearch',$data['head']['count'],$start,$guests_url,$sort);
$data['sort']['user'] = cs_sort('events','guestsearch',$start,$guests_url,1,$sort);
$data['sort']['name'] = cs_sort('events','guestsearch',$start,$guests_url,3,$sort);

if($data['if']['search']) {
  $select = 'egt.eventguests_name AS eventguests_name, egt.eventguests_surname AS eventguests_surname, egt.users_id AS users_id, '
          . 'egt.eventguests_id AS eventguests_id, egt.eventguests_notice AS eventguests_notice, '
          . 'egt.eventguests_phone AS eventguests_phone, egt.eventguests_mobile AS eventguests_mobile, '
          . 'usr.users_nick AS users_nick, usr.users_surname AS users_surname, usr.users_name AS users_name, '
          . 'usr.users_hidden AS users_hidden, usr.users_active AS users_active, usr.users_delete AS users_delete, '
          . 'usr.users_phone AS users_phone, usr.users_mobile AS users_mobile, '
          . 'evt.events_id AS events_id, evt.events_name AS events_name, evt.events_time AS events_time';
  $cs_eventguests = cs_sql_select(__FILE__, $from, $select, $where, $order, $start, $account['users_limit']);
  $eventguests_loop = count($cs_eventguests);

  $data['eventguests'] = array();

  for($run=0; $run<$eventguests_loop; $run++) {

    $allow = 0;
    if($cs_eventguests[$run]['users_id'] == $account['users_id'] OR $account['access_users'] > 4)
      $allow = 1;

    $hidden = explode(',',$cs_eventguests[$run]['users_hidden']);
    $content = cs_secure($cs_eventguests[$run]['users_surname']);
    if(in_array('users_surname',$hidden)) {
      $content = empty($allow) ? '' : cs_html_italic(1) . $content . cs_html_italic(0);
    }
    $surname = empty($cs_eventguests[$run]['users_surname']) ? $cs_eventguests[$run]['eventguests_surname'] : $content;
    $content = cs_secure($cs_eventguests[$run]['users_name']);
    if(in_array('users_name',$hidden)) {
      $content = empty($allow) ? '' : cs_html_italic(1) . $content . cs_html_italic(0);
    }
    $name = empty($cs_eventguests[$run]['users_name']) ? $cs_eventguests[$run]['eventguests_name'] : $content;
    if(!empty($surname) AND !empty($name))
      $data['eventguests'][$run]['name'] = $surname . ', ' . $name;
    elseif(!empty($surname) OR !empty($name))
      $data['eventguests'][$run]['name'] = $surname . $name;
    else
      $data['eventguests'][$run]['name'] = '';

    if(empty($cs_eventguests[$run]['eventguests_phone']))
      if(in_array('users_phone',$hidden))
        $cs_eventguests[$run]['eventguests_phone'] = empty($allow) ? '' : cs_html_italic(1) . $cs_eventguests[$run]['users_phone'] . cs_html_italic(0);
      elseif(!empty($allow))
        $cs_eventguests[$run]['eventguests_phone'] = $cs_eventguests[$run]['users_phone'];
    if(empty($cs_eventguests[$run]['eventguests_mobile']))
      if(in_array('users_mobile',$hidden))
        $cs_eventguests[$run]['eventguests_mobile'] = empty($allow) ? '' : cs_html_italic(1) . $cs_eventguests[$run]['users_mobile'] . cs_html_italic(0);
      elseif(!empty($allow))
        $cs_eventguests[$run]['eventguests_mobile'] = $cs_eventguests[$run]['users_mobile'];

    $data['eventguests'][$run]['events_id'] = $cs_eventguests[$run]['events_id'];
    $data['eventguests'][$run]['events_name'] = cs_secure($cs_eventguests[$run]['events_name']);
    $data['eventguests'][$run]['events_date'] = cs_date('unix',$cs_eventguests[$run]['events_time']);
    $data['eventguests'][$run]['user'] = empty($cs_eventguests[$run]['users_id']) ? '-' : cs_user($cs_eventguests[$run]['users_id'],$cs_eventguests[$run]['users_nick'], $cs_eventguests[$run]['users_active'], $cs_eventguests[$run]['users_delete']);
    $data['eventguests'][$run]['phone'] = empty($cs_eventguests[$run]['eventguests_phone']) ? '&nbsp;' : cs_html_img('symbols/' . $cs_main['img_path'] . '/16/linphone.' . $cs_main['img_ext'],16,16,'title="'. $cs_eventguests[$run]['eventguests_phone'] .'"');
    $data['eventguests'][$run]['mobile'] = empty($cs_eventguests[$run]['eventguests_mobile']) ? '&nbsp;' : cs_html_img('symbols/' . $cs_main['img_path'] . '/16/sms_protocol.' . $cs_main['img_ext'],16,16,'title="'. $cs_eventguests[$run]['eventguests_mobile'] .'"');
    $data['eventguests'][$run]['notice'] = empty($cs_eventguests[$run]['eventguests_notice']) ? '&nbsp;' : cs_icon('txt',16,$cs_lang['notice']);
    $data['eventguests'][$run]['edit'] = cs_link(cs_icon('edit',16,$cs_lang['edit']),'events','guestsadm','id=' . $cs_eventguests[$run]['eventguests_id'],0,$cs_lang['edit']);
    $data['eventguests'][$run]['remove'] = cs_link(cs_icon('editdelete',16,$cs_lang['remove']),'events','guestsdel','id=' . $cs_eventguests[$run]['eventguests_id'],0,$cs_lang['remove']);
  }
}

echo cs_subtemplate(__FILE__,$data,'events','guestsearch');