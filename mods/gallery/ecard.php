<?PHP
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');
$cs_post = cs_post('id');
$cs_get = cs_get('id');
$data = array();

$picture_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $picture_id = $cs_post['id'];

$ecard['sender_name'] = '';
$ecard['sender_mail'] = '';
$ecard['receiver_name'] = '';
$ecard['receiver_mail'] = '';
$ecard['ecard_titel'] = '';
$ecard['ecard_text'] = '';

$data['if']['preview'] = FALSE;

if(!empty($account['users_id'])) {
  $cs_ecard_users = cs_sql_select(__FILE__,'users','users_nick, users_email',"users_id = '" . $account['users_id'] . "'");
  $ecard['sender_name'] = $cs_ecard_users['users_nick'];
  $ecard['sender_mail'] = $cs_ecard_users['users_email'];
}


if(isset($_POST['submit']) OR isset($_POST['preview'])) {

  $ecard['receiver_name'] = $_POST['receiver_name'];
  $ecard['receiver_mail'] = $_POST['receiver_mail'];
  $ecard['ecard_titel'] = $_POST['ecard_titel'];
  $ecard['ecard_text'] = $_POST['ecard_text'];
  
  $error = '';

  if(empty($ecard['sender_name']) AND empty($ecard['sender_mail']))
    $error .= $cs_lang['error_sender'] . cs_html_br(1);

  if(empty($ecard['receiver_name']) AND empty($ecard['receiver_mail']))
    $error .= $cs_lang['error_receiver'] . cs_html_br(1);
    
  if(empty($ecard['ecard_titel']) AND empty($ecard['ecard_text']))
    $error .= $cs_lang['error_text'] . cs_html_br(1);
    
  $pattern = "=^[_a-z0-9-]+(\.[_a-z0-9-]+)*@([0-9a-z](-?[0-9a-z])*\.)+[a-z]{2}([zmuvtg]|fo|me)?$=i";
  if(!preg_match($pattern,$ecard['receiver_mail'])) {
    $error .= $cs_lang['email_false'] . cs_html_br(1);
  }

}

if(!isset($_POST['submit']) OR !isset($_POST['preview']))
  $data['head']['body'] = $cs_lang['ecard_body_list'];
if(!empty($error))
  $data['head']['body'] = $error;


if(isset($_POST['preview']) AND empty($error)) {

  $data['if']['preview'] = TRUE;
  $data['prev']['img'] = cs_html_img('mods/gallery/image.php?pic=' . $picture_id . '&size=300');
  $data['prev']['mailfrom'] = cs_html_link('mailto:' . $ecard['sender_mail'],$ecard['sender_name'],1);
  $data['prev']['mailto'] = cs_html_link('mailto:' . $ecard['receiver_mail'],$ecard['receiver_name'],1);
  $data['prev']['time'] = cs_date('unix',cs_time(),1);
  $data['prev']['titel'] = cs_secure($ecard['ecard_titel']);
  $data['prev']['text'] = cs_secure($ecard['ecard_text'],1);
}

if(!empty($error) OR !isset($_POST['submit']) OR isset($_POST['preview'])) {

  $data['data'] = $ecard;
  $data['ecard']['picture'] = cs_html_img('mods/gallery/image.php?pic=' . $picture_id . '&size=300');
  $data['abcode']['features'] = cs_abcode_features('ecard_text');
  $data['hidden']['id'] = $picture_id;
  
 echo cs_subtemplate(__FILE__,$data,'gallery','ecard');
}
else {
  
  $send['data'] = $ecard;
  $send['data']['src'] = $cs_main['php_self']['website'] . '/mods/gallery/image.php?pic=' . $picture_id . '&size=300';
  $send['data']['time'] = cs_date('unix',cs_time(),1);
  $send['data']['ecard_titel'] = cs_secure($ecard['ecard_titel']);
  $send['data']['ecard_text'] = cs_secure($ecard['ecard_text'],1);
  $message = cs_subtemplate(__FILE__,$send,'gallery','ecard_mail');
  
  if(cs_mail($ecard['receiver_mail'],$ecard['ecard_titel'],$message,0,'text/html')) {
    $where = "gallery_id = '" . cs_sql_escape($picture_id) . "'"; 
    $cs_gallery = cs_sql_select(__FILE__,'gallery','gallery_count_cards',$where);
    
    $gallery_count = $cs_gallery['gallery_count_cards'] + 1;
    $gallery_cells = array('gallery_count_cards');
    $gallery_save = array($gallery_count);
   cs_sql_update(__FILE__,'gallery',$gallery_cells,$gallery_save,$picture_id);
     $msg = $cs_lang['create_down'];
  }
  else {
    $msg = $cs_lang['create_error'];
  }
  
 cs_redirect($msg,'gallery','com_view','where=' . $picture_id);
}