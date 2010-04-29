<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb">{lang:mod_name} - {lang:edit}</td>
	</tr>
	<tr>
		<td class="leftb">{head:body}</td>
	</tr>
</table>
<br />

<form method="post" id="notifymods_joinus" action="{url:notifymods_edit}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="leftc">{icon:personal} {lang:user} *</td>
		<td class="leftb">
			{nm:user}
		</td>
	</tr>
	<tr>
		<td class="leftc">{icon:access} {lang:access}</td><td class="leftb">
			<input type="checkbox" name="notifymods_gbook" value="1" {nm:notifymods_gbook} />{lang:gbook}<br />
			<input type="checkbox" name="notifymods_joinus" value="1" {nm:notifymods_joinus} />{lang:joinus}<br />
			<input type="checkbox" name="notifymods_fightus" value="1" {nm:notifymods_fightus} />{lang:fightus}<br />
			<input type="checkbox" name="notifymods_files" value="1" {nm:notifymods_files} />{lang:files}<br />
			<input type="checkbox" name="notifymods_board" value="1" {nm:notifymods_board} />{lang:board}
		</td>
	</tr>
	<tr>
		<td class="leftc">{icon:ksysguard} {lang:options}</td>
		<td class="leftb">
			<input type="hidden" name="id" value="{nm:id}" />
			<input type="submit" name="submit" value="{lang:edit}" />
			<input type="submit" name="cancel" value="{lang:cancel}" />
					</td>
	</tr>
</table>
</form>
