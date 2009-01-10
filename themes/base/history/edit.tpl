<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb">{lang:mod} - {lang:edit}</td>
	</tr>
	<tr>
		<td class="leftb">{head:body}</td>
	</tr>
</table>
<br />

{if:preview}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="bottom">{preview:date} - {preview:user}</td>
	</tr>
	<tr>
		<td class="leftc">
			{preview:text}
		</td>
	</tr>
</table>
<br />
{stop:preview}

<form method="post" name="history_edit" action="{url:history_edit}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	{if:no_fck}
	<tr>
		<td class="leftc">{icon:kate} {lang:text} *<br />
			<br />
			{history:abcode_smileys}</td>
		<td class="leftb">
			{history:abcode_features}
			<textarea name="history_text" cols="50" rows="30" id="history_text" class="form">{history:text}</textarea>
		</td>
	</tr>
	{stop:no_fck}
    {if:fck}
	<tr>
		<td class="leftc" colspan="2">{icon:kate} {lang:text} *<br />
			<br />
			{history:fck_editor}
		</td>
	</tr>
	{stop:fck}
	<tr>
		<td class="leftc">{lang:more}</td>
		<td class="leftb"><input type="checkbox" name="history_newtime" value="1" />{lang:new_date}</td>
	<tr>
		<td class="leftc">{icon:ksysguard} {lang:options}</td>
		<td class="leftb">
			<input type="hidden" name="id" value="{history:id}" />
			<input type="submit" name="submit" value="{lang:edit}" />
			<input type="submit" name="preview" value="{lang:preview}" />
			<input type="reset" name="reset" value="{lang:reset}" />
		</td>
	</tr>
</table>
</form>
