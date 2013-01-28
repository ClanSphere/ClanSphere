CKEDITOR.editorConfig = function( config )
{
  config.defaultLanguage  = 'en';
  config.resize_minHeight = '250';
  config.resize_minWidth  = '450';
  config.width            = '100%';

  config.enterMode = CKEDITOR.ENTER_P;
  config.shiftEnterMode = CKEDITOR.ENTER_BR;

  var _connector = CKEDITOR.basePath + 'filemanager/connectors/php/connector.php';

  config.filebrowserBrowseUrl      = CKEDITOR.basePath + 'filemanager/browser/default/browser.html?Connector=' + encodeURIComponent( _connector );
  config.filebrowserImageBrowseUrl = CKEDITOR.basePath + 'filemanager/browser/default/browser.html?Type=Image&Connector=' + encodeURIComponent( _connector );
  config.filebrowserFlashBrowseUrl = CKEDITOR.basePath + 'filemanager/browser/default/browser.html?Type=Flash&Connector=' + encodeURIComponent( _connector );

  /* TODO: Make the quick upload work
  config.filebrowserUploadUrl      = CKEDITOR.basePath + 'filemanager/connectors/php/upload.php';
  config.filebrowserImageUploadUrl = CKEDITOR.basePath + 'filemanager/connectors/php/upload.php?Type=Image';
  config.filebrowserFlashUploadUrl = CKEDITOR.basePath + 'filemanager/connectors/php/upload.php?Type=Flash';
  */
};