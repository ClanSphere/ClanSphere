<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
	<tr>
		<td class="headb" colspan="2">{lang:mod} - {lang:manage}</td>
	</tr>
	<tr>
		<td class="leftb">{icon:contents} {lang:total}: {head:count}</td>
		<td class="leftb">{head:pages}</td>
	</tr>
	<tr>
		<td class="leftb" colspan="2">{lang:module}
			<form method="post" id="comments_manage" action="{url:comments_manage}">
				{head:mod_dropdown}
				<input type="submit" name="submit" value="{lang:show}" />
			</form>
		</td>
	</tr>
</table>
<br />
{head:getmsg}

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
	<tr>
		<td class="headb">{sort:comments_id} {lang:id}</td>
		<td class="headb">{sort:users_id} {lang:user}</td>
		<td class="headb">{sort:comments_time} {lang:date}</td>
		<td class="headb" colspan="3">{lang:options}</td>
	</tr>
	{loop:com}
	<tr>
		<td class="leftb">{com:fid}</td>
		<td class="leftb">{com:user}</td>
		<td class="leftb">{com:date}</td>
		<td class="leftb"><a href="{com:url_view}" title="{lang:details}">{icon:view_text}</a></td>
		<td class="leftb"><a href="{com:url_edit}" title="{lang:edit}">{icon:kedit}</a></td>
		<td class="leftb"><a href="{com:url_remove}" title="{lang:remove}">{icon:editdelete}</a></td>
	</tr>
	{stop:com}
</table>