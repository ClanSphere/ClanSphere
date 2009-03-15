<table class="forum" cellpadding="0" cellspacing="{page:cellspacig}" style="width:{page:width}">
	<tr>
		<td class="headb" colspan="5">{lang:mod} - {lang:folders}</td>
	</tr>
	{manage:head}
	<tr>
		<td class="leftb" colspan="2">{icon:editpaste} <a href="{url:gallery_folders_create}">{lang:new_folder}</a></td>
		<td class="leftb" colspan="2">{icon:contents} {lang:total}: {head:count}</td>
		<td class="rightb" colspan="1">{head:pages}</td>
	</tr>
</table>
<br />

{head:getmsg}

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
		<td class="headb">{sort:name} {lang:folders}</td>
		<td class="headb" width="50">{lang:options}</td>
	</tr>
	{show:folders_box}
</table>