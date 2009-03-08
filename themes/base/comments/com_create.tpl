<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb">{head:mod} - {lang:head_com_create}</td>
	</tr>
	<tr>
		<td class="leftb">{head:body}</td>
	</tr>
</table>
<br />

{if:preview}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="leftb" style="width:150px">
			{if:guest_prev}
			{prev:guestnick}<br />
			<br />
			{lang:guest}<br />
			<br /><br />
			{stop:guest_prev}
		
			{if:user_prev}
			{prev:flag} {prev:user}<br />
			<br />
			{prev:status} {prev:laston}<br />
			<br />
			{lang:place}: {prev:place}<br />
			{lang:posts}: {prev:posts}
			{stop:user_prev}
		</td>
		<td class="leftb">
			# {prev:count_com} - {prev:date}
			<hr style="width:100%" noshade="noshade" /><br />
			{prev:text}
		</td>
	</tr>
</table>
<br /><br />
{stop:preview}

<form method="post" name="{com:form_name}" action="{com:form_url}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	{if:guest}
	<tr>
		<td class="leftc">{icon:personal} {lang:guestnick} *</td>
		<td class="leftb"><input type="text" name="comments_guestnick" value="{com:guestnick}" maxlength="40" size="40" /></td>
	</tr>
	{stop:guest}
	<tr>
		<td class="leftc">{icon:kate} {lang:text} *<br /><br />
			{com:smileys}
		</td>
		<td class="leftb">
			{com:abcode}
			<textarea name="comments_text" cols="50" rows="20" id="comments_text" class="cs_text_abcode">{com:text}</textarea>
		</td>
	</tr>
	{if:captcha}
	<tr>
		<td class="leftc">{icon:lockoverlay} {lang:security_code} *</td>
		<td class="leftb">
			<img src="mods/captcha/generate.php" alt="" />
			<input type="text" name="captcha" value="" size="8" maxlength="8" />
		</td>
	</tr>
	{stop:captcha}
	<tr>
		<td class="leftc">{icon:ksysguard} {lang:options}</td>
		<td class="leftb">
			<input type="hidden" name="fid" value="{com:fid}" />
			<input type="submit" name="submit" value="{lang:create}" />
			<input type="submit" name="preview" value="{lang:preview}" />
			<input type="reset" name="reset" value="{lang:reset}" />
		</td>
	</tr>
</table>
</form>
<br />
