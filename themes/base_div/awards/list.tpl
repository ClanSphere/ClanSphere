<div class="container" style="width:{page:width}">
		<div class="headb">{lang:mod}</div>
	<div class="headc clearfix">
		<div class="leftb fl">{head:all}</div>
		<div class="rightb fr">{head:pages}</div>
	</div>
</div>
<br />

<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
	<tr>
		<td class="headb">{sort:date} {lang:date}</td>
		<td class="headb">{sort:event} {lang:event}</td>
		<td class="headb">{sort:game} {lang:game}</td>
		<td class="headb" colspan="2">{sort:place} {lang:place}</td>
	</tr>
	{loop:awards}
	<tr>
		<td class="leftc">{awards:awards_time}</td>
		<td class="leftc"><a href="http://{awards:awards_event_url}">{awards:awards_event}</a></td>
		<td class="leftc"><a href="{url:games_view,id={awards:awards_game_id}}">{awards:awards_game_name}</a></td>
		<td class="leftc">{awards:awards_place}</td>
	</tr>
	{stop:awards}
</table>
