<form method="post" id="notifymods_manage" action="{url:notifymods_manage}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb" colspan="3">{lang:mod_name} - {lang:manage}</td>
	</tr>
	<tr>
		<td class="leftb">{icon:editpaste} {head:new}</td>
		<td class="leftb">{icon:contents} {lang:total}: {head:count}</td>
		<td class="rightb">{head:pages}</td>
	</tr>
</table>
</form>
<br />
{head:getmsg}

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb" colspan="2">{lang:mod_name} - {lang:caption}</td>
	</tr>
	<tr>
		<td class="leftb">Gbook</td>
		<td class="leftb">{lang:gbook}</td>
	</tr>
	<tr>
		<td class="leftb">Join</td>
		<td class="leftb">{lang:joinus}</td>
	</tr>
	<tr>
		<td class="leftb">Fight</td>
		<td class="leftb">{lang:fightus}</td>
	</tr>
	<tr>
		<td class="leftb">Down</td>
		<td class="leftb">{lang:files}</td>
	</tr>
</table>
<br />
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb">{sort:users_nick} {lang:user}</td>
		<td class="headb">Gbook</td>
		<td class="headb">Join</td>
		<td class="headb">Fight</td>
		<td class="headb">Down</td>
		<td class="headb" colspan="2">{lang:options}</td>
	</tr>
	{loop:nm}
	<tr>
		<td class="leftc">{nm:notifymods_user}</td>
		<td class="leftc">{nm:notifymods_gbook}</td>
		<td class="leftc">{nm:notifymods_joinus}</td>
		<td class="leftc">{nm:notifymods_fightus}</td>
		<td class="leftc">{nm:notifymods_files}</td>
		<td class="leftc"><a href="{nm:url_edit}" title="{lang:edit}">{icon:edit}</a></td>
		<td class="leftc"><a href="{nm:url_remove}" title="{lang:remove}">{icon:editdelete}</a></td>
	</tr>
	{stop:nm}
</table>
