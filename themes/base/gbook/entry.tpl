<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
	<td class="headb">{lang:mod_name} - {lang:submit}</td>
  </tr>
  <tr>
	<td class="leftb">{head:body}</td>
  </tr>
</table>
<br />

{tpl:preview}

<form method="post" name="entry" action="{url:gbook_entry}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  {tpl:extension}
  <tr>
    <td class="leftb">{icon:kate} {lang:text} *<br /><br /> {abcode:smileys}</td>
    <td class="leftc">
		{abcode:features} 
		<textarea name="gbook_text" cols="50" rows="15" id="gbook_text"  style="width: 98%;">{gbook:gbook_text}</textarea> 
	</td>
  </tr>
  {tpl:captcha}
  <tr>
    <td class="leftb">{icon:ksysguard} {lang:options}</td>
    <td class="leftc">
		<input type="hidden" name="id" value="{gbook:id}" />
		<input type="hidden" name="from" value="{gbook:from}" />
		<input type="submit" name="submit" value="{lang:submit}" />
		<input type="submit" name="preview" value="{lang:preview}" />
        <input type="reset" name="reset" value="{lang:reset}" />
	</td>
  </tr>
</table>
</form>