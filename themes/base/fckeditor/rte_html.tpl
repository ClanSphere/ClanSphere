<div id="{fck:name}div"></div>

<script type="text/javascript" id="ajax_js">
var div = document.getElementById("{fck:name}div");
var oFCKeditor = new FCKeditor("{fck:name}");
oFCKeditor.BasePath = '{fck:path}/mods/fckeditor/';
oFCKeditor.Value = "{fck:value}";
oFCKeditor.Width  = '100%';
oFCKeditor.Height = '{fck:height}px';
oFCKeditor.ToolbarSet = 'Default';
oFCKeditor.Config['AutoDetectLanguage'] = 1;
oFCKeditor.Config['DefaultLanguage'] = 'en';
oFCKeditor.Config['SkinPath'] = oFCKeditor.BasePath + 'editor/skins/{fck:skin}/';
div.innerHTML = oFCKeditor.CreateHtml();
</script>