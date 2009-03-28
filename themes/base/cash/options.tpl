<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb">{lang:mod_name} - {lang:options}</td>
	</tr>
	<tr>
		<td class="leftb">{lang:body_info}</td>
	</tr>
</table>
<br />

<form method="post" id="cash_options" action="{url:cash_options}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb" colspan="2">{lang:options}</td>
	</tr>
	<tr>
		<td class="leftc" style="width:155px">{icon:money} {lang:month_out}</td>
		<td class="leftb"><input type="text" name="month_out" value="{op:month_out}" maxlength="10" size="7" /> {lang:euro}</td>
	</tr>
	<tr>
		<td class="leftc">{icon:ksysguard} {lang:options}</td>
		<td class="leftb">
			<input type="submit" name="submit" value="{lang:edit}" />
			<input type="reset" name="reset" value="{lang:reset}" />
		</td>
	</tr>
</table>
</form>