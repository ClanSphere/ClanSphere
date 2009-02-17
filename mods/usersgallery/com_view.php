<?PHP
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');

$modul = 'usersgallery';
$access_id = $account['access_usersgallery'];
$cs_options = cs_sql_option(__FILE__,'gallery');

$id = empty($_REQUEST['id']) ? 0 : $_REQUEST['id'];
$move = empty($_REQUEST['move']) ? 0 : $_REQUEST['move'];
$cat_id = empty($_REQUEST['cat_id']) ? 0 : $_REQUEST['cat_id'];
$detail = empty($_REQUEST['more']) ? 0 : $_REQUEST['more'];
settype($cat_id, 'integer');

$from = 'usersgallery';
$select = $from . '_id, ' . $from . '_name, ' . $from . '_titel, ';
$select .= $from . '_download, ' . $from . '_description, ' . $from . '_time, ';
$select .= $from . '_vote, ' . $from . '_count, folders_id';
$where = "folders_id = '" . $cat_id . "' AND usersgallery_status = '1' AND usersgallery_access <= '" . $access_id . "'";
switch($cs_options['list_sort']) {
  case 0:
    $order = 'usersgallery_id DESC';
  break;
  case 1:
    $order = 'usersgallery_id ASC';
  break;
}
$cs_gallery = cs_sql_select(__FILE__,$from,$select,$where,$order,$move,0);
$gallery_loop = count($cs_gallery);
if(empty($gallery_loop))
{
  $head = cs_link($cs_lang['mod'],'usersgallery','users','id='. $id) .' - ';
  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'headb');
  echo $head . $cs_lang['head_view'];
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
  echo cs_link($cs_lang['back'],'usersgallery','users','id='. $id);
  echo cs_html_roco(0);
  echo cs_html_table(0);
}
else
{
  $from = 'folders';
  $select = $from . '_id, ' . $from . '_name, ' . $from . '_picture, ' . $from . '_text';
  $where = "folders_mod='usersgallery' AND folders_id = '" . $cat_id . "'";
  $cs_cat = cs_sql_select(__FILE__,$from,$select,$where);
  $cat_loop = count($cs_cat);

  $from = 'voted';
  $select = 'users_id, voted_answer';
  $usersgallery_id = $cs_gallery[$move]['usersgallery_id'];
  $where = "voted_fid = '" . $usersgallery_id . "' AND voted_mod='usersgallery'";
  $cs_voted = cs_sql_select(__FILE__,$from,$select,$where,'',0,0);
  $voted_loop = count($cs_voted);

  $voted['voted_fid'] = !empty($_POST['voted_fid']) ? $_POST['voted_fid'] : 0;
  $voted['users_id'] = !empty($account['users_id']) ? $account['users_id'] : 0;
  $voted['voted_answer'] = !empty($_POST['voted_answer']) ? $_POST['voted_answer'] : 0;
  $voted['voted_time'] = cs_time();
  $voted['voted_ip'] = $_SERVER['REMOTE_ADDR'];
  $voted['voted_mod'] = 'usersgallery';

  $check_user_voted = 0;
  for ($run = 0; $run < $voted_loop; $run++)
  {
    if($cs_voted[$run]['users_id'] == $account['users_id'])
    {
      $check_user_voted++;
    }
  }
  if(empty($check_user_voted))
  {
    if(isset($_POST['submit']))
    {
      $votes_cells = array_keys($voted);
      $votes_save = array_values($voted);
      cs_sql_insert(__FILE__,'voted',$votes_cells,$votes_save);
    }
  }

  $head = cs_link($cs_lang['mod'],'usersgallery','users','id='. $id) .' - ';
  $head .= cs_link($cs_cat['folders_name'],'usersgallery','users','cat_id='. $cs_cat['folders_id'] .'&amp;id='. $id);
  $cs_lap = cs_html_img("mods/gallery/image.php?userspic=" . $cs_gallery[$move]['usersgallery_id'] . "&amp;size=" . $cs_options['max_width']);

  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'headb',0,2);
  echo $head;
  echo cs_html_roco(0);

  echo cs_html_roco(1,'centerb',0,2);
  echo $cs_gallery[$move]['usersgallery_titel'];
  if(!empty($move)) {
    $back_1 = $move-1;
  }
  $forward_1 = $move+1;
  if($forward_1 < $gallery_loop) {
    $forward = cs_html_img("mods/gallery/image.php?usersthumb=" . $cs_gallery[$forward_1]['usersgallery_id']);
  }
  echo cs_html_roco(0);

  echo cs_html_roco(1,'centerc',0,2);
  if($cs_options['lightbox'] == '0' ) {
    echo cs_html_link("mods/gallery/image.php?userspic=" . $cs_gallery[$move]['usersgallery_id'],$cs_lap);
  } else {
    echo cs_html_link("mods/gallery/image.php?userspic=" . $cs_gallery[$move]['usersgallery_id'],$cs_lap,0,0,0,'rel="lightbox"');
  }
  echo cs_html_roco(0);
  
  echo cs_html_roco(1,'centerb');
  if(!empty($move)) {
    $back = cs_icon('back',22,$cs_lang['back']);
    $back_1 = $move-1;
    echo cs_link($back,'usersgallery','com_view','cat_id='. $cat_id .'&amp;move='. $back_1 .'&amp;more=' . $detail .'&amp;id=' . $id);
  }
  echo ' ' . $forward_1 . '/' . $gallery_loop . ' ';
  if($forward_1 < $gallery_loop) {
    $forward = cs_icon('forward',22,$cs_lang['forword']);
    echo cs_link($forward,'usersgallery','com_view','cat_id='. $cat_id .'&amp;move='. $forward_1 .'&amp;more=' . $detail .'&amp;id=' . $id);
  }
  echo cs_html_roco(2,'centerb',0,0,'50%');
  $view_bottom = cs_icon('view_bottom',22,$cs_lang['head']);
  if($detail == '1') {
    echo cs_link($view_bottom,'usersgallery','com_view','cat_id='. $cat_id .'&amp;move='. $move .'&amp;more=0&amp;id=' . $id);
  } else {
    echo cs_link($view_bottom,'usersgallery','com_view','cat_id='. $cat_id .'&amp;move='. $move .'&amp;more=1&amp;id=' . $id);
  }
  echo cs_html_roco(0);
  if($detail == '1')
  {
    echo cs_html_roco(1,'leftb');
    echo cs_icon('today');
    echo $cs_lang['date'];
    echo cs_html_roco(2,'leftc');
    echo cs_date('unix',$cs_gallery[$move]['usersgallery_time'],1);
    echo cs_html_roco(0);

    echo cs_html_roco(1,'leftb');
    echo cs_icon('contents');
    echo $cs_lang['gallery_description'];
    echo cs_html_roco(2,'leftc');
    echo cs_secure($cs_gallery[$move]['usersgallery_description'],1,1);
    echo cs_html_roco(0);

    $img_size = getimagesize("uploads/usersgallery/pics/" . $cs_gallery[$move]['usersgallery_name']);
    $img_width = $img_size[0];
    $img_height = $img_size[1];
    $img_w_h = $img_width / $img_height;

    echo cs_html_roco(1,'leftb');
    echo cs_icon('window_fullscreen');
    echo $cs_lang['dissolution'];
    echo cs_html_roco(2,'leftc');
    echo "$img_width x $img_height Pixel";
    echo cs_html_roco(0);

    echo cs_html_roco(1,'leftb');
    echo cs_icon('fileshare');
    echo $cs_lang['filesize'];
    echo cs_html_roco(2,'leftc');
    $file = 'uploads/usersgallery/pics/' . $cs_gallery[$move]['usersgallery_name'];
    $size = filesize($file);
    echo cs_filesize($size);
    echo cs_html_roco(0);

    echo cs_html_roco(1,'leftb');
    echo cs_icon('kdict');
    echo $cs_lang['gallery_count'];
    echo cs_html_roco(2,'leftc');
    echo $cs_gallery[$move]['usersgallery_count'] + 1;
    echo cs_html_roco(0);

    $check_vote = $cs_gallery[$move]['usersgallery_vote'];

    if(!empty($check_vote))
    {
      echo cs_html_roco(1,'leftb');
      echo cs_icon('Volume Manager');
      echo $cs_lang['gallery_vote'];
      if(empty($check_user_voted))
      {
        echo cs_html_roco(2,'leftc');
        echo cs_html_form(1,'usersgallery','usersgallery','com_view&amp;cat_id='. $cat_id .'&amp;move='. $move .'&amp;more=1&amp;id=' . $id);
        echo cs_html_select(1,'voted_answer');
        $levels = 1;
        $voted_answer = 1;
        while($levels < 7)
        {
          $voted_answer == $levels ? $sel = 1 : $sel = 0;
          echo cs_html_option($levels . ' - ' . $cs_lang['vote_' . $levels],$levels,$sel);
          $levels++;
        }
        echo cs_html_select(0);
        echo cs_html_vote('voted_fid',$cs_gallery[$move]['usersgallery_id'],'hidden');
        echo cs_html_vote('submit',$cs_lang['ok'],'submit');
        echo cs_html_form (0);
      }
      else
      {
        $gallery_votes = 0;
        for($run=0; $run<$voted_loop; $run++)
        {
          $a = cs_secure($cs_voted[$run]['voted_answer']);
          $gallery_votes += $a;
        }
        echo cs_html_roco(2,'leftc');
        $gallery_votes = $gallery_votes / $voted_loop;
        $gallery_votes = round($gallery_votes,2);
        echo cs_html_div(1,'float:left');
        echo $cs_lang['pic_note'] . "$gallery_votes ($voted_loop" . $cs_lang['pic_stim'] . ")";
        echo cs_html_div(0);
        echo cs_html_div(1,'float:right');
        $gallery_votes = round($gallery_votes,0);
        for($run=6; $run>$gallery_votes; $run--) {
          echo cs_icon('favorites');
        }
        for($run=1; $run<$gallery_votes; $run++) {
          echo cs_icon('favorites1');
        }
        echo cs_html_div(0);
      }
      echo cs_html_roco(0);
    }
  }
  echo cs_html_table(0);

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
    echo cs_comments_add($usersgallery_id,'usersgallery',$cs_gallery[$move]['usersgallery_close']);
  }
}
?>