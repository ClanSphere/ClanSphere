<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb" colspan="3">{lang:mod} - {lang:cashdesk}</td>
	</tr>
	<tr>
		<td class="leftb"><a href="{url:lanshop_manage}">{lang:manage}</a></td>
		<td class="centerb"><a href="{url:lanshop_delivery}">{lang:delivery}</a></td>
		<td class="rightb"><a href="{url:lanshop_export}">{lang:export}</a></td>
	</tr>
</table>
<br />

<form method="post" name="lanshop_cashdesk" action="{url:lanshop_cashdesk}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="leftc">{lang:user}</td>
		<td class="leftc">{lang:category}</td>
		<td class="leftc">{lang:status}</td>
		<td class="leftc">{lang:options}</td>
	</tr>
	<tr>
		<td class="leftb">
			{head:users_dropdown}
		</td>
		<td class="leftb">
			{head:cat_dropdown}
		</td>
		<td class="leftb">
			{head:status_dropdown}
		</td>
		<td class="leftb">
			<input type="submit" name="submit" value="{lang:show}" />
		</td>
	</tr>
</table>
</form>
<br />

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb">{lang:user}</td>
		<td class="headb">{lang:name}</td>
		<td class="headb" colspan="2">{lang:status}</td>
		<td class="headb" colspan="2">{lang:basket}</td>
		<td class="headb">{lang:money}</td>
	</tr>
	{loop:orders}
	<tr>
		<td class="leftc">{orders:user}</td>
		<td class="leftc">{orders:article}</td>
		<td class="leftc">{orders:status}</td>
		<td class="leftc">{orders:pay_id}</td>
		<td class="leftc">{orders:value}</td>
		<td class="leftc">{orders:remove_id}</td>
		<td class="leftc">{orders:cost}</td>
	</tr>
	{stop:orders}
</table>
<br />

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="centerb">{bottom:body}</td>
	</tr>
</table>