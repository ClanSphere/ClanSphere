<?PHP
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');
require_once('mods/gallery/functions.php');

$data = array();

$time = cs_time();
$voted_ip = $_SERVER['REMOTE_ADDR'];
$exp = extension_loaded('gd');
$option = cs_sql_option(__FILE__,'gallery');

$id = empty($_REQUEST['where']) ? (int) $_GET['folders_id'] : (int) $_REQUEST['where'];

$from = 'gallery';
$select = 'gallery_id, gallery_name, gallery_titel, gallery_download, gallery_description, ';
$select .= 'gallery_time, gallery_vote, gallery_count, folders_id, gallery_close';
$where = 'gallery_id = ' . $id . ' AND gallery_status = 1 AND gallery_access <=' . $account['access_gallery'];
$cs_gallery = cs_sql_select(__FILE__,$from,$select,$where);
$gallery_loop = count($cs_gallery);

if(empty($gallery_loop)) {
	$head = cs_link($cs_lang['mod'],'gallery','list') .' - ';
	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'headb');
	echo $head . $cs_lang['head_view'];;
	echo cs_html_roco(0);
	echo cs_html_table(0);
	echo cs_html_br(1);

	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'centerb');
	echo cs_html_big(1);
	echo $cs_lang['error'];
	echo cs_html_big(0);
	echo cs_html_br(1);
	echo $cs_lang['error1'];
	echo cs_html_br(2);
	echo cs_link($cs_lang['back'],'gallery','list');
	echo cs_html_roco(0);
	echo cs_html_table(0);
} else {
	$from = 'folders';
	$select = 'folders_id, folders_name, folders_picture, folders_text, sub_id';
	$where = "folders_mod = 'gallery' AND folders_id = '" . $cs_gallery['folders_id'] . "'";
	$cs_folders = cs_sql_select(__FILE__,$from,$select,$where);

	$where = "folders_mod = 'gallery'";
	$folders = cs_sql_select(__FILE__,$from,$select,$where,0,0,0);

	$from = 'voted';
	$select = 'users_id, voted_answer';
	$where = "voted_fid = '" . $id . "' AND voted_mod = 'gallery'";
	$cs_voted = cs_sql_select(__FILE__,$from,$select,$where,'',0,0);
	$voted_loop = count($cs_voted);

	$data['link']['gallery'] = cs_link($cs_lang['mod'],'gallery','list');
	$data['link']['subfolders'] = make_folders_head($folders,$cs_gallery['folders_id'],$cs_folders['folders_name']);
	$data['data']['folders_name'] = ' - ' . cs_link($cs_folders['folders_name'],'gallery','list','folders_id='.$cs_gallery['folders_id']);

	if(!empty($_POST['gallery_id'])) {
		$gallery_id = $_POST['gallery_id'];
	}

	if(isset($_POST['voted_answer'])) {
		$voted_answer = $_POST['voted_answer'];
		$voted_answer = $voted_answer + 1;
	}

	if(!empty($account['users_id'])){
		$users_id = $account['users_id'];
	} else {
		$users_id = '0';
	}

	$check_user_voted = 0;
	for ($run = 0; $run < $voted_loop; $run++) {
		if($cs_voted[$run]['users_id'] == $users_id) {
			$check_user_voted++;
		}
	}
	$data['if']['vote'] = (empty($cs_gallery['gallery_vote']) == '1') ? false : true;
    if(!empty($cs_gallery['gallery_vote']) == '1') {
	if(empty($check_user_voted) && empty($_POST['submit'])) {
		$var = cs_html_form(1,'com_view','gallery','com_view');
		$var .= cs_html_vote('where', $cs_gallery['gallery_id'], 'hidden');
		$var .= cs_html_select(1,'voted_answer');
		$levels = 0;
		while($levels < 6) {
			$cs_gallery['gallery_vote'] == $levels ? $sel = 1 : $sel = 0;
			$xx = $levels + 1;
			$var .= cs_html_option($cs_lang['vote_' . $xx],$levels,$sel);
			$levels++;
		}
		$var .= cs_html_select(0);
		$var .= cs_html_vote('submit',$cs_lang['ok'],'submit');
		$var .= cs_html_form(0);
		$data['data']['vote'] = $var;
		
	} else {
    if(isset($_POST['submit'])) {
      $votes_cells = array('voted_fid','users_id','voted_time','voted_answer','voted_ip','voted_mod');
      $votes_save = array($cs_gallery['gallery_id'],$users_id,$time,$voted_answer,$voted_ip,'gallery');
      cs_sql_insert(__FILE__,'voted',$votes_cells,$votes_save);
    }
		$voted_select = cs_sql_select(__FILE__,'voted','voted_answer',"voted_fid='" . $cs_gallery['gallery_id'] . "'",'','','0');
		$count_voted_select = count($voted_select);
		$answers = 0;
		for ($run = 0; $run < $count_voted_select; $run++) {
			$answers = $answers + $voted_select[$run]['voted_answer'];
		}
		if(!empty($count_voted_select)) {
			$xx = $answers / $count_voted_select;
		}
		$var = $cs_lang['pic_note'] . ' ' . round($xx,2);
		$var .= ' - ' . $count_voted_select . ' ' . $cs_lang['pic_stim'];
		$data['data']['vote'] = $var;
	}
	}
	if(isset($_REQUEST['rotate'])) {
		$rotate = $_REQUEST['rotate'];
	} else {
		$rotate = 0;
	}

	$rotate_left = $rotate + 90;
	$rotate_right = $rotate - 90;

	$img_size = getimagesize('uploads/gallery/pics/' . $cs_gallery['gallery_name']);
	//[0] = width; [1] = height
	$img_w_h = $img_size[0] / $img_size[1];
  $normal_size = $pic_size = $img_size[0] > $option['max_width'] ? $option['max_width'] : $img_size[0];
  $pic_size = empty($_GET['size']) ? $normal_size : (int) $_GET['size'];

	$size_minus = round($pic_size / 1.1,0);
	$size_plus = round($pic_size * 1.1,0);

	if($exp) {
		$icon_left = cs_icon('left',22,$cs_lang['rotate_left']);
		$data['link']['picture_rotate_left'] = cs_link($icon_left,'gallery','com_view','where=' . $id . '&amp;size=' . $pic_size . '&amp;rotate=' . $rotate_left);
	}
	$viewmag1 = cs_icon('viewmag-',22,$cs_lang['viewmag_-']);
	$data['link']['picture_zoom_smaller'] = cs_link($viewmag1,'gallery','com_view','where=' . $id . '&amp;size=' . $size_minus);
	$window_fullscreen = cs_icon('viewmag1',22,$cs_lang['viewmag']);
	$data['link']['picture_zoom_normally'] = cs_link($window_fullscreen,'gallery','com_view','where=' . $id . '&amp;size='.$normal_size);
	$viewmag2 = cs_icon('viewmag+',22,$cs_lang['viewmag_+']);
	$data['link']['picture_zoom_bigger'] = cs_link($viewmag2,'gallery','com_view','where=' . $id . '&amp;size=' . $size_plus);
	if($exp) {
		$icon_right = cs_icon('right',22,$cs_lang['rotate_right']);
		$data['link']['picture_rotate_right'] = cs_link($icon_right,'gallery','com_view','where=' . $id . '&amp;size=' . $pic_size . '&amp;rotate=' . $rotate_right);
	}
	$print = cs_icon('mail_new2',22,$cs_lang['ecard']);
	$data['link']['ecard'] = cs_link($print,'gallery','ecard','id=' . $cs_gallery['gallery_id']);
	$temp_download = explode("|--@--|", $cs_gallery['gallery_download']);
	if(!empty($temp_download[0])) {
		$print = cs_icon('thumbnail',22,$cs_lang['down_pic']);
		if(empty($cs_main['mod_rewrite'])) {
		  $data['link']['download_picture'] = cs_html_link('mods/gallery/image.php?down=1&amp;pic=' . $cs_gallery['gallery_id'],$print,0);
		}
		else {
		  $host = 'http://' . $_SERVER['HTTP_HOST'];
		  $host .= str_replace('index.php','',$_SERVER['PHP_SELF']);
		  $host .= 'mods/gallery/image.php?down=1&amp;pic=' . $cs_gallery['gallery_id'];
		  
		  $data['link']['download_picture'] = cs_html_link($host,$print,0);
		}
		
		if(!empty($temp_download[1])) {
			$print = cs_icon('zip_mount',22,$cs_lang['down_zip']);
			if(empty($cs_main['mod_rewrite'])) {
			  $data['link']['download_zip'] = cs_html_link('mods/gallery/download.php?zip=1&amp;name=' . $cs_gallery['gallery_name'],$print,0);
			}
			else {
			  $host = 'http://' . $_SERVER['HTTP_HOST'];
		      $host .= str_replace('index.php','',$_SERVER['PHP_SELF']);
		      $host .= 'mods/gallery/download.php?zip=1&amp;name=' . $cs_gallery['gallery_name'];
		  
		      $data['link']['download_zip'] = cs_html_link($host,$print,0);
			}
		}
		else {
		  $print = cs_icon('zip_mount',22,$cs_lang['down_zip']);
		  if(empty($cs_main['mod_rewrite'])) {
		    $data['link']['download_zip'] = cs_html_link('mods/gallery/download.php?zip=1&amp;name=' . $cs_gallery['gallery_name'],$print,0);
		  }
		  else {
		    $host = 'http://' . $_SERVER['HTTP_HOST'];
		    $host .= str_replace('index.php','',$_SERVER['PHP_SELF']);
		    $host .= 'mods/gallery/download.php?zip=1&amp;name=' . $cs_gallery['gallery_name'];
			
			$data['link']['download_zip'] = cs_html_link($host,$print,0);
		  }
		}
	} else {
		$data['link']['download_picture'] = '';
		$data['link']['download_zip'] = '';
	}
	$print = cs_icon('fileprint',22,$cs_lang['print']);
	$data['link']['print'] = cs_link($print,'gallery','print','pic=' . $cs_gallery['gallery_id']);

	if($rotate == 0)	{
		$more = '';
	} else {
		$more = "&rotate=" . $rotate;
	}
	$cs_lap = cs_html_img("mods/gallery/image.php?pic=" . $cs_gallery['gallery_id'] . '&amp;size=' . $pic_size . $more);
	if($option['lightbox'] == '0' ) {
	  if(empty($cs_main['mod_rewrite'])) {
	    $data['data']['picture'] = cs_html_link('mods/gallery/image.php?pic=' . $cs_gallery['gallery_id'],$cs_lap);
	  }
	  else {
	    $host = 'http://' . $_SERVER['HTTP_HOST'];
		$host .= str_replace('index.php','',$_SERVER['PHP_SELF']);
		$host .= 'mods/gallery/image.php?pic=' . $cs_gallery['gallery_id'];
			
		$data['data']['picture'] = cs_html_link($host,$cs_lap);
	  }
	}
	else {
	  if(empty($cs_main['mod_rewrite'])) {
	    $data['data']['picture'] = cs_html_link('mods/gallery/image.php?pic=' . $cs_gallery['gallery_id'],$cs_lap,0,0,0,'rel="lightbox"');
	  }
	  else {
	    $host = 'http://' . $_SERVER['HTTP_HOST'];
		$host .= str_replace('index.php','',$_SERVER['PHP_SELF']);
		$host .= 'mods/gallery/image.php?pic=' . $cs_gallery['gallery_id'];
		
		$data['data']['picture'] = cs_html_link($host,$cs_lap,0,0,0,'rel="lightbox"');
	  }
	}
	$data['data']['titel'] = $cs_gallery['gallery_titel'];
	$data['data']['date'] = cs_date('unix',$cs_gallery['gallery_time'],1);
	$data['data']['description'] = cs_secure($cs_gallery['gallery_description'],1,1);
	$data['data']['pic_size'] = $img_size[0] . 'x' . $img_size[1] . ' Pixel';
	$size = filesize('uploads/gallery/pics/' . $cs_gallery['gallery_name']);
	$data['data']['filesize'] = cs_filesize($size);
	$data['data']['count'] = $cs_gallery['gallery_count'] + 1;

  $more = 'folders_id='.$cs_gallery['folders_id'].'&amp;where=';

  $cond = 'folders_id = \'' . $cs_gallery['folders_id'] . '\' AND gallery_id < \'' . $cs_gallery['gallery_id'] . '\'';
  $before = cs_sql_select(__FILE__,'gallery','gallery_id',$cond,'gallery_id DESC');
  $data['link']['picture_backward'] = empty($before) ? '' : cs_link(cs_icon('back',22),'gallery','com_view',$more.$before['gallery_id']);

  $cond = 'folders_id = \'' . $cs_gallery['folders_id'] . '\' AND gallery_id > \'' . $cs_gallery['gallery_id'] . '\'';
  $next = cs_sql_select(__FILE__,'gallery','gallery_id',$cond,'gallery_id ASC');
  $data['link']['picture_forward'] = empty($next) ? '' : cs_link(cs_icon('forward',22),'gallery','com_view',$more.$next['gallery_id']);

	echo cs_subtemplate(__FILE__,$data,'gallery','com_view');

	$where3 = "comments_mod = 'gallery' AND comments_fid = \"" . $id . "\"";
	$count_com = cs_sql_count(__FILE__,'comments',$where3);
	include_once('mods/comments/functions.php');

	$data['comments']['view'] = '';
	$data['comments']['create'] = '';
	if(!empty($count_com)) {
		echo cs_html_br(1);
		echo cs_comments_view($id,'gallery','com_view',$count_com);
	}
	echo cs_comments_add($id,'gallery',$cs_gallery['gallery_close']);
}
?>