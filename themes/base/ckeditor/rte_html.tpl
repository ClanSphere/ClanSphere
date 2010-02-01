<textarea name="{ckeditor:name}" id="{ckeditor:name}" rows="10" cols="50" style="width: 98%;">{ckeditor:value}</textarea>

<script type="text/javascript">
CKEDITOR.replace( '{ckeditor:name}',
    {
        basePath : '{ckeditor:path}/mods/ckeditor/',
        width : '100%',
        height : '{ckeditor:height}px',
        defaultLanguage : 'en',
        skin : '{ckeditor:skin}'
    });
</script>