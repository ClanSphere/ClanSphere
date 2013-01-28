CKEDITOR.editorConfig = function( config )
{
  config.defaultLanguage  = 'en';
  config.resize_minHeight = '250';
  config.resize_minWidth  = '450';
  config.width            = '100%';

  config.enterMode = CKEDITOR.ENTER_P;
  config.shiftEnterMode = CKEDITOR.ENTER_BR;

  var _fmbrowser = CKEDITOR.basePath + 'filemanager/browser/default/browser.html?Mode=abcode&';
  var _connector = CKEDITOR.basePath + 'filemanager/connectors/php/connector.php';

  config.filebrowserBrowseUrl      = _fmbrowser + 'Connector=' + encodeURIComponent( _connector );
  config.filebrowserImageBrowseUrl = _fmbrowser + 'Type=Image&Connector=' + encodeURIComponent( _connector );
  config.filebrowserFlashBrowseUrl = _fmbrowser + 'Type=Flash&Connector=' + encodeURIComponent( _connector );
};