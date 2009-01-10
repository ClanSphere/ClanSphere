<?php
// Delete old_id
$sql_query = "ALTER TABLE " . $csp_db['prf'] . "categories DROP old_id";
$result = mysql_query($sql_query, $csp_connect);
$sql_query = "ALTER TABLE " . $csp_db['prf'] . "categories DROP old_id";
$result = mysql_query($sql_query, $csp_connect);
$sql_query = "ALTER TABLE " . $csp_db['prf'] . "board DROP old_id";
$result = mysql_query($sql_query, $csp_connect);
$sql_query = "ALTER TABLE " . $csp_db['prf'] . "threads DROP old_id";
$result = mysql_query($sql_query, $csp_connect);

?>