<?php 
@error_reporting(E_ALL);

@ini_set('arg_separator.output','&amp;');
@ini_set('session.use_trans_sid','0');
@ini_set('session.use_cookies','1');
@ini_set('session.use_only_cookies','1');
@ini_set('display_errors','on');
@ini_set('magic_quotes_runtime','off');
if (substr(phpversion(), 0, 3) >= '5.1') {
    @date_default_timezone_set('Europe/Berlin');
}

$cs_logs = array('php_errors' => '', 'errors' => '', 'sql' => '', 'queries' => 0, 'warnings' => 0, 'dir' => 'logs');

session_start();
require('system/core/functions.php');
@set_error_handler("php_error");

require('system/core/servervars.php');
require('system/core/content.php');
require('system/core/tools.php');

  if (!empty($_SESSION)) {

    if($_POST['remove']) {
      $file = $_POST['remove']; 
      cs_unlink('cache',$_SESSION['ajaxuploads'][$file]);
      unset($_SESSION['ajaxuploads'][$file]);
      echo $file;
    } else {
      
      $upload_name = $_POST['upload_name'];
      $file = $_FILES[$upload_name]['tmp_name'];
      $new_name = 'tmp_'.time().strrchr($_FILES[$upload_name]['name'],'.');
      cs_upload('cache', $new_name, $_FILES[$upload_name]['tmp_name'], 0);
      if (!isset($_SESSION['ajaxuploads'])) $_SESSION['ajaxuploads'] = array();
      $_SESSION['ajaxuploads'][$upload_name] = $new_name;
?>
      <script language="javascript" type="text/javascript">
        window.top.window.upload_complete('<?php echo $upload_name; ?>','<?php echo $_FILES[$upload_name]['name']; ?>');
      </script> 
<?php 
    }
  }
?>