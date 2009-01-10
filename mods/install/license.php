<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('install');

if(isset($_POST['submit'])) {

	$license = isset($_POST['accept']) ? $_POST['accept'] : 0;
  $error = 0;
  $errormsg = '';

  if(empty($license)) {
    $error++;
    $errormsg .= $cs_lang['not_accepted'] . cs_html_br(1);
  }
}

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_license'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc');
if(!isset($_POST['submit'])) {
  echo $cs_lang['body_license'];
}
elseif(!empty($error)) {
  echo $errormsg;
}
else {
  #echo $cs_lang['accept_done'];
  header('Location: ' . str_replace('&amp;','&',cs_url('install','settings','lang=' . $account['users_lang'])));
}
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

if(!empty($error) OR !isset($_POST['submit'])) {

	echo cs_html_form(1,'install_license','install','license');
	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'leftc');
?>
ClanSphere 2008
<?php echo cs_html_br(1); ?>
Copyright (c) 2007, ClanSphere Project
<?php echo cs_html_br(1); ?>
All rights reserved.
<?php echo cs_html_br(2); ?>
Redistribution and use in source and binary forms, with or without modification, 
are permitted provided that the following conditions are met:
<?php echo cs_html_br(2); ?>
* Redistributions of source code must retain the above copyright notice, 
this list of conditions and the following disclaimer.
<?php echo cs_html_br(2); ?>
* Redistributions in binary form must reproduce the above copyright notice, 
this list of conditions and the following disclaimer in the documentation and/or other 
materials provided with the distribution.
<?php echo cs_html_br(2); ?>
* Neither the name of the ClanSphere Project nor the names of its contributors 
may be used to endorse or promote products derived from this software without specific 
prior written permission.
<?php echo cs_html_br(2); ?>
THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" 
AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED 
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. 
IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, 
INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, 
BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, 
OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, 
WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) 
ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE 
POSSIBILITY OF SUCH DAMAGE.

<?php
	echo cs_html_roco(0);

	echo cs_html_roco(1,'leftb');
	echo cs_html_vote('accept','1','checkbox');
	echo ' ' . $cs_lang['accept_license'];
	echo cs_html_roco(0);
  
  echo cs_html_roco(1,'leftc');
	echo cs_html_input('lang',$account['users_lang'],'hidden');
  echo cs_html_vote('submit',$cs_lang['send'],'submit');
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_form(0);
}
else {

	cs_redirect('','install','settings','lang=' . $account['users_lang']);
}

?>