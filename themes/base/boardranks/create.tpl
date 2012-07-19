<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:create}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body}</td>
  </tr>
</table>
<br />

<form method="post" id="boardranks_create" action="{url:boardranks_create}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc">{icon:kate} {lang:min} *</td>
    <td class="leftb"><input type="text" name="boardranks_min" value="{boardranks:min}" maxlength="8" size="5" /> {lang:points}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:rankname} *</td>
    <td class="leftb"><input type="text" name="boardranks_name" value="{boardranks:name}" maxlength="200" size="30" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="submit" name="submit" value="{lang:submit}" />
          </td>
  </tr>
</table>
</form>