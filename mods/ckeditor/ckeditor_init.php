<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

header('Content-type: application/javascript');

// copy domain and session settings from clansphere servervars
$domain = htmlspecialchars($_SERVER['HTTP_HOST'], ENT_QUOTES);
$domain = (strpos($domain, '.') !== FALSE) ? $domain : '';
session_name('cs' . md5($domain)); 
session_start();

$lang = empty($_SESSION['ckeditor_lang']) ? 'en' : $_SESSION['ckeditor_lang'];
$skin = empty($_SESSION['ckeditor_skin']) ? 'kama' : $_SESSION['ckeditor_skin'];
$height = empty($_SESSION['ckeditor_height']) ? '300' : $_SESSION['ckeditor_height'];
$path = empty($_SESSION['ckeditor_path']) ? '' : $_SESSION['ckeditor_path'];

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

  var options_abcode = {  language : '<?php echo $lang; ?>',
                          skin : '<?php echo $skin; ?>',
                          baseHref : '<?php echo $path; ?>/',
                          basePath : '<?php echo $path; ?>/mods/ckeditor/',
                          extraPlugins : 'bbcode',
                          removePlugins : 'bidi,button,dialogadvtab,div,filebrowser,flash,format,forms,horizontalrule,iframe,indent,justify,liststyle,pagebreak,showborders,stylescombo,table,tabletools,templates',
                          toolbar : [
                            ['Source', '-', 'Save','NewPage','-','Undo','Redo'],
                            ['Find','Replace','-','SelectAll','RemoveFormat'],
                            ['Link', 'Unlink', 'Image'],
                            '/',
                            ['FontSize', 'Bold', 'Italic','Underline'],
                            ['NumberedList','BulletedList','-','Blockquote'],
                            ['TextColor', '-','SpecialChar', '-', 'Maximize']
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