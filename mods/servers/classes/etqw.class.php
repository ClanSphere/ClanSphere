<?php
$cs_lang = cs_translate('servers');
// Enemy Territory Quake Wars
/*
 * Copyright (c) 2004-2006, woah-projekt.de
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 * * Redistributions of source code must retain the above copyright
 *   notice, this list of conditions and the following disclaimer.
 * * Redistributions in binary form must reproduce the above copyright
 *   notice, this list of conditions and the following disclaimer
 *   in the documentation and/or other materials provided with the
 *   distribution.
 * * Neither the name of the phgstats project (woah-projekt.de)
 *   nor the names of its contributors may be used to endorse or
 *   promote products derived from this software without specific
 *   prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */
class etqw
{
	var $maxlen   = 2048;
	var $write    = false;
	var $s_info   = false;
	var $g_info   = false;
	var $c_info   = false;
	var $p_info   = false;
	var $pl_count = false;

	function getvalue($srv_value, $srv_data)
	{
		// search the value of selected rule and return it
		$srv_value = array_search ($srv_value, $srv_data);

		if ($srv_value === false)
		{
			return false;
		}
		else
		{
			$srv_value = $srv_data[$srv_value+1];

			return $srv_value;
		}
	}

	function splitdata()
	{
		// get rules from stream and write to g_info
		$this->c_info = explode ("\x00\x00\x00", $this->s_info, 2);
		$this->g_info = explode ("\x00", $this->c_info[0]);
		 
		$end = strlen($this->c_info[1]) - 8;
		$this->p_info = substr($this->c_info[1], "\x00\x00\x00", $end );

		// get players from stream and write to p_info
		$index_old = 0;
		$index_new = 0;

		foreach ($this->c_info as $value)
		{
			if ($index_old >= 2)
			{
				$this->p_info[$index_new] = $value;
				$index_new++;
			}
			$index_old++;
		}
	}

	function microtime_float()
	{
		list($usec, $sec) = explode(" ", microtime());

		return ((float)$usec + (float)$sec);
	}

	function getstream($host, $port, $queryport)
	{
		$this->write = chr (0xff) . chr (0xff) . "getInfo" . chr (0x00);

		// get the infostream from server
		$socket = fsockopen('udp://'. $host, $port, $errno, $errstr, 30);

		if ($socket === false)
		{
			echo "Error: $errno - $errstr<br>\n";
		}
		else
		{
			socket_set_timeout($socket, 1);

			$time_begin = $this->microtime_float();

			fwrite($socket, $this->write);

			$this->s_info = fread($socket, $this->maxlen);

			$time_end = $this->microtime_float();
		}
		fclose($socket);

		// response time
		$this->response = $time_end - $time_begin;
		$this->response = ($this->response * 1000);
		$this->response = (int)$this->response;

		if ($this->s_info)
		{
			// sort the infostring
			$this->splitdata();
			 
			return true;
		}
		else
		{
			return false;
		}
	}

	function check_color($text, $switch)
	{
		$clr = array ( // colors
        "\"#000000\"", "\"#DA0120\"", "\"#00B906\"", "\"#E8FF19\"", //  1
        "\"#170BDB\"", "\"#23C2C6\"", "\"#E201DB\"", "\"#FFFFFF\"", //  2
        "\"#CA7C27\"", "\"#757575\"", "\"#EB9F53\"", "\"#106F59\"", //  3
        "\"#5A134F\"", "\"#035AFF\"", "\"#681EA7\"", "\"#5097C1\"", //  4
        "\"#BEDAC4\"", "\"#024D2C\"", "\"#7D081B\"", "\"#90243E\"", //  5
        "\"#743313\"", "\"#A7905E\"", "\"#555C26\"", "\"#AEAC97\"", //  6
        "\"#C0BF7F\"", "\"#000000\"", "\"#DA0120\"", "\"#00B906\"", //  7
        "\"#E8FF19\"", "\"#170BDB\"", "\"#23C2C6\"", "\"#E201DB\"", //  8
        "\"#FFFFFF\"", "\"#CA7C27\"", "\"#757575\"", "\"#CC8034\"", //  9
        "\"#DBDF70\"", "\"#BBBBBB\"", "\"#747228\"", "\"#993400\"", // 10
        "\"#670504\"", "\"#623307\""                                // 11
		);

		if ($switch == 1)
		{
			// colored playerstring
			$search  = array (
      "/\^c\d\d\d/", "/\^i[a-z]\d\d/",           //  0
      "/\^0/", "/\^1/", "/\^2/", "/\^3/",        //  1
      "/\^4/", "/\^5/", "/\^6/", "/\^7/",        //  2
      "/\^8/", "/\^9/", "/\^a/", "/\^b/",        //  3
      "/\^c/", "/\^d/", "/\^e/", "/\^f/",        //  4
      "/\^g/", "/\^h/", "/\^i/", "/\^j/",        //  5
      "/\^k/", "/\^l/", "/\^m/", "/\^n/",        //  6
      "/\^o/", "/\^p/", "/\^q/", "/\^r/",        //  7
      "/\^s/", "/\^t/", "/\^u/", "/\^v/",        //  8
      "/\^w/", "/\^x/", "/\^y/", "/\^z/",        //  9
      "/\^\//", "/\^\*/", "/\^\-/", "/\^\+/",    // 10
      "/\^\?/", "/\^\@/", "/\^</", "/\^>/",      // 11
      "/\^\&/", "/\^\)/", "/\^\(/", "/\^[A-Z]/", // 12
      "/\^\_/", "/\^!/", "/\^#/",                // 13
      "/&</", "/^(.*?)<\/font>/"                 // 14
			);

			$replace = array (
      "", "",                                             //  0
      "&<font color=$clr[0]>", "&<font color=$clr[1]>",   //  1
      "&<font color=$clr[2]>", "&<font color=$clr[3]>",   //  2
      "&<font color=$clr[4]>", "&<font color=$clr[5]>",   //  3
      "&<font color=$clr[6]>", "&<font color=$clr[7]>",   //  4
      "&<font color=$clr[8]>", "&<font color=$clr[9]>",   //  5
      "&<font color=$clr[10]>", "&<font color=$clr[11]>", //  6
      "&<font color=$clr[12]>", "&<font color=$clr[13]>", //  7
      "&<font color=$clr[14]>", "&<font color=$clr[15]>", //  8
      "&<font color=$clr[16]>", "&<font color=$clr[17]>", //  9
      "&<font color=$clr[18]>", "&<font color=$clr[19]>", // 10
      "&<font color=$clr[20]>", "&<font color=$clr[21]>", // 11
      "&<font color=$clr[22]>", "&<font color=$clr[23]>", // 12
      "&<font color=$clr[24]>", "&<font color=$clr[25]>", // 13
      "&<font color=$clr[26]>", "&<font color=$clr[27]>", // 14
      "&<font color=$clr[28]>", "&<font color=$clr[29]>", // 15
      "&<font color=$clr[30]>", "&<font color=$clr[31]>", // 16
      "&<font color=$clr[32]>", "&<font color=$clr[33]>", // 17
      "&<font color=$clr[34]>", "&<font color=$clr[35]>", // 18
      "&<font color=$clr[36]>", "&<font color=$clr[37]>", // 19
      "&<font color=$clr[38]>", "&<font color=$clr[39]>", // 20
      "&<font color=$clr[40]>", "&<font color=$clr[41]>", // 21
      "", "", "", "", "", "", "", "",                     // 22
      "", "</font><", "\$1"                               // 23
			);

			$ctext = preg_replace($search, $replace, $text);

			if ($ctext != $text)
			{
				$ctext = preg_replace("/$/", "</font>", $ctext);
			}

			return $ctext;
		}
		elseif ($switch == 2)
		{
			// colored numbers
			if ($text <= 39)
			{
				$ctext = "<font color=$clr[7]>$text</font>";
			}
			elseif ($text <= 69)
			{
				$ctext = "<font color=$clr[5]>$text</font>";
			}
			elseif ($text <= 129)
			{
				$ctext = "<font color=$clr[8]>$text</font>";
			}
			elseif ($text <= 399)
			{
				$ctext = "<font color=$clr[9]>$text</font>";
			}
			else
			{
				$ctext = "<font color=$clr[1]>$text</font>";
			}

			return $ctext;

		}
	}

	function getrules($phgdir)
	{
		$srv_rules['sets'] = false;

		// response time
		$srv_rules['response'] = $this->response . ' ms';

		// etqw setting pics
		$sets['pb']      = cs_html_img($phgdir . 'privileges/pb.gif',0,0,0,'PB');
		$sets['pass']    =   cs_html_img($phgdir . 'privileges/pass.gif',0,0,0,'Protected');


		// get the info strings from server info stream
		$srv_rules['hostname']       = $this->check_color($this->getvalue('si_name', $this->g_info),1);
		$srv_rules['mapname']        = $this->getvalue('si_map', $this->g_info);
		$srv_rules['maxplayers']     = $this->getvalue('si_maxPlayers', $this->g_info);
		$srv_rules['version']        = $this->getvalue('si_version', $this->g_info);
		$srv_rules['mod']            = $this->getvalue('fs_game', $this->g_info);
		if ($srv_rules['maxplayers'] === false OR $srv_rules['maxplayers'] === NULL)
		{
			$srv_rules['maxplayers'] = $this->getvalue('si_maxplayers', $this->g_info);
		}
		$srv_rules['gametype']       = $this->getvalue('si_gameType', $this->g_info);
		$srv_rules['needpass']       = $this->getvalue('si_usepass', $this->g_info);
		$srv_rules['punkbuster']     = $this->getvalue('sv_punkbuster', $this->g_info);

		// get version information
		$version_array = explode(' ', $srv_rules['version']);
		$srv_rules['version'] = $version_array[1] . ' ' . $version_array[2];
		$srv_rules['gamename'] = 'Enemy Territory Quake Wars (' . $srv_rules['mod'] . ')<br>' . $srv_rules['version'];

		// path to map picture and default info picture
		$srv_rules['map_path'] = 'maps/etqw';
		$srv_rules['map_default'] = 'default.jpg';

		// get the connected player
		$srv_rules['nowplayers'] = $this->countplayers();

		// etqw needpass pic
		if ($srv_rules['needpass'] == 1)
		{
			$srv_rules['sets'] .= $sets['pass'];
		}
		// etqw pubkbuster pic
		if ($srv_rules['punkbuster'] == 1)
		{
			$srv_rules['sets'] .= $sets['pb'];
		}

		if ($srv_rules['sets'] === false)
		{
			$srv_rules['sets'] = '-';
		}
		// return all server rules
		return $srv_rules;
	}

	function countplayers()
	{
		$this->getplayers();
		return $this->pl_count;
	}

 function getplayers_head() {
    global $cs_lang;
    $head[]['name'] = $cs_lang['id'];
    $head[]['name'] = $cs_lang['name'];
    $head[]['name'] = $cs_lang['clan'];
    $head[]['name'] = $cs_lang['rate'];
    $head[]['name'] = $cs_lang['ping'];
    return $head;
  }
		
	function getplayers()
	{

		$pl_string = $this->p_info;

		// search player datas
		$run = 0;
		for ($count_players = 1; strlen ($pl_string) > 5; $count_players++)
		{
			unset ($name,$clan,$rate,$ping);

			$pl_string = substr($pl_string,1);

			$ping_array = unpack ("S", substr($pl_string,0,2));
			$pl_string = substr($pl_string,2);
			$ping = $ping_array[1];

			$rate_array = unpack ("L", substr($pl_string,0,4));
			$pl_string = substr($pl_string,4);
			$rate = $rate_array[1];

			if (substr($pl_string,0,1) == "\x00")
			{
				$name = '';
				$pl_string = substr($pl_string,1);
			}
			else
			{
				$nullpos = strpos($pl_string,"\x00");

				if ($nullpos === false)
				{
					$name = '';
				}
				else
				{
					$name = substr($pl_string,0,$nullpos);
					$pl_string = substr($pl_string,$nullpos + 1);
				}
			}

			if (substr($pl_string,0,1) == "\x00")
			{
				$clan = '';
				$pl_string = substr($pl_string,1);
			}
			else
			{
				$nullpos = strpos($pl_string,"\x00");
				if ($nullpos === false)
				{
					$clan = '';
				}
				else
				{
					$clan = substr($pl_string,0,$nullpos);
					$pl_string = substr($pl_string,$nullpos + 1);
				}
			}
			$name = htmlentities($name);

			$tdata[$run][0] = '<td class="centerb">' . $count_players . '</td>';
      $tdata[$run][0] .= '<td class="centerb">' . $this->check_color($name,1) . '</td>';
      $tdata[$run][0] .= '<td class="centerb">' . $this->check_color($clan,1) . '</td>';
      $tdata[$run][0] .= '<td class="centerb">' . $rate . '</td>';
      $tdata[$run][0] .= '<td class="centerb">' . $this->check_color($ping,2) . '</td>';
      $run++;
		}
		$this->pl_count = $count_players - 1;

		if ($this->pl_count == 0)
		{
      return array();
		}

		return $tdata;
	}
}
?>
