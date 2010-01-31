<div id="{ckeditor:name}div">
  <textarea name="{ckeditor:name}" id="{ckeditor:name}" style="width: 98%;">{ckeditor:value}</textarea>
</div>

<script type="text/javascript">
CKEDITOR.replace( '{ckeditor:name}',
    {
        basePath : '{ckeditor:path}/mods/ckeditor/',
        config.width : '100%'
        config.height : '{ckeditor:height}px'
        config.defaultLanguage : 'en'
        config.skin : '{ckeditor:skin}'
    });

var div = document.getElementById("{ckeditor:name}div");
</script>