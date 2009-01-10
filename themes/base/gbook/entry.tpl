<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
	<td class="headb">{head:mod} - {head:action}</td>
  </tr>
  <tr>
	<td class="leftb">{body:create} {error:icon} {error:error} {error:message}</td>
  </tr>
</table>
<br />
{tpl:preview}
<form method="post" name="entry" action="{url:gbook_entry}">
<input type="hidden" name="gbook_nick" value="{data:nick}" />
<input type="hidden" name="gbook_email" value="{data:email}" />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  {tpl:extension}
  <tr>
    <td class="leftc">{icon:kate} {lang:text} *<br /><br /> {abcode:smileys}</td>
    <td class="leftb">
		{abcode:features} 
		<textarea name="gbook_text" cols="50" rows="15" id="gbook_text"  style="width: 98%;">{data:gbook_text}</textarea> 
	</td>
  </tr>
  {tpl:captcha}
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
		<input type="hidden" name="id" value="{data:id}" />
		<input type="submit" name="submit" value="{lang:submit}" />
		<input type="submit" name="preview" value="{lang:preview}" />
        <input type="reset" name="reset" value="{lang:reset}" />
	</td>
  </tr>
</table>
</form>