<form method="post" name="comments_remove" action="{url:comments_remove}">
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
	<tr>
		<td class="headb">{lang:mod} - {lang:remove}</td>
	</tr>
	<tr>
		<td class="leftb">{head:body}</td>
	</tr>
	<tr>
		<td class="centerc">
			<input type="hidden" name="id" value="{com:id}" />
			<input type="submit" name="agree" value="{lang:confirm}" />
			<input type="submit" name="cancel" value="{lang:cancel}" />
		</td>
	</tr>
</table>
</form>
