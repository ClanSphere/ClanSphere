<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb" colspan="2">{lang:mod} - {lang:center}</td>
	</tr>
	<tr>
		<td class="leftb">{head:body}</td>
		<td class="rightb">{head:pages}</td>
	</tr>
	<tr>
		<td class="leftb">{lang:category}
			<form method="post" name="lanshop_center" action="{url:lanshop_center}">
				{head:cat_dropdown}
				<input type="submit" name="submit" value="{lang:show}" />
			</form>
		</td>
		<td class="rightb"><a href="{url:lanshop_orders}">{lang:orders}</a></td>
	</tr>
</table>
<br />

{head:getmsg}

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb">{sort:name} {lang:name}</td>
		<td class="headb">{sort:price} {lang:price}</td>
		<td class="headb">Warenkorb</td>
	</tr>
	{loop:articles}
	<tr>
		<td class="leftc"><a href="{url:lanshop_view:id={articles:id}}">{articles:name}</a></td>
		<td class="leftc">{articles:price}</td>
		<td class="leftc">
			<form method="post" name="lanshop_center{articles:id}" action="{url:lanshop_center}">
				<input type="text" name="lanshop_orders_value" value="1" maxlength="4" size="4" />
				<input type="hidden" name="lanshop_articles_id" value="{articles:id}" />
				<input type="submit" name="submit" value="{lang:order}" />
			</form>
		</td>
	</tr>
	{stop:articles}
</table>