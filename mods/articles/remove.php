<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('articles');

$data['if']['head'] = 0;

if(isset($_POST['agree'])) {
  $data['if']['head'] = 0;
  $articles_form = 0;
  $articles_id = $_POST['id'];
    settype($articles_id, 'integer');

  cs_sql_delete(__FILE__,'articles',$articles_id);
  $query = "DELETE FROM {pre}_comments WHERE comments_mod='articles' AND ";
  $query .= "comments_fid='" . $articles_id . "'";
  cs_sql_query(__FILE__,$query);
  
  require_once 'mods/pictures/functions.php';
  cs_pictures_delete($articles_id, 'articles');
  
  cs_redirect($cs_lang['del_true'], 'articles');
}
elseif(isset($_POST['cancel'])) 
  cs_redirect($cs_lang['del_false'], 'articles');
else {
  $data['if']['head'] = 1;
  $data['articles']['id'] = $_GET['id'];
  $data['head']['body'] = sprintf($cs_lang['body_remove'],$data['articles']['id']);
  echo cs_subtemplate(__FILE__,$data,'articles','remove');
}

?>