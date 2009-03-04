<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="1">
  <tr>
    <td class="headb" colspan="2">{lang:mod} - {lang:create}</td>
  </tr>
  <tr>
    <td class="leftb">{medals:message}</td>
  </tr>
</table>
<br />

<form method="post" action="{url:medals_create}" name="medals_create" enctype="multipart/form-data">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="1">
  <tr>
    <td class="leftc">{icon:kedit} {lang:name} *</td>
    <td class="leftb"><input type="text" value="{medals:medals_name}" name="medals_name" class="form" maxlength="150" size="30" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:download} {lang:picture}</td>
    <td class="leftb"><input type="file" name="medals_picture" class="form" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:description}</td>
    <td class="leftb">{form:abcode}<br /><textarea name="medals_text" id="medals_text" class="form" rows="15">{medals:medals_text}</textarea></td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="submit" value="{lang:create}" name="submit" class="form" />
      <input type="reset" value="{lang:reset}" name="reset" class="form" />
     </td>
  </tr>
</table>
</form>