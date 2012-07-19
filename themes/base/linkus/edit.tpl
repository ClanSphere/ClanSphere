<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:edit}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body}</td>
  </tr>
</table>
<br />

<form method="post" id="linkus_edit" action="{url:linkus_edit}" enctype="multipart/form-data">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc">{icon:image} {lang:cur_pic}</td>
    <td class="leftb">{linkus:banner}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:kivio} {lang:mass}</td>
    <td class="leftb">{linkus:mass}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:wp} {lang:name} *</td>
    <td class="leftb"><input type="text" name="linkus_name" value="{linkus:linkus_name}" maxlength="200" size="50" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:gohome} {lang:url} *</td>
    <td class="leftb">http://<input type="text" name="linkus_url" value="{linkus:linkus_url}" maxlength="200" size="50" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:images} {lang:icon}</td>
    <td class="leftb">
      <input type="file" name="symbol" value="" /><br />
      <br />
      {linkus:picup_clip}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="hidden" name="id" value="{linkus:id}" />
      <input type="submit" name="submit" value="{lang:edit}" />
          </td>
  </tr>
</table>
</form>