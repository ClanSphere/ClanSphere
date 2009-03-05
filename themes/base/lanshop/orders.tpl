<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb" colspan="2">{lang:mod} - {lang:head_orders}</td>
	</tr>
	<tr>
		<td class="leftb">{head:body}</td>
		<td class="rightb">{head:pages}</td>
	</tr>
	<tr>
		<td class="leftb">{lang:category}
			<form method="post" name="lanshop_orders" action="{url:lanshop_orders}">
				{head:cat_dropdown}
				<input type="submit" name="submit" value="{lang:show}" />
			</form>
		</td>
		<td class="rightb"><a href="{url:lanshop_center}">{lang:center}</a></td>
	</tr>
</table>
<br />

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb">{sort:name} {lang:name}</td>
		<td class="headb">{lang:status}</td>
		<td class="headb" colspan="2">{lang:basket}</td>
		<td class="headb">{sort:price} {lang:money}</td>
	</tr>
	{loop:orders}
	<tr>
		<td class="leftc"><a href="/debug/lanshop/view/id/1">{orders:articles_name}</a></td>
		<td class="leftc">{orders:status}</td>
		<td class="leftc">{orders:value}</td>
		<td class="leftc"><a href="{url:lanshop_orders:remove_id={orders:id}}" title="{lang:remove}">{icon:editdelete}</a></td>
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