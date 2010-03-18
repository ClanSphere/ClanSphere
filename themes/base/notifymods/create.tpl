<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb">{lang:mod_name} - {lang:head_create}</td>
	</tr>
	<tr>
		<td class="leftb">{head:body}</td>
	</tr>
</table>
<br />

<form method="post" id="notifymods_create" action="{url:notifymods_create}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="leftc">{icon:personal} {lang:user} *</td>
  <td class="leftb">
        <input type="text" name="users_nick" id="users_nick" value="{users:nick}" onkeyup="cs_ajax_getcontent('{page:path}mods/ajax/search_users.php?term=' + document.getElementById('users_nick').value, 'search_users_result')" maxlength="80" size="40" /><br />
        <div id="search_users_result"></div>
  </td>
	</tr>
	<tr>
		<td class="leftc">{icon:access} {lang:access}</td><td class="leftb">
			<input type="checkbox" name="notifymods_gbook" value="1" {nm:notifymods_gbook} />{lang:gbook}<br />
			<input type="checkbox" name="notifymods_joinus" value="1" {nm:notifymods_joinus} />{lang:joinus}<br />
			<input type="checkbox" name="notifymods_fightus" value="1" {nm:notifymods_fightus} />{lang:fightus}<br />
			<input type="checkbox" name="notifymods_files" value="1" {nm:notifymods_files} />{lang:files}
		</td>
	</tr>
	<tr>
		<td class="leftc">{icon:ksysguard} {lang:options}</td>
		<td class="leftb">
			<input type="submit" name="submit" value="{lang:create}" />
					</td>
	</tr>
</table>
</form>
