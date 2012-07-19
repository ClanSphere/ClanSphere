<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery', 1);
$cs_post = cs_post('id,cat_id,more,move');
$cs_get = cs_get('id_cat_id,more,move');

$id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $id = $cs_post['id'];
$cat_id = empty($cs_get['cat_id']) ? 0 : $cs_get['cat_id'];
if (!empty($cs_post['cat_id']))  $cat_id = $cs_post['cat_id'];
$detail = empty($cs_get['more']) ? 0 : $cs_get['more'];
if (!empty($cs_post['more']))  $more = $cs_post['more'];
$move = empty($cs_get['move']) ? 0 : $cs_get['move'];
if (!empty($cs_post['move']))  $move = $cs_post['move'];

$access_id = $account['access_usersgallery'];
$cs_options = cs_sql_option(__FILE__,'gallery');

$data['data']['addons'] = cs_addons('users','view',$id,'usersgallery');

$data['if']['error'] = FALSE;
$data['if']['view'] = FALSE;
$data['if']['details'] = FALSE;
$data['if']['vote'] = FALSE;


$select = 'usersgallery_id , usersgallery_name, usersgallery_titel, usersgallery_download, ';
$select .= 'usersgallery_description, usersgallery_time, usersgallery_vote, usersgallery_count, ';
$select .= 'usersgallery_close, folders_id';
$where = 'folders_id = ' . $cat_id . ' AND usersgallery_status = 1 AND usersgallery_access <= ' . $access_id;
switch($cs_options['list_sort']) {
  case 0:
    $order = 'usersgallery_id DESC';
  break;
  case 1:
    $order = 'usersgallery_id ASC';
  break;
}

if(empty($move) AND !empty($cs_get['pic_id'])) {
  $move = 0;
  $where .= ' AND usersgallery_id = ' . (int) $cs_get['pic_id'];
}

$cs_gallery = cs_sql_select(__FILE__,'usersgallery',$select,$where,$order,$move,0);
$gallery_loop = count($cs_gallery);
if(empty($gallery_loop))
{
  $data['if']['error'] = TRUE;

  $head = cs_link($cs_lang['mod_name'],'usersgallery','users','id='. $id) .' - ';
  $data['head']['mod'] = $head . $cs_lang['head_view'];
  $data['link']['back'] = cs_link($cs_lang['back'],'usersgallery','users','id='. $id);
}
else
{
  $data['if']['view'] = TRUE;

  $select = 'folders_id, folders_name, folders_access, folders_picture, folders_text, folders_advanced';
  $where = 'folders_mod = \'usersgallery\' AND folders_id = "' . $cat_id . '"';  
  $cs_cat = cs_sql_select(__FILE__,'folders',$select,$where);

  $advanced = empty($cs_cat['folders_advanced']) ? '0,0,0,0' : $cs_cat['folders_advanced'];
  $advanced = explode(",",$advanced);

  if($account['access_usersgallery'] < $cs_cat['folders_access']) {
    $data['if']['error'] = TRUE;
    $data['if']['view'] = FALSE;
    $detail = 0;
  }

  $usersgallery_id = $cs_gallery[$move]['usersgallery_id'];
  $where = 'voted_fid = "' . $usersgallery_id . '" AND voted_mod = \'usersgallery\'';
  $cs_voted = cs_sql_select(__FILE__,'voted','users_id, voted_answer',$where,'',0,0);
  $voted_loop = count($cs_voted);

  $voted['voted_fid'] = !empty($_POST['voted_fid']) ? $_POST['voted_fid'] : 0;
  $voted['users_id'] = !empty($account['users_id']) ? $account['users_id'] : 0;
  $voted['voted_answer'] = !empty($_POST['voted_answer']) ? $_POST['voted_answer'] : 0;
  $voted['voted_time'] = cs_time();
  $voted['voted_ip'] = cs_getip();
  $voted['voted_mod'] = 'usersgallery';

  $check_user_voted = 0;
  for ($run = 0; $run < $voted_loop; $run++) {
    if($cs_voted[$run]['users_id'] == $account['users_id']) {
      $check_user_voted++;
    }
  }
  if(empty($check_user_voted)) {
    if(isset($_POST['submit'])) {
      $votes_cells = array_keys($voted);
      $votes_save = array_values($voted);
     cs_sql_insert(__FILE__,'voted',$votes_cells,$votes_save);
    }
  }

  $head = cs_link($cs_lang['mod_name'],'usersgallery','users','id='. $id) .' - ';
  $head .= cs_link(cs_secure($cs_cat['folders_name']),'usersgallery','users','cat_id='. $cs_cat['folders_id'] .'&amp;id='. $id);
  $cs_lap = cs_html_img( "mods/gallery/image.php?userspic=" . $cs_gallery[$move]['usersgallery_id'] . "&amp;size=" . $cs_options['max_width']);

  $data['head']['view'] = $head;
  $data['gallery']['titel'] = cs_secure($cs_gallery[$move]['usersgallery_titel']);

  if(!empty($move)) {
    $back_1 = $move-1;
  }

  $forward_1 = $move+1;
  if($forward_1 < $gallery_loop) {
    $forward = cs_html_img($cs_main['php_self']['dirname'] . "mods/gallery/image.php?usersthumb=" . $cs_gallery[$forward_1]['usersgallery_id']);
  }

  if($cs_options['lightbox'] == '0' ) {
    $img = cs_html_link($cs_main['php_self']['dirname'] . "mods/gallery/image.php?userspic=" . $cs_gallery[$move]['usersgallery_id'],$cs_lap);
  }
  else {
    $img = cs_html_link($cs_main['php_self']['dirname'] . "mods/gallery/image.php?userspic=" . $cs_gallery[$move]['usersgallery_id'],$cs_lap,0,0,0,'rel="lightbox"');
  }
  $data['gallery']['img'] = $img;
  
  $data['link']['back'] = '';
  if(!empty($move)) {
    $back = cs_icon('back',22,$cs_lang['back']);
    $back_1 = $move-1;
    $data['link']['back'] = cs_link($back,'usersgallery','com_view','cat_id='. $cat_id .'&amp;move='. $back_1 .'&amp;more=' . $detail .'&amp;id=' . $id);
  }
  $data['one']['of'] = $forward_1 . '/' . $gallery_loop;
  $data['link']['forward'] = '';
  if($forward_1 < $gallery_loop) {
    $forward = cs_icon('forward',22,$cs_lang['forword']);
    $data['link']['forward'] = cs_link($forward,'usersgallery','com_view','cat_id='. $cat_id .'&amp;move='. $forward_1 .'&amp;more=' . $detail .'&amp;id=' . $id);
  }

  $view_bottom = cs_icon('view_bottom',22,$cs_lang['head']);
  if($detail == '1') {
    $data['view']['bottom'] = cs_link($view_bottom,'usersgallery','com_view','cat_id='. $cat_id .'&amp;move='. $move .'&amp;more=0&amp;id=' . $id);
  } else {
    $data['view']['bottom'] = cs_link($view_bottom,'usersgallery','com_view','cat_id='. $cat_id .'&amp;move='. $move .'&amp;more=1&amp;id=' . $id);
  }


  if($detail == '1')
  {
    $data['if']['details'] = TRUE;
    $data['details']['date'] = cs_date('unix',$cs_gallery[$move]['usersgallery_time'],1);
    $data['details']['description'] = cs_secure($cs_gallery[$move]['usersgallery_description'],1,1);

    $img_size = getimagesize("uploads/usersgallery/pics/" . $cs_gallery[$move]['usersgallery_name']);
    $img_width = $img_size[0];
    $img_height = $img_size[1];
    $img_w_h = $img_width / $img_height;  
    $data['details']['size'] = $img_width . ' x ' . $img_height . ' Pixel';

    $file = 'uploads/usersgallery/pics/' . $cs_gallery[$move]['usersgallery_name'];
    $size = filesize($file);
    $data['details']['filesize'] = cs_filesize($size);
    $data['details']['count'] = $cs_gallery[$move]['usersgallery_count'] + 1;


    #if voting is allowed
    if(!empty($advanced[0]))
    {
      $data['if']['vote'] = TRUE;
      $data['if']['vote_now'] = FALSE;
      $data['if']['voted'] = FALSE;
      
      #if user hasn't voted yet
      if(empty($check_user_voted))
      {
        $data['if']['vote_now'] = TRUE;
        $data['form']['action'] = cs_url('usersgallery','com_view','cat_id='. $cat_id .'&amp;move='. $move .'&amp;more=1&amp;id=' . $id);

        $levels = 1;
        $voted_answer = 1;
        $data['vote']['options'] = '';
        while($levels < 7)
        {
          $voted_answer == $levels ? $sel = 1 : $sel = 0;
          $data['vote']['options'] .= cs_html_option($levels . ' - ' . $cs_lang['vote_' . $levels],$levels,$sel);
          $levels++;
        }
        $data['hidden']['id'] = $cs_gallery[$move]['usersgallery_id'];
      }
      else
      {
        #when already voted -> show result
        
        $data['if']['voted'] = TRUE;
        $gallery_votes = 0;
        for($run=0; $run<$voted_loop; $run++)
        {
          $a = cs_secure($cs_voted[$run]['voted_answer']);
          $gallery_votes += $a;
        }
        $gallery_votes = $gallery_votes / $voted_loop;
        $gallery_votes = round($gallery_votes,2);
        $data['result']['votes'] = $cs_lang['pic_note'] . "$gallery_votes ($voted_loop" . $cs_lang['pic_stim'] . ")";

        $data['result']['icons'] = '';
        $gallery_votes = round($gallery_votes,0);
        for($run=6; $run>$gallery_votes; $run--) {
          $data['result']['icons'] .= cs_icon('favorites');
        }
        for($run=1; $run<$gallery_votes; $run++) {
          $data['result']['icons'] .= cs_icon('favorites1');
        }
      }
    }
  }

  echo cs_subtemplate(__FILE__,$data,'usersgallery','com_view');

  if($detail == '1')
  {
    $where = "comments_mod = 'usersgallery' AND comments_fid = '" . $usersgallery_id . "'";
    $com_loop = cs_sql_count(__FILE__,'comments',$where);
    include_once('mods/comments/functions.php');
    if(!empty($com_loop))
    {
      echo cs_html_br(1);
      echo cs_comments_view($usersgallery_id,'usersgallery','com_view',$com_loop);
    }
    echo cs_comments_add($usersgallery_id,'usersgallery',$advanced[1]);
  }
}
