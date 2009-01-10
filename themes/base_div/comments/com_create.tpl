<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="1">
	<tr>
		<td class="headb">{head:mod} - {lang:head_com_create}</td>
	</tr>
	<tr>
		<td class="leftb">{head:body}</td>
	</tr>
</table>
<br />

{if:preview}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="1">
	<tr>
		<td class="leftb" style="width:150px">
			{prev:flag} {prev:user}<br />
			<br />
			{prev:status} {prev:laston}<br />
			<br />
			{lang:place}: {prev:place}<br />
			{lang:posts}: {prev:posts}
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
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="1">
	<tr>
		<td class="leftc">{icon:kate} {lang:text} *<br /><br />
			{com:smileys}
		</td>
		<td class="leftb">
			{com:abcode}
			<textarea name="comments_text" cols="50" rows="20" id="comments_text">{com:text}</textarea>
		</td>
	</tr>
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
