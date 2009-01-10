<?php

$cs_lang = cs_translate('servers');

empty($_REQUEST['start']) ? $start = 0 : $start = $_REQUEST['start']; 
$cs_sort[1] = 'servers_name DESC';
$cs_sort[2] = 'servers_name ASC';
empty($_REQUEST['sort']) ? $sort = 2 : $sort = $_REQUEST['sort'];
$order = $cs_sort[$sort];
$server_count = cs_sql_count(__FILE__,'servers');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,3);
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_manage'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo cs_icon('editpaste') . cs_link($cs_lang['new_serv'],'servers','create');
echo cs_html_roco(2,'leftb');
echo cs_icon('contents') . $cs_lang['all'] . $server_count;
echo cs_html_roco(3,'rightb');
echo cs_pages('servers','manage',$server_count,$start,0,$sort);
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb',0,3);
echo cs_html_link('http://www.clansphere.net/index/files/view/where/9',$cs_lang['mapsdl'],1);
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

echo cs_getmsg();

if (@fsockopen("udp://127.0.0.1", 1)) { } else {
  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'leftb');
  echo $cs_lang['fsockoff'];
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_br(1);
  }


$cs_server = cs_sql_select(__FILE__,'servers','*',0,$order,$start,$account['users_limit']);
$server_loop = count($cs_server);
echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['id'];
echo cs_html_roco(2,'headb');
echo cs_sort('servers','manage',$start,0,1,$sort);
echo $cs_lang['headline'];
echo cs_html_roco(3,'headb');
echo $cs_lang['gametype'];
echo cs_html_roco(4,'headb');
echo $cs_lang['gameclass'];
echo cs_html_roco(5,'headb',0,2);
echo $cs_lang['options'];
echo cs_html_roco(0);

for($run=0; $run<$server_loop; $run++) {

  echo cs_html_roco(1,'leftc');
  echo $cs_server[$run]['servers_id'];
  echo cs_html_roco(2,'leftc');
  echo cs_secure($cs_server[$run]['servers_name']);
  echo cs_html_roco(3,'leftc');
  $where = "games_id = '" . cs_secure($cs_server[$run]['games_id']) . "'";
  $cs_game = cs_sql_select(__FILE__,'games','games_id, games_name',$where,0,0,1);
  echo $cs_game['games_name'];
  echo cs_html_roco(4,'leftc');
  echo cs_secure($cs_server[$run]['servers_class']);
  echo cs_html_roco(5,'leftc');
  $img_edit = cs_icon('edit');
  echo cs_link($img_edit,'servers','edit','id=' . $cs_server[$run]['servers_id'],0,$cs_lang['edit']);
  echo cs_html_roco(6,'leftc');
  $img_del = cs_icon('editdelete');
  echo cs_link($img_del,'servers','remove','id=' . $cs_server[$run]['servers_id'],0,$cs_lang['remove']);
  echo cs_html_roco(0);
}
echo cs_html_table(0);
?>
