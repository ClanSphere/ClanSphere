<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:submit}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:body}</td>
  </tr>
</table>
<br />
<form method="post" id="shoutbox_add" action="{form:url}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:personal} {lang:nick} *</td>
      <td class="leftb"><input type="text" name="sh_nick" value="{form:name}" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:kate} {lang:message} *</td>
      <td class="leftb"><textarea class="rte_abcode" name="sh_text2" cols="10" rows="5" id="sh_text2">{form:message}</textarea>
      </td>
    </tr>
  {form:show}
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="hidden" name="uri" value="{form:url}" />
        <input type="submit" name="submit" value="{lang:submit}" />
              </td>
    </tr>
  </table>
</form>
