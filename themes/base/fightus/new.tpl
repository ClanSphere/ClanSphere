<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
	<tr>
		<td class="headb">{lang:mod} - {lang:head_new}</td>
	</tr>
	<tr>
		<td class="leftc">{head:body}</td>
	</tr>
</table>
<br />

{head:getmsg}

<form method="post" name="fightus_new" action="{url:fightus_new}">

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
	<tr>
		<td class="leftc">{icon:personal} {lang:nick} *</td>
		<td class="leftb"><input type="text" name="fightus_nick" value="{fightus:fightus_nick}" maxlength="40" size="40" /></td>
	</tr>
	<tr>
		<td class="leftc">{icon:mail_generic} {lang:email} *</td>
		<td class="leftb" colspan="2"><input type="text" name="fightus_email" value="{fightus:fightus_email}" maxlength="40" size="40" /></td>
	</tr>
	<tr>
		<td class="leftc">{icon:licq} {lang:icq}</td>
		<td class="leftb" colspan="2"><input type="text" name="fightus_icq" value="{fightus:fightus_icq}" maxlength="12" size="12" /></td>
	</tr>
	<tr>
		<td class="leftc">{icon:msn_protocol} {lang:msn}</td>
		<td class="leftb" colspan="2"><input type="text" name="fightus_msn" value="{fightus:fightus_msn}" maxlength="40" size="40" /></td>
	</tr>
	<tr>
		<td class="leftc">{icon:package_games} {lang:game}</td>
		<td class="leftb">
			<select name="games_id" class="form" onchange="document.getElementById('game_1').src='/uploads/games/' + this.form.games_id.options[this.form.games_id.selectedIndex].value + '.gif'">
				<option value="0">----</option>
			</select>
			{fightus:games_img}
		</td>
	</tr>
	<tr>
		<td class="leftc">{icon:yast_group_add} {lang:squad}</td>
		<td class="leftb">
			{fightus:squad_sel}
		</td>
	</tr>
	<tr>
		<td class="leftc">{icon:kdmconfig} {lang:clan} *</td>
		<td class="leftb"><input type="text" name="fightus_clan" value="{fightus:fightus_clan}" maxlength="200" size="50" /></td>
	</tr>
	<tr>
		<td class="leftc">{icon:signature} {lang:short} *</td>
		<td class="leftb"><input type="text" name="fightus_short" value="{fightus:fightus_short}" maxlength="20" size="12" /></td>
	</tr>
	<tr>
		<td class="leftc">{icon:locale} {lang:country}</td>
		<td class="leftb">
			{fightus:country_sel}
			{fightus:country_img}
		</td>
	</tr>
	<tr>
		<td class="leftc">{icon:gohome} {lang:url}</td>
		<td class="leftb">http://<input type="text" name="fightus_url" value="{fightus:fightus_url}" maxlength="80" size="50" /></td>
	</tr>
	<tr>
		<td class="leftc">{icon:1day} {lang:fight_date} *</td>
		<td class="leftb">
			{fightus:date_sel}
		</td>
	</tr>
	<tr>
		<td class="leftc">{icon:info} {lang:info}<br />
			<br />
			{fightus:abcode_smileys}
		</td>
		<td class="leftb">
			{fightus:abcode_features}
			<textarea name="fightus_more" cols="50" rows="12" id="fightus_more">{fightus:fightus_more}</textarea>
		</td>
	</tr>
	{if:captcha}
	<tr>
		<td class="leftc">{icon:lockoverlay} {lang:security_code} *</td>
		<td class="leftb">
			{fightus:captcha_img}<br />
			<input type="text" name="captcha" value="" maxlenght="8" size="8" />
		</td>
	</tr>
	{stop:captcha}
	<tr>
		<td class="leftc">{icon:ksysguard} {lang:options}</td>
		<td class="leftb">
			<input type="submit" name="submit" value="{lang:submit}" />
			<input type="reset" name="reset" value="{lang:reset}" />
		</td>
	</tr>
</table>
</form>
