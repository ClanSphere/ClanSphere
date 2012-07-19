<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_abcode_pb_url($matches) {
  
  $cs_get = cs_get('id,where');
  
  if(!empty($cs_get['id'])) {
    $matches[3] = empty($cs_get['id']) ? 0 : $cs_get['id'];
  }  
  if(!empty($cs_get['where'])) {
    $matches[3] = empty($cs_get['where']) ? 0 : $cs_get['where'];
  }
  if(empty($matches[2])) {
    $matches[2] = $matches[1];
  }
  
  return cs_link($matches[2],'articles','view','id=' .$matches[3]. '&page=' .$matches[1]);
  
}

function articles_secure($replace,$abcode = 0) {

    $replace = preg_replace_callback("=\[pb_url\=(.*?)\](.*?)\[/pb_url\]=si","cs_abcode_pb_url",$replace);
  
     return $replace;
}