<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb" colspan="3">{lang:mod} - {lang:head_delivery}</td>
	</tr>
	<tr>
		<td class="leftb"><a href="{url:lanshop_manage}">{lang:manage}</a></td>
		<td class="centerb"><a href="{url:lanshop_export}">{lang:export}</a></td>
		<td class="rightb"><a href="{url:lanshop_cashdesk}">{lang:cashdesk}</a></td>
	</tr>
</table>
<br />

{head:getmsg}

<form method="post" name="lanshop_delivery" action="{url:lanshop_delivery}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="leftc">{icon:folder_yellow} {lang:category}</td>
		<td class="leftb">
			{ls:cat_sel}
		</td>
	</tr>
	<tr>
		<td class="leftc">{icon:today} {lang:since}</td>
		<td class="leftb">
			{ls:date_sel}
		</td>
	</tr>
	<tr>
		<td class="leftc">{icon:ksysguard} Optionen</td>
		<td class="leftb"><input type="submit" name="submit" value="{lang:submit}" /></td>
	</tr>
</table>
</form>