<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="1">
	<tr>
		<td class="headb">{lang:mod} - {lang:remove}</td>
	</tr>
	<tr>
		<td class="leftb">{head:body}</td>
	</tr>
</table>
<br />

{if:own}
<form method="post" name="computers_remove" action="{url:computers_remove}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="1">
	<tr>
		<td class="centerc">
			<input type="hidden" name="id" value="{com:id}" />
			<input type="hidden" name="referer" value="{com:referer}" />
			<input type="submit" name="agree" value="{lang:confirm}" />
			<input type="submit" name="cancel" value="{lang:cancel}" />
		</td>
	</tr>
</table>
</form>
{stop:own}