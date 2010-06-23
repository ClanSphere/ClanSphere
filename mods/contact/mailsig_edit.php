<?php
// ClanSphere 2010 - www.clansphere.net 
// $Id$

$cs_lang = cs_translate('contact');

$data = array();

$filename = 'uploads/imprint/mailsig.txt';
$sig_form = 1;
$mailsig = file_exists($filename) ? file_get_contents($filename) : '';

if(!empty($_POST['mailsig']))
  $mailsig = empty($cs_main['rte_html']) ? $_POST['mailsig'] : cs_abcode_inhtml($_POST['mailsig'], 'add');

if(isset($_POST['submit'])) {
  $sig_form = 0;
  $data['if']['done']     = TRUE;
  $data['if']['form']     = FALSE;

  if (file_exists($filename))
    cs_unlink('imprint', 'mailsig.txt');

    $fp = fopen ($filename, "w");
    chmod($filename,0777);
    # set stream encoding if possible to avoid converting issues
    if(function_exists('stream_encoding'))
      stream_encoding($fp, $cs_main['charset']);
    fwrite ($fp, $mailsig);
    chmod($filename,0644);
    fclose ($fp);
}
if(!empty($sig_form)) {

  $data = array();
  $data['mailsig']['content'] = $mailsig;

  if(empty($cs_main['rte_html'])) {
    $data['if']['abcode'] = TRUE;
    $data['if']['rte_html'] = FALSE;
    $data['abcode']['features'] = cs_abcode_features('mailsig');
  }
  else {
    $data['if']['abcode'] = FALSE;
    $data['if']['rte_html'] = TRUE;
    $data['rte']['html'] = cs_rte_html('mailsig',$data['mailsig']['content']);
  }

  $data['if']['done']     = FALSE;
  $data['if']['form']     = TRUE;
}

$data['url']['contact_mailsig_edit'] = cs_url('contact','mailsig_edit');

echo cs_subtemplate(__FILE__,$data,'contact','mailsig_edit');