<textarea name="{ckeditor:name}" id="{ckeditor:name}" rows="10" cols="50" style="width: 98%;">{ckeditor:value}</textarea>

<script type="text/javascript">
CKEDITOR.replace( '{ckeditor:name}',
  {
    baseHref         : '{ckeditor:path}/',
    basePath         : '{ckeditor:path}/mods/ckeditor/',
    defaultLanguage  : 'en',
    height           : '{ckeditor:height}',
    resize_minHeight : '{ckeditor:height}',
    resize_minWidth  : '450',
    skin             : '{ckeditor:skin}',
    width            : '100%'
  });
</script>