<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb" colspan="2">{lang:mod} - {lang:akt_users_month}</td>
	</tr>
	<tr>
		<td class="leftb">{lang:user_cash_month}</td>
		<td class="centerb">{icon:business}<a href="{url:cash_manage}">{lang:back}</a></td>
	</tr>
</table>
<br />

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb" colspan="5">{lang:user_cash_ok}</td>
	</tr>
	{loop:cash}
	<tr>
		<td class="leftb">{cash:user}</td>
		<td class="leftb"><a href="{url:cash_view:id={cash:id}}">{cash:for}</a></td>
		<td class="leftb">{cash:money} {lang:euro}</td>
		<td class="leftb">{cash:for}</td>
		<td class="leftb">{cash:date}</td>
	</tr>
	{stop:cash}
</table>
<br />