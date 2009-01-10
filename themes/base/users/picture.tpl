<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb">{lang:mod_name} - {lang:picture}</td>
	</tr>
	<tr>
		<td class="leftb">{head:body}</td>
	</tr>
</table>
<br />

<form method="post" name="users_picture" action="{url:users_picture}" enctype="multipart/form-data">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="leftc">{icon:images} {lang:current}</td>
		<td class="leftb">{users:current_pic}</td>
	</tr>
	<tr>
		<td class="leftc">{icon:download} {lang:upload}</td>
		<td class="leftb">
			<input type="file" name="picture" value="" /><br />
			<br />
			{users:picup_clip}
		</td>
	</tr>
	{if:extended}
	<tr>
		<td class="leftc">{icon:configure} {lang:extended}</td>
		<td class="leftb"><input type="checkbox" name="delete" value="1" />{lang:remove}</td>
	</tr>
	{stop:extended}
	<tr>
		<td class="leftc">{icon:ksysguard} {lang:options}</td>
		<td class="leftb">
			<input type="submit" name="submit" value="{lang:save}" />
		</td>
	</tr>
</table>
</form>