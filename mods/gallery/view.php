<?PHP
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');

$modul = 'gallery';
$time = cs_time();
$users_id = $account['users_id'];
$access_id = $account['access_gallery'];
$voted_ip = $_SERVER['REMOTE_ADDR'];
$exp = extension_loaded('gd');

$cs_gallery_opt = cs_sql_option(__FILE__,'gallery');
$max_width = $cs_gallery_opt['max_width'];
$list_sort = $cs_gallery_opt['list_sort'];

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cat_id = empty($_REQUEST['cat_id']) ? 0 : $_REQUEST['cat_id'];
settype($cat_id,'integer');

$from = 'gallery';
$select = 'gallery_id, gallery_name, gallery_titel, gallery_download, gallery_description, gallery_time, gallery_vote, gallery_count, categories_id';
$where = "categories_id = '" . $cat_id . "' AND gallery_status = '1' AND gallery_access <= '" . $access_id . "'"; 
switch($list_sort) 
{
  case 0:
    $order = 'gallery_id DESC';
  break;
  case 1:
    $order = 'gallery_id ASC';
  break;
}
$cs_gallery = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,0);
$gallery_loop = count($cs_gallery);

$cat_id = $cs_gallery[$start]['categories_id'];
$cs_lap = cs_html_img("mods/gallery/image.php?pic=" . $cs_gallery[$start]['gallery_id'] . "&size=" . $max_width);

$from = 'categories';
$select = 'categories_id, categories_name, categories_picture, categories_text';
$where = "categories_mod = 'gallery' AND categories_id = '" . $cat_id . "'"; 
$cs_cat = cs_sql_select(__FILE__,$from,$select,$where);
$cat_loop = count($cs_cat);

$head = cs_link($cs_lang['mod'],'gallery','list') .' - ';
$head .= cs_link($cs_cat['categories_name'],'gallery','list','cat_id=' . $cs_cat['categories_id'] );

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $head;
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'centerb',0,3);
echo $cs_gallery[$start]['gallery_titel'];
echo cs_html_roco(0);
echo cs_html_roco(1,'centerc',0,3);
echo cs_link($cs_lap,'gallery','com_view','where=' . $cs_gallery[$start]['gallery_id']);
echo cs_html_roco(0);
  
echo cs_html_roco(1,'centerb',0,2);
if(!empty($start))
{
  $back = cs_icon('back',22,$cs_lang['back']);
  $back_1 = $start-1;
  echo cs_link($back,'gallery','view',"cat_id=$cat_id&start=$back_1");
}
$forward_1 = $start+1;
echo ' ' . $forward_1 . '/' . $gallery_loop . ' ';
if($forward_1 < $gallery_loop)
{
  $forward = cs_icon('forward',22,$cs_lang['continue']);
  echo cs_link($forward,'gallery','view',"cat_id=$cat_id&start=$forward_1");
}
echo cs_html_roco(2,'centerb',0,1,150);
$com = cs_icon('kopete',22,$cs_lang['comments']);
echo cs_link($com,'gallery','com_view','where=' . $cs_gallery[$start]['gallery_id']);
echo cs_html_roco(0);
echo cs_html_table(0);
?>