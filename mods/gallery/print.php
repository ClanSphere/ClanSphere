<?PHP
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');
$cs_post = cs_post('id');
$cs_get = cs_get('id');
$data = array();

$picture_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $picture_id = $cs_post['id'];

$data['if']['preview'] = FALSE;


if(isset($_POST['preview'])) {

  $print = empty($_POST['print']) ? 0 : $_POST['print'];
  $print_width = empty($_POST['print_width']) ? '1024' : $_POST['print_width'];
  $print_height = empty($_POST['print_height']) ? '768' : $_POST['print_height'];

  $print_form_height[0] = '';
  $print_form_width[0] = '';
  $print_form_height[1] = '255';
  $print_form_width[1] = '369';
  $print_form_height[2] = '283';
  $print_form_width[2] = '425';
  $print_form_height[3] = '369';
  $print_form_width[3] = '510';  
  $print_form_height[4] = '421';
  $print_form_width[4] = '298';
  $print_form_height[5] = '842';
  $print_form_width[5] = '595';
  $print_form_height[6] = '1684';
  $print_form_width[6] = '1191';
  $print_form_height[7] = $print_height;
  $print_form_width[7] = $print_width;

  $height = $print_form_height[$print];
  $width = $print_form_width[$print];

  $error = '';

  if(empty($print))
    $error .= $cs_lang['error_print'] . cs_html_br(1);
  if(empty($picture_id))
    $error .= $cs_lang['error_pic'] . cs_html_br(1);

}

if(!isset($_POST['preview']) OR isset($_POST['preview']))
  $data['head']['body'] = $cs_lang['body_print'];
elseif(!empty($error))
  $data['head']['body'] = $error;


if(isset($_POST['preview']) AND empty($error)) {
  $data['if']['preview'] = TRUE;
  
  if(extension_loaded('gd')) {
    $data['print']['img'] = cs_html_img("mods/gallery/image.php?pic=" . $picture_id . "&amp;size=" . $width);
    $host = $cs_main['php_self']['website'] . $cs_main['php_self']['dirname'];
    $data['print']['url'] = $host . "mods/gallery/print_now.php?pic=" . $picture_id . "&amp;size=" . $width;
    $data['if']['extension'] = TRUE;
  } else {
    $data['print']['img'] = cs_html_img("mods/gallery/image.php?pic=" . $picture_id,$height,$width,'',$picture_id);
    $data['if']['extension'] = FALSE;
  }
}

$data['picture']['id'] = $picture_id;

echo cs_subtemplate(__FILE__,$data,'gallery','print');