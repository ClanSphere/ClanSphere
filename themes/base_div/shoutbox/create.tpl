<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:submit}</div>
    <div class="leftc">{lang:body}</div>
</div>
<br />
<form method="post" name="shoutbox_add" action="{form:url}">
  <table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:personal} {lang:nick} *</td>
      <td class="leftb"><input type="text" name="sh_nick" value="{form:name}"  />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:kate} {lang:message} *</td>
      <td class="leftb"><textarea name="sh_text2" cols="10" rows="5" id="sh_text2" >{form:message}</textarea>
      </td>
    </tr>
	{form:show}
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="hidden" name="uri" value="{form:url}" />
        <input type="submit" name="submit" value="{lang:submit}" />
        <input type="reset" name="reset" value="{lang:reset}" />
      </td>
    </tr>
  </table>
</form>
