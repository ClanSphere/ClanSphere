<?PHP
// ClanSphere 2010 - www.clansphere.net
// $Id$

class zipfile
{
  var $datasec      = array();
  var $ctrl_dir     = array();
  var $eof_ctrl_dir = "\x50\x4b\x05\x06\x00\x00\x00\x00";
  var $old_offset   = 0;

  function unix2DosTime($unixtime = 0)
  {
    $timearray = ($unixtime == 0) ? getdate() : getdate($unixtime);
    if ($timearray['year'] < 1980) 
    {
      $timearray['year']  = 1980;
      $timearray['mon']   = 1;
      $timearray['mday']  = 1;
      $timearray['hours']   = 0;
      $timearray['minutes'] = 0;
      $timearray['seconds'] = 0;
    }

    return (($timearray['year'] - 1980) << 25) | ($timearray['mon'] << 21) | ($timearray['mday'] << 16) |
        ($timearray['hours'] << 11) | ($timearray['minutes'] << 5) | ($timearray['seconds'] >> 1);
  }

  function addFile($data, $name, $time = 0)
  {
    $name   = str_replace('\\', '/', $name);

    $dtime  = dechex($this->unix2DosTime($time));
    $hexdtime = '\x' . $dtime[6] . $dtime[7]
          . '\x' . $dtime[4] . $dtime[5]
          . '\x' . $dtime[2] . $dtime[3]
          . '\x' . $dtime[0] . $dtime[1];
    eval('$hexdtime = "' . $hexdtime . '";');

    $fr  = "\x50\x4b\x03\x04";
    $fr .= "\x14\x00";
    $fr .= "\x00\x00";
    $fr .= "\x08\x00";
    $fr .= $hexdtime;

    $unc_len = strlen($data);
    $crc   = crc32($data);
    $zdata   = gzcompress($data);
    $zdata   = substr(substr($zdata, 0, strlen($zdata) - 4), 2);
    $c_len   = strlen($zdata);
    $fr .= pack('V', $crc);
    $fr  .= pack('V', $c_len);
    $fr  .= pack('V', $unc_len);
    $fr  .= pack('v', strlen($name));
    $fr  .= pack('v', 0);
    $fr  .= $name;
    $fr .= $zdata;

    $this -> datasec[] = $fr;

    $cdrec  = "\x50\x4b\x01\x02";
    $cdrec .= "\x00\x00";
    $cdrec .= "\x14\x00";
    $cdrec .= "\x00\x00";
    $cdrec .= "\x08\x00";
    $cdrec .= $hexdtime;
    $cdrec .= pack('V', $crc);
    $cdrec .= pack('V', $c_len);
    $cdrec .= pack('V', $unc_len);
    $cdrec .= pack('v', strlen($name) );
    $cdrec .= pack('v', 0 );
    $cdrec .= pack('v', 0 );
    $cdrec .= pack('v', 0 );
    $cdrec .= pack('v', 0 );
    $cdrec .= pack('V', 32 );
    $cdrec .= pack('V', $this -> old_offset );
    $this -> old_offset += strlen($fr);
    $cdrec .= $name;
    $this -> ctrl_dir[] = $cdrec;
  }

  function file()
  {
    $data  = implode('', $this -> datasec);
    $ctrldir = implode('', $this -> ctrl_dir);

    return
      $data .
      $ctrldir .
      $this -> eof_ctrl_dir .
      pack('v', sizeof($this -> ctrl_dir)) .
      pack('v', sizeof($this -> ctrl_dir)) .
      pack('V', strlen($ctrldir)) .
      pack('V', strlen($data)) .
      "\x00\x00";
  }
}

if (function_exists('gzcompress'))
{
  $zip = isset($_REQUEST['zip']) ? '1' : 0;
  $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : 0;
  if($zip == '1' AND $name !== '0')
  {
    $pattern = "=^[_a-z0-9-]+(\.[_a-z0-9-]+)?$=i";
    if(!preg_match($pattern,$name))
    {
      die('Error: Invalid arguments passed');
    }
    $file = '../../uploads/gallery/pics/' . $name;
    if(file_exists($file))
    {
      $handle = fopen ($file, "rb");
      $contents = fread ($handle, filesize ($file));
      fclose ($handle);
      $zipfile = new zipfile();
      $zipfile -> addFile($contents, $name);
      $dump_buffer = $zipfile -> file();
      $zipfilename = 'images.zip';
      $handle = fopen ($zipfilename, 'wb');
      fwrite($handle,$dump_buffer);
      fclose ($handle);
      header("Content-type: application/octet-stream");
      header("Content-disposition: attachment; filename=$zipfilename");
      readfile($zipfilename);
      unlink($zipfilename);
    }
    else
    {
      echo 'Error: no file found!';
    }
  }
}