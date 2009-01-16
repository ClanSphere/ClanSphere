<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb">{head:mod} - {lang:edit}</td>
	</tr>
	<tr>
		<td class="leftc">{head:body}</td>
	</tr>
</table>
<br />

<form method="post" name="squads_edit" action="{url:squads_edit}" enctype="multipart/form-data">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="leftc">{icon:yast_group_add} {lang:name} *</td>
		<td class="leftb"><input type="text" name="squads_name" value="{squads:squads_name}" maxlength="80" size="40" /></td>
	</tr>
	<tr>
		<td class="leftc">{icon:kdmconfig} {lang:own_label}</td>
		<td class="leftb"><input type="checkbox" name="squads_own" value="1" {squads:own_check} /></td>
	</tr>
	<tr>
		<td class="leftc">{icon:lock} {lang:hidden}</td>
		<td class="leftb">
			<input type="checkbox" name="squads_joinus" value="joinus" {squads:joinus_check} />{lang:joinus}<br />
			<input type="checkbox" name="squads_fightus" value="fightus" {squads:fightus_check} />{lang:fightus}
		</td>
	</tr>
	<tr>
		<td class="leftc">{icon:kdmconfig} {lang:clan_label} *</td>
		<td class="leftb">
			{squads:clan_sel}
		</td>
	</tr>
	<tr>
		<td class="leftc">{icon:package_games} {lang:game}</td>
		<td class="leftb">
			<select name="games_id" onchange="document.getElementById('game_1').src='/uploads/games/' + this.form.games_id.options[this.form.games_id.selectedIndex].value + '.gif'">
				<option value="0">----</option>
				{squads:games_sel}
			</select>
			{squads:games_img}
		</td>
	</tr>
	<tr>
		<td class="leftc">{icon:enumList} {lang:order}</td>
		<td class="leftb"><input type="text" name="squads_order" value="{squads:squads_order}" maxlength="4" size="4" /></td>
	</tr>
	<tr>
		<td class="leftc" rowspan="2">{icon:password} {lang:password}</td>
		<td class="leftb"><input type="password" name="squads_pwd" value="" onkeydown="javascript:passwordcheck(this.value);" onkeyup="javascript:passwordcheck(this.value);" maxlength="30" size="30" /></td>
	</tr>
	<tr>
		<td class="leftb">
			<div style="float:left; background-image:url(/symbols/votes/vote03.png); width:100px; height:13px; margin-top: 3px; margin-left: 2px;">
				<div style="float:left; background-image:url(/symbols/votes/vote01.png); width: 1px; height: 13px;" id="pass_secure"></div>
			</div>
			<div style="float:left; padding-left: 3px; padding-top: 3px; display:none" id="pass_stage_1">{lang:stage_1}</div>
			<div style="float:left; padding-left: 3px; padding-top: 3px; display:none" id="pass_stage_2">{lang:stage_2}</div>
			<div style="float:left; padding-left: 3px; padding-top: 3px; display:none" id="pass_stage_3">{lang:stage_3}</div>
			<div style="float:left; padding-left: 3px; padding-top: 3px; display:none" id="pass_stage_4">{lang:stage_4}</div>
			<div style="clear:both">
				{squads:secure_clip}
			</div>
		</td>
	</tr>
	<tr>
		<td class="leftc">{icon:images} {lang:pic_current}</td>
		<td class="leftb">{squads:current_pic}</td>
	</tr>
	<tr>
		<td class="leftc">{icon:download} {lang:pic_up}</td>
		<td class="leftb">
			<input type="file" name="picture" value="" />
			<input type="hidden" name="squads_picture" value="{squads:squads_picture}" /><br />
			<br />
			{squads:picup_clip}
		</td>
	</tr>
	{if:advanced}
	<tr>
		<td class="leftc">{icon:configure} {lang:more}</td>
		<td class="leftb"><input type="checkbox" name="delete" value="1" />{lang:remove}</td>
	</tr>
	{stop:advanced}
	<tr>
	  <td class="leftc">{icon:kate} {lang:text}</td>
	  <td class="leftb">{squads:abcode} <textarea name="squads_text" id="squads_text" cols="50" rows="10">{squads:squads_text}</textarea></td>
	</tr>
	<tr>
		<td class="leftc">{icon:ksysguard} {lang:options}</td>
		<td class="leftb">
			<input type="hidden" name="id" value="{squads:id}" />
			<input type="submit" name="submit" value="{lang:edit}" />
			<input type="reset" name="reset" value="{lang:reset}" />
		</td>
	</tr>
</table>
</form>