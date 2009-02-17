<?php
class MySQL {
  private $connection = NULL;
  private $result = NULL;
 
  public function connect($host, $user, $pass, $database) {
    $this->connection = mysql_connect($host,$user,$pass,TRUE);
  mysql_select_db($database, $this->connection);
  }
 
  public function disconnect() {
    if (is_resource($this->connection)) {
      mysql_close($this->connection);
    }
  }
 
  public function query($query) {
    if (is_resource($this->connection)) {
      if (is_resource($this->result)) {
        mysql_free_result($this->result);
      }

      $this->result = mysql_query($query, $this->connection);
    }
  }
 
  public function fetchRow() {
    if (is_resource($this->result)) {
      $row = mysql_fetch_assoc($this->result);
 
      if (is_array($row)) {
        return $row;
      } else {
        return FALSE;
      }
    }
  }
}
?>