<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

// copy domain and session settings from clansphere servervars
$domain = htmlspecialchars($_SERVER['HTTP_HOST'], ENT_QUOTES);
$domain = (strpos($domain, '.') !== FALSE) ? $domain : '';
session_name('cs' . md5($domain)); 
session_start();

// set content type header to identify this file as javascript
header('Content-type: application/javascript');

$lang = empty($_SESSION['ckeditor_lang']) ? 'en' : $_SESSION['ckeditor_lang'];
$skin = empty($_SESSION['ckeditor_skin']) ? 'kama' : $_SESSION['ckeditor_skin'];
$height = empty($_SESSION['ckeditor_height']) ? '300' : $_SESSION['ckeditor_height'];
$path = empty($_SESSION['ckeditor_path']) ? '' : $_SESSION['ckeditor_path'];
$mode = empty($_SESSION['ckeditor_mode']) ? 0 : $_SESSION['ckeditor_mode'];
$mode_abcode = empty($_SESSION['ckeditor_mode_abcode']) ? 0 : $_SESSION['ckeditor_mode_abcode'];

if(!empty($mode)) {
?>
$(function() {

  var options_html = {  language : '<?php echo $lang; ?>',
                        skin : '<?php echo $skin; ?>',
                        height : '<?php echo $height; ?>',
                        baseHref : '<?php echo $path; ?>/',
                        basePath : '<?php echo $path; ?>/mods/ckeditor/' }

  $(document).bind('csAjaxLoad', function(e,ele) {

    $(ele).find('textarea.rte_html').each(function() {
      var instance = CKEDITOR.instances[this.id];
      if(instance) {
          CKEDITOR.remove(instance);
      } 
    }).ckeditor(function(){}, options_html); 

  });

  $( 'textarea.rte_html' ).ckeditor(function(){}, options_html);

});
<?php
}
if(!empty($mode_abcode)) {
// currently not working are e.g.:
// indent and outdent, bgcolor, strike, size, horizontalrule, justify
?>
$(function() {

  var options_abcode = {  language : '<?php echo $lang; ?>',
                          skin : '<?php echo $skin; ?>',
                          baseHref : '<?php echo $path; ?>/',
                          basePath : '<?php echo $path; ?>/mods/ckeditor/',
                          extraPlugins : 'bbcode',
                          removePlugins : 'bidi,button,dialogadvtab,div,filebrowser,flash,format,forms,horizontalrule,iframe,indent,justify,liststyle,pagebreak,showborders,stylescombo,table,tabletools,templates',
                          toolbar : [
                            ['Source', '-', 'Undo', 'Redo'],
                            ['Find', 'Replace', '-', 'SelectAll', 'RemoveFormat'],
                            ['Maximize', 'ShowBlocks', '-', 'About'],
                            '/',
                            ['Bold', 'Italic', 'Underline', 'TextColor'],
                            ['NumberedList','BulletedList', 'Blockquote'],
                            ['Link', 'Unlink', 'Image']
                          ],
                        }

  $(document).bind('csAjaxLoad', function(e,ele) {

    $(ele).find('textarea.rte_abcode').each(function() {
      var instance = CKEDITOR.instances[this.id];
      if(instance) {
          CKEDITOR.remove(instance);
      } 
    }).ckeditor(function(){}, options_abcode); 

  });

  $( 'textarea.rte_abcode' ).ckeditor(function(){}, options_abcode);

});
<?php
}
?>