<?php

class Servers {

	static private $instance = null;
	private $_gameQ = null;

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
		if($server['servers_game'] == 'ut3') {
			$this->_gameQ->addServer($iId, array($server['servers_class'], $server['servers_ip'], $server['servers_query']));
		}
		else {
			$this->_gameQ->addServer($iId, array($server['servers_class'], $server['servers_ip'], $server['servers_port']));
		}
	}
	
	public function normalize($data) {
		if($data['servername']) { $data['hostname'] = $data['servername']; }
		if($data['maxplayers']) { $data['max_players'] = $data['maxplayers']; }
		return $data;
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
		if($aServer['servers_class'] == 'ts2') {
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