<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$data = array();
$cs_option = cs_sql_option(__FILE__,'events');
$zero = date('m', mktime(0, 0, 0, cs_datereal('n'), cs_datereal('d'), cs_datereal('Y')));
$zero .= '-' . date('d', mktime(0, 0, 0, cs_datereal('n'), cs_datereal('d'), cs_datereal('Y')));
$like = "users_age LIKE '%-" . $zero . "' AND users_active = '1'";
$birthdays = cs_sql_select(__FILE__,'users','users_id,users_nick,users_country,users_age,users_active,users_delete',$like,0,0,$cs_option['max_navbirthday']);

$unix = cs_datereal('U');
settype($unix,'integer');
if(!empty($_POST['date_year']) AND !empty($_POST['date_month']) AND !empty($_POST['date_day'])) {
  $unix = mktime(0, 0, 0, $_POST['date_month'], $_POST['date_day'], $_POST['date_year']);
}

if(is_array($birthdays)) {
  foreach($birthdays AS $key => $value) {
    $url = 'symbols/countries/' . $value['users_country'] . '.png';
    $data['data']['country'] = cs_html_img($url,11,16) . ' ';
    $data['data']['nick'] = cs_user($value['users_id'],$value['users_nick'],$value['users_active'],$value['users_delete']);
    $birth = explode ('-', $value['users_age']);
    $age = cs_datereal('Y',$unix) - $birth[0];
    if(cs_datereal('m',$unix) < $birth[1] OR cs_datereal('d',$unix) < $birth[2] AND cs_datereal('m',$unix) == $birth[1]) {
      $age--;
    }
    $data['data']['age'] = ' (' . $age . ')';
    echo cs_subtemplate(__FILE__,$data,'events','nav_birthday');
  }
}