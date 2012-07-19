<?php

class Servers {

  static private $instance = null;
  private $_gameQ = null;
  private $_gamesList;

  /**
   *
   */
  private function __construct() {
    include_once 'mods/servers/gameq/GameQ.php';
    if($this->_gameQ == null) {
      $this->_gameQ = new GameQ();
    }
    $this->_gameQ->setOption('timeout', 200);
    $this->_gameQ->setFilter('stripcolor');
    $this->_gamesList = parse_ini_file('gameq/games.ini', true);
  }

  /**
   *
   */
  static public function __getInstance() {
    if(self::$instance == null) {
      self::$instance = new self;
    }
    return self::$instance;
  }

  /**
   *
   * @param unknown_type $iId
   * @param unknown_type $server
   */
  public function addServer($iId, $server) {
    if(isset($this->_gamesList[$server['servers_class']]['prot'])) {
      $server['servers_class'] = $this->_gamesList[$server['servers_class']]['prot'];
    }
    $this->_gameQ->addServer($iId, array($server['servers_class'], $server['servers_ip'], $server['servers_query']));
  }

  /**
   *
   * Enter description here ...
   * @param String $gamename
   */
  public function getGameName($gamename) {
    if(isset($this->_gamesList[$gamename])) {
      return $this->_gamesList[$gamename]['name'];
    }
    return $gamename;
  }

  /**
   *
   * Enter description here ...
   * @param array $server
   */
  public function getGameVersion($server) {
    if(isset($server['version'])) {
      return $server['version'];
    }
    if(isset($server['shortversion'])) {
      return $server['shortversion'];
    }
    if(isset($server['ServerVersion'])) {
      return $server['ServerVersion'];
    }
    if(isset($server['gamever'])) {
      return $server['gamever'];
    }
    if(isset($server['EngineVersion'])) {
      return $server['EngineVersion'];
    }
    return "";
  }

  /**
   *
   * Enter description here ...
   */
  public function getServerQueryList() {
    return $this->_gamesList;
  }

  /**
   *
   * Enter description here ...
   * @param unknown_type $data
   */
  public function normalize($data, $server_db) {
    if(isset($data['servername']) && !empty($data['servername'])) {
      $data['hostname'] = $data['servername'];
    }
    if(empty($data['hostname'])) {
      $data['hostname'] = $server_db['servers_name'];
    }
    if(isset($data['maxplayers'])) {
      $data['max_players'] = $data['maxplayers'];
    }

    if(!empty($data['players'])) {
      for($a=0; $a<count($data['players']); $a++) {
        $data['players'][$a]['time'] = $this->normalizePlayerTime($data['players'][$a]['time']);
      }
    }
    return $data;
  }

  /**
   *
   * Enter description here ...
   * @param unknown_type $player
   */
  private function normalizePlayerTime($time) {
    # Determine the number of seconds
    $totalSeconds = intval($time);

  # Calculate number of seconds
  $seconds = $totalSeconds % 60;
  $totalSeconds = $totalSeconds / 60;

  # Calculate number of minutes
  $minutes = $totalSeconds % 60;
  $totalSeconds = $totalSeconds / 60;

  # Calculate number of hours
  $hours = $totalSeconds % 60;

  return sprintf("%d Std. %d Min. %d Sek.", $hours, $minutes, $seconds);
  }

  /**
   *
   */
  public function requestData() {
    return $this->_gameQ->requestData();
  }

  /**
   *
   * @param unknown_type $aServer
   * @param unknown_type $data
   */
  public function setProtocolLink($aServer, $data) {
    $data['servers_link'] = 'hlsw://'.$aServer['servers_ip'].':'.$aServer['servers_port'];
    if($aServer['servers_class'] == 'source') {
      $data['servers_link'] = 'steam://connect/'.$aServer['servers_ip'].':'.$aServer['servers_port'];
    }
    elseif($aServer['servers_class'] == 'ts2') {
      $data['servers_link'] = 'teamspeak://'.$aServer['servers_ip'].':'.$aServer['servers_port'];
    }
    elseif($aServer['servers_class'] == 'ts3') {
      $data['servers_link'] = 'ts3server://'.$aServer['servers_ip'].':'.$aServer['servers_port'];
      $data['num_players'] = 0;
      for($a=0; $a<count($server[$run]['teams']); $a++) {
        $data['num_players'] = $data['num_players'] + $aServer['teams'][$a]['total_clients'];
      }
    }
    elseif($aServer['servers_class'] == 'tmnf') {
      $data['servers_link'] = 'tmtp://#join='.urlencode($data['hostname']);
    }
    return $data;
  }
}