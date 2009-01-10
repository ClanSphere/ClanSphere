<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
	<tr>
		<td class="headb" colspan="3">{lang:mod}</td>
	</tr>
	<tr>
		<td class="leftb" style="width: 33%;">{icon:editpaste} <a href="{url:awards_create}">{lang:new_award}</a></td>
		<td class="leftb" style="width: 33%;">{icon:contents} {lang:total}: {count:all}</td>
		<td class="rightb" style="width: 33%;">{head:pages}</td>
	</tr>
</table>
<br />
{head:message}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
	<tr>
		<td class="headb">{sort:date} {lang:date}</td>
		<td class="headb">{sort:event} {lang:event}</td>
		<td class="headb">{sort:game} {lang:game}</td>
		<td class="headb">{sort:place} {lang:place}</td>
		<td class="headb" colspan="2">{lang:options}</td>
	</tr>
	{loop:awards}
	<tr>
		<td class="leftc">{awards:awards_time}</td>
		<td class="leftc"><a href="http://{awards:awards_event_url}">{awards:awards_event}</a></td>
		<td class="leftc"><a href="{awards:games_url}">{awards:awards_game_name}</a></td>
		<td class="leftc">{awards:awards_place}</td>
		<td class="centerc"><a href="{awards:edit_url}">{icon:edit}</a></td>
		<td class="centerc"> <a href="{awards:remove_url}">{icon:editdelete}</a></td>
	</tr>
	{stop:awards}
</table>
