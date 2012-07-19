<table style="width:100%">
  <tr>
    <td class="leftc">{lang:line}</td>
    <td class="leftc">{lang:file}</td>
    <td class="leftc">{lang:error_type}</td>
    <td class="leftc">{lang:text}</td>
    <td class="leftc">{lang:old_value}</td>
  </tr>
  {loop:errors}
  <tr>
    <td class="leftb">{errors:line}</td>
    <td class="leftb">{errors:file}</td>
    <td class="leftb">{errors:type}</td>
    <td class="leftb">{errors:text}</td>
    <td class="leftb">{errors:old_value}</td>
  </tr>
  {stop:errors}
</table>
<div class="centerb" style="margin:1px 2px 2px 2px;"><a href="javascript:cs_display('{info:lang}_{info:mod}')">{lang:show_fixed}</a> - <a href="javascript:$('#mod_{info:lang}_{info:mod}').load('{page:path}mods/clansphere/lang_modvalidate.php?language={info:lang}&module={info:mod}&fix');">{lang:save_fixed}</a></div>
<div id="{info:lang}_{info:mod}" class="leftb" style="margin:1px 2px 0px 2px; display:none;">{file:fixed}</div>
