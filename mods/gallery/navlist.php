<?PHP
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');
$cs_option = cs_sql_option(__FILE__,'gallery');
$access_id = $account['access_gallery'];

$from = 'gallery';
$select = 'gallery_id';
$where = "gallery_access < '" . $access_id . "' AND gallery_status = '1'"; 
$order = 'gallery_id DESC';
$cs_gallery = cs_sql_select(__FILE__,$from,$select,$where,$order,0,$cs_option['max_navlist']);
$gallery_loop = count($cs_gallery);

$count = !empty($gallery_loop) ? ($gallery_loop - 1) : 0;
mt_srand((double)microtime()*1000000);
$run = mt_rand(0,$count);
$pic = cs_secure($cs_gallery[$run]['gallery_id']);

if(!empty($pic)) {
  
  $img = cs_html_img('mods/gallery/image.php?thumb=' . $pic);
  echo cs_link($img,'gallery','com_view','where=' . $pic);
  
} else {
  
  echo $cs_lang['nopic'];
  
}