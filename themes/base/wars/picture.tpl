<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
	<tr>
		<td class="headb" colspan="2">{lang:mod} - {lang:pictures}</td>
	</tr>
	<tr>
		<td class="leftb">{head:body}</td>
		<td class="rightb"><a href="{url:wars_manage}" >{lang:manage}</a></td>
	</tr>
</table>
<br />

{head:getmsg}

<form method="post" name="wars_picture" action="{url:wars_picture}" enctype="multipart/form-data">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
	<tr>
		<td class="leftc" style="width:140px">{icon:download} {lang:upload}</td>
		<td class="leftb">
			<input type="file" name="picture" value="" /><br />
			<br />
			{picup:clip}
		</td>
	</tr>
	<tr>
		<td class="leftc">{icon:ksysguard} {lang:options}</td>
		<td class="leftb">
			<input type="hidden" name="id" value="{wars:id}" />
			<input type="submit" name="submit" value="{lang:save}"/>
		</td>
	</tr>
</table>
</form>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
	<tr>
		<td class="leftc" style="width:140px">{icon:images} {lang:current}</td>
		<td class="leftb">
			{loop:pictures}
			{pictures:view_link}{pictures:remove_link}<br /><br />
			{stop:pictures}
		</td>
	</tr>
</table>