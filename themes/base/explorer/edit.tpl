<table class="forum" style="width: {page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:explorer} - {lang:edit}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:edit_file}</td>
  </tr>
</table>
<br />

<form method="post" name="upload_edit" action="{url:explorer_edit}">
<table class="forum" style="width: {page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc" style="width: 20%">
    <div style="display: none;" id="break"><br /></div>
    <div style="display: none;" id="parameters"></div>
    {icon:kate} {lang:content}</td>
    
    <td class="leftb" style="width: 80%">
    {if:phpfile}
    <input type="button" name="tab" value="TAB" accesskey="t" onclick="javascript:abc_insert('\t','','data_content','')" class="form" />
    {abcode:tools}
    {abcode:html1} <br />
    {abcode:sql}
    {abcode:js}
    {abcode:html2} <br />{stop:phpfile}
    <textarea name="data_content" cols="50" rows="35" id="data_content" class="form">{var:content}</textarea>
   </td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="hidden" name="file" value="{var:source}" />
      <input type="submit" name="submit" value="{lang:edit}" class="form" />
      <input type="reset" name="reset" value="{lang:reset}" class="form" />
     </td>
  </tr>
</table>
</form>
