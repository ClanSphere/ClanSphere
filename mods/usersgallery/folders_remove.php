<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');
require_once('mods/usersgallery/functions.php');
$form = 1;
$id = $_REQUEST['id'];
settype($id,'integer');

$from = 'folders';
$select = 'folders_id, sub_id, ';
$select .= 'folders_name, folders_order, ';
$select .= 'folders_position, folders_picture';
$where = "folders_id='" . $id . "' AND folders_mod='usersgallery'";
$order = 'folders_id ASC';
$array = cs_sql_select(__FILE__,$from,$select,$where);

$pic = cs_secure($array['folders_picture']);

if(isset($_POST['agree']))
{
  $form = 0;
  if(!empty($pic)) {
    cs_unlink('folders', $pic, 'pictures');
  }

  $from = 'folders';
  $select = 'folders_id, sub_id, ';
  $select .= 'folders_name, folders_order, folders_position';
  $where = "users_id='" . $account['users_id'] . "' AND folders_mod='usersgallery'";
  $order = 'folders_id ASC';
  $array = cs_sql_select(__FILE__,$from,$select,$where,$order,0,0);
  $loop = count($array);
  $array = make_folders_array($array);
  make_folders_remove($array,$id);

  cs_redirect($cs_lang['del_true'],'usersgallery','center','page=cat');
}

if(isset($_POST['cancel']))
{
  $form = 0;

  cs_redirect($cs_lang['del_false'],'usersgallery','center','page=cat');
}

if(!empty($form))
{
  echo cs_html_table(1,'forum',1);
    echo cs_html_roco(1,'headb');
    echo $cs_lang['mod'] . ' - ' . $cs_lang['remove'];
    echo cs_html_roco(0);
    echo cs_html_roco(1,'leftb');
  echo sprintf($cs_lang['del_rly'],$array['folders_name']);
  echo cs_html_roco(0);
  echo cs_html_roco(1,'centerc');
  echo cs_html_form(1,'remove','usersgallery','folders_remove');
  echo cs_html_vote('id',$id,'hidden');
  echo cs_html_vote('agree',$cs_lang['confirm'],'submit');
  echo cs_html_vote('cancel',$cs_lang['cancel'],'submit');
  echo cs_html_form (0);
  echo cs_html_roco(0);
  echo cs_html_table(0);
}
?>