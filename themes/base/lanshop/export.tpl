<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb" colspan="3">{lang:mod} - {lang:head_export}</td>
	</tr>
	<tr>
		<td class="leftb"><a href="{url:lanshop_manage}">{lang:manage}</a></td>
		<td class="centerb"><a href="{url:lanshop_delivery}">{lang:delivery}</a></td>
		<td class="rightb"><a href="{url:lanshop_cashdesk}">{lang:cashdesk}</a></td>
	</tr>
	<tr>
		<td class="leftc" colspan="3">{lang:category}
			<form method="post" name="lanshop_export" action="{url:lanshop_export}">
				{head:cat_dropdown}
				<input type="submit" name="submit" value="{lang:show}" />
			</form>
		</td>
	</tr>
</table>
<br />

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb">{lang:user}</td>
		<td class="headb">{lang:product}</td>
		<td class="headb">{lang:value}</td>
	</tr>
	{loop:orders}
	{if:user}
	<tr>
		<td class="centerb" colspan="3">{orders:user}</td>
	</tr>
	{stop:user}
	<tr>
		<td class="leftc">{orders:users_id}</td>
		<td class="leftc">{orders:article}</td>
		<td class="leftc">{orders:value}</td>
	</tr>
	{stop:orders}
</table>
<br />

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="leftc">{lang:orders_price}</td>
		<td class="leftb">{stats:price}</td>
	</tr>
	<tr>
		<td class="leftc">{lang:orders_value}</td>
		<td class="leftb">{stats:value}</td>
	</tr>
	<tr>
		<td class="leftc">{lang:orders_time}</td>
		<td class="leftb">{stats:time}</td>
	</tr>
</table>