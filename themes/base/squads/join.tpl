<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb">{head:mod} - {lang:head_join}</td>
	</tr>
	<tr>
		<td class="leftc">{head:body}</td>
	</tr>
</table>
<br />

<form method="post" name="squads_join" action="{url:squads_join}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="leftc">{icon:yast_group_add} {lang:label} *</td>
		<td class="leftb">
			{squads:squad_sel}
		</td>
	</tr>
	<tr>
		<td class="leftc">{icon:password} {lang:password} *</td>
		<td class="leftb"><input type="password" name="squads_pwd" value="" maxlength="30" size="30" /></td>
	</tr>
	<tr>
		<td class="leftc">{icon:ksysguard} {lang:options}</td>
		<td class="leftb">
			<input type="submit" name="submit" value="{lang:join}" />
			<input type="reset" name="reset" value="{lang:reset}" />
		</td>
	</tr>
</table>
</form>
