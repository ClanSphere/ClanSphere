<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');
$cs_post = cs_post('where,folders_id');
$cs_get = cs_get('where,folders_id');
$data = array();

$gid = empty($cs_get['where']) ? 0 : $cs_get['where'];
if (!empty($cs_post['where']))  $gid = $cs_post['where'];
$folder_id = empty($cs_get['folders_id']) ? 0 : $cs_get['folders_id'];
if (!empty($cs_post['folders_id']))  $folder_id = $cs_post['folders_id'];

require_once('mods/gallery/functions.php');

$time = cs_time();
$voted_ip = cs_getip();
$exp = extension_loaded('gd');
$option = cs_sql_option(__FILE__,'gallery');

$id = empty($gid) ? $folder_id : $gid;

$select = 'gallery_id, gallery_name, gallery_titel, gallery_description, ';
$select .= 'gallery_time, gallery_vote, gallery_count, folders_id, users_id';
$where = 'gallery_id = ' . $id . ' AND gallery_status = 1 AND gallery_access <=' . $account['access_gallery'];
$cs_gallery = cs_sql_select(__FILE__,'gallery',$select,$where);
$gallery_loop = count($cs_gallery);


if(empty($gallery_loop)) {

    $data['head']['error'] = cs_link($cs_lang['mod_name'],'gallery','list') .' - ' . $cs_lang['head_view'];

    echo cs_subtemplate(__FILE__,$data,'gallery','error');

} else {

    $select = 'folders_id, folders_name, folders_picture, folders_text, sub_id, folders_advanced';
    $where = "folders_mod = 'gallery' AND folders_id = '" . $cs_gallery['folders_id'] . "'";
    $cs_folders = cs_sql_select(__FILE__,'folders',$select,$where);

    $advanced = empty($cs_folders['folders_advanced']) ? '0,0,0,0' : $cs_folders['folders_advanced'];
    $advanced = explode(",",$advanced);

    $where = "folders_mod = 'gallery'";
    $folders = cs_sql_select(__FILE__,'folders',$select,$where,0,0,0);

    $where = "voted_fid = '" . $id . "' AND voted_mod = 'gallery'";
    $cs_voted = cs_sql_select(__FILE__,'voted','users_id, voted_answer',$where,'',0,0);
    $voted_loop = count($cs_voted);

    $data['link']['subfolders'] = make_folders_head($folders,$cs_gallery['folders_id'],$cs_folders['folders_name']);
    $data['data']['folders_name'] = ' - ' . cs_link($cs_folders['folders_name'],'gallery','list','folders_id='.$cs_gallery['folders_id']);

    $gallery_id = isset($_POST['gallery_id']) ? $_POST['gallery_id'] : 0;
    $users_id = !empty($account['users_id']) ? $account['users_id'] : 0;

    if(isset($_POST['voted_answer'])) {
        $voted_answer = $_POST['voted_answer'];
        $voted_answer = $voted_answer + 1;
    }

    $check_user_voted = 0;
    for ($run = 0; $run < $voted_loop; $run++) {
        if($cs_voted[$run]['users_id'] == $users_id) {
            $check_user_voted++;
        }
    }
    $data['if']['vote'] = empty($advanced[0]) ? false : true;
    if(!empty($advanced[0])) {
        if(empty($check_user_voted) && empty($_POST['submit'])) {
            $data['if']['vote_allow'] = true;
            $data['if']['voted'] = false;
            $data['hidden']['id'] = $cs_gallery['gallery_id'];
            $levels = 0;
            $data['vote']['options'] = '';
            while($levels < 6) {
                $cs_gallery['gallery_vote'] == $levels ? $sel = 1 : $sel = 0;
                $xx = $levels + 1;
                $data['vote']['options'].= cs_html_option($cs_lang['vote_' . $xx],$levels,$sel);
                $levels++;
            }
        }
        else
        {
            $data['if']['vote_allow'] = false;
            $data['if']['voted'] = true;
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
    /*
     Zoom Buttons delete
     $viewmag1 = cs_icon('viewmag-',22,$cs_lang['viewmag_-']);
     $data['link']['picture_zoom_smaller'] = cs_link($viewmag1,'gallery','com_view','where=' . $id . '&amp;size=' . $size_minus);
     $window_fullscreen = cs_icon('viewmag1',22,$cs_lang['viewmag']);
     $data['link']['picture_zoom_normally'] = cs_link($window_fullscreen,'gallery','com_view','where=' . $id . '&amp;size='.$normal_size);
     $viewmag2 = cs_icon('viewmag+',22,$cs_lang['viewmag_+']);
     $data['link']['picture_zoom_bigger'] = cs_link($viewmag2,'gallery','com_view','where=' . $id . '&amp;size=' . $size_plus);
     */
    if($exp) {
        $icon_right = cs_icon('right',22,$cs_lang['rotate_right']);
        $data['link']['picture_rotate_right'] = cs_link($icon_right,'gallery','com_view','where=' . $id . '&amp;size=' . $pic_size . '&amp;rotate=' . $rotate_right);
    }
    $print = cs_icon('mail_new2',22,$cs_lang['ecard']);
    $data['link']['ecard'] = cs_link($print,'gallery','ecard','id=' . $cs_gallery['gallery_id']);
    #$temp_download = explode("|--@--|", $cs_gallery['gallery_download']);
    if(!empty($advanced[2])) {
        $print = cs_icon('thumbnail',22,$cs_lang['down_pic']);
        if(empty($cs_main['mod_rewrite'])) {
            $data['link']['download_picture'] = cs_html_link('mods/gallery/image.php?down=1&amp;pic=' . $cs_gallery['gallery_id'],$print,0);
        }
        else {
            $host = $cs_main['php_self']['website'];
            $host .= $cs_main['php_self']['dirname'];
            $host .= 'mods/gallery/image.php?down=1&amp;pic=' . $cs_gallery['gallery_id'];

            $data['link']['download_picture'] = cs_html_link($host,$print,0);
        }

        if(!empty($advanced[3])) {
            $print = cs_icon('zip_mount',22,$cs_lang['down_zip']);
            if(empty($cs_main['mod_rewrite'])) {
                $data['link']['download_zip'] = cs_html_link('mods/gallery/download.php?zip=1&amp;name=' . $cs_gallery['gallery_name'],$print,0);
            }
            else {
                $host = $cs_main['php_self']['website'];
                $host .= $cs_main['php_self']['dirname'];
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
                $host = $cs_main['php_self']['website'];
                $host .= $cs_main['php_self']['dirname'];
                $host .= 'mods/gallery/download.php?zip=1&amp;name=' . $cs_gallery['gallery_name'];

                $data['link']['download_zip'] = cs_html_link($host,$print,0);
            }
        }
    } else {
        $data['link']['download_picture'] = '';
        $data['link']['download_zip'] = '';
    }
    $print = cs_icon('fileprint',22,$cs_lang['print']);
    $data['link']['print'] = cs_link($print,'gallery','print','id=' . $cs_gallery['gallery_id']);

    if($rotate == 0)  {
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
            $host = $cs_main['php_self']['website'];
            $host .= $cs_main['php_self']['dirname'];
            $host .= 'mods/gallery/image.php?pic=' . $cs_gallery['gallery_id'];

            $data['data']['picture'] = cs_html_link($host,$cs_lap);
        }
    }
    else {
        if(empty($cs_main['mod_rewrite'])) {
            $data['data']['picture'] = cs_html_link('mods/gallery/image.php?pic=' . $cs_gallery['gallery_id'],$cs_lap,0,0,0,'rel="lightbox"');
        }
        else {
            $host = $cs_main['php_self']['website'];
            $host .= $cs_main['php_self']['dirname'];
            $host .= 'mods/gallery/image.php?pic=' . $cs_gallery['gallery_id'];

            $data['data']['picture'] = cs_html_link($host,$cs_lap,0,0,0,'rel="lightbox"');
        }
    }
    $data['data']['titel'] = $cs_gallery['gallery_titel'];
    $data['data']['date'] = cs_date('unix',$cs_gallery['gallery_time'],1);
    $users_nick = cs_sql_select(__FILE__,'users','users_nick','users_id = ' . $cs_gallery['users_id']);
    $data['data']['user'] = cs_secure($users_nick['users_nick']);
    $data['data']['description'] = cs_secure($cs_gallery['gallery_description'],1,1);
    $data['data']['pic_size'] = $img_size[0] . 'x' . $img_size[1] . ' Pixel';
    $size = filesize('uploads/gallery/pics/' . $cs_gallery['gallery_name']);
    $data['data']['filesize'] = cs_filesize($size);
    $data['data']['count'] = $cs_gallery['gallery_count'] + 1;

    $more = 'folders_id='.$cs_gallery['folders_id'].'&amp;where=';

    $puac = "gallery_status = 1 AND gallery_access <= '" . $account['access_gallery'] . "' AND folders_id = '" . $cs_gallery['folders_id'];
    $cond = "' AND gallery_id < '" . $cs_gallery['gallery_id'] . "'";
    $before = cs_sql_select(__FILE__,'gallery','gallery_id',$puac . $cond,'gallery_id DESC');
    $data['link']['picture_backward'] = empty($before) ? '' : cs_link(cs_icon('back',22),'gallery','com_view',$more.$before['gallery_id']);

    $cond = "' AND gallery_id > '" . $cs_gallery['gallery_id'] . "'";
    $next = cs_sql_select(__FILE__,'gallery','gallery_id',$puac . $cond,'gallery_id ASC');
    $data['link']['picture_forward'] = empty($next) ? '' : cs_link(cs_icon('forward',22),'gallery','com_view',$more.$next['gallery_id']);

    echo cs_subtemplate(__FILE__,$data,'gallery','com_view');

    $where3 = "comments_mod = 'gallery' AND comments_fid = '" . $id . "'";
    $count_com = cs_sql_count(__FILE__,'comments',$where3);
    include_once('mods/comments/functions.php');

    $data['comments']['view'] = '';
    $data['comments']['create'] = '';
    if(!empty($count_com)) {
        echo cs_html_br(1);
        echo cs_comments_view($id,'gallery','com_view',$count_com);
    }
    echo cs_comments_add($id,'gallery',$advanced[1]);
}