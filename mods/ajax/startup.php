<?php

if(isset($_SESSION['ajaxuploads']))
{
	foreach($_SESSION['ajaxuploads'] AS $fied_name => $new_name) {
		$path = '/uploads/cache/' . $new_name;
		
		if(mktime() - filemtime($path) > 60*15) { //15 minuten
			unlink($path); continue;
		}
		
		$_FILES[$field_name] = array(
			'tmp_name' 	=> $path,
			'name'			=> $new_name,
			'size'			=> filesize($path),
			'type'			=> mime_content_type($path)
		);
	}
}