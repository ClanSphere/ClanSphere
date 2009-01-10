<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb" colspan="3">{lang:mod} - {lang:head_center}</td>
	</tr>
	<tr>
		<td class="leftb">{icon:editpaste} <a href="{url:computers_create}" >{lang:new_computer}</a></td>
		<td class="leftb">{icon:contents} {lang:total}: {head:count}</td>
		<td class="rightb">{head:pages}</td>
	</tr>
</table>
<br />

{head:getmsg}

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb">{sort:name} Name</td>
		<td class="headb">{sort:since} Erstellungsdatum</td>
		<td class="headb" colspan="3">{lang:options}</td>
	</tr>
	{loop:com}
	<tr>
		<td class="leftc"><a href="{com:url_view}" >{com:name}</a></td>
		<td class="rightc">{com:since}</td>
		<td class="leftc"><a href="{com:url_picture}" title="{lang:picture}" >{icon:image}</a></td>
		<td class="leftc"><a href="{com:url_edit}" title="{lang:edit}" >{icon:edit}</a></td>
		<td class="leftc"><a href="{com:url_remove}" title="{lang:remove}" >{icon:editdelete}</a></td>
	</tr>
	{stop:com}
</table>