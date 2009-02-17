<?php
// DZCP SQL Connect
$dzcp_connect = mysql_connect($dzcp_db['place'], $dzcp_db['user'], $dzcp_db['pwd']);
$dzcp_database = mysql_select_db($dzcp_db['name']);

#$count_query = "SELECT * FROM " . $dzcp_db['prf'] . "counter";
#$count_data = mysql_query($count_query, $dzcp_connect);

#$year = array('0' => '2000', '1' => '2001','2' => '2002','3' => '2003','4' =>'2004', '5' => '2005','6' => '2006','7' => '2007','8' => '2008');
$year = array('0' => '2008');
$month = 12;
#$month = 1;

$run_count = 0;
#while ($count_result = mysql_fetch_assoc($count_data)) { $dzcp_count[$run_count] = $count_result; $run_count++; }

$data = array();
// GET Counter 
for($run_year=0; $run_year<count($year); $run_year++) {
  // GET SQL
  $where = "'%." . $year[$run_year] . "'";
  $new_query = "SELECT count(visitors) FROM " . $dzcp_db['prf'] . "counter WHERE today LIKE " . $where;
  $new_data = mysql_query($new_query, $dzcp_connect);
  $new_count = 0;
  while ($new_result = mysql_fetch_array($new_data)) { $dzcp_new[$new_count] = $new_result; $new_count++; }
  print_R($dzcp_new);
  for($run=0; $run<count($dzcp_new); $run++) {
    $time = explode(".", $dzcp_new[$run]['today']);
    for($month=1; $month<13; $month++) {
    if($time[1] == $month) {
      $data[$run_year][$year[$run_year]][$month] = $data[$run_year][$year[$run_year]][$month] + $dzcp_new[$run]['visitors'];
    } else {
      $data[$run_year][$year[$run_year]][$month] = '';
    }
  }  
  }
}
echo '<pre>';
print_R($data);
echo '</pre>';








mysql_close();
?>
