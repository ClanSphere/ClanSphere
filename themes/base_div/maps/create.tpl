<div class="container" style="width:{page:width}">
		<div class="headb">{lang:mod} - {lang:create}</div>
		<div class="leftc">{maps:message}</div>
</div>
<br />
<form method="post" name="maps_create" action="{maps:action}" enctype="multipart/form-data">
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
	<tr>
		<td class="leftc">{icon:folder_yellow} {lang:name} *</td>
		<td class="leftb"><input type="text" name="maps_name" value="{maps:maps_name}" maxlength="80" size="40"  /></td>
	</tr>
	<tr>
		<td class="leftc">{icon:package_games} {lang:game} *</td>
		<td class="leftb">
			<select name="games_id"  onchange="cs_gamechoose(this.form)">
			<option value="0">----</option>{loop:games}
			<option value="{games:games_id}"{games:selection}>{games:games_name}</option>{stop:games}
			</select>
			<img src="{page:path}uploads/games/0.gif" id="game_1" alt="" />
		</td>
	</tr>
	<tr>
		<td class="leftc">{icon:kate} {lang:text}<br />
        <br />
        {abcode:smileys}</td>
		<td class="leftb">{abcode:features}
			<textarea name="maps_text" cols="50" rows="8" id="maps_text"  style="width: 98%;">{maps:maps_text}</textarea>
		</td>
    </tr>
	<tr>
		<td class="leftc">{icon:download} {lang:pic_up}</td>
		<td class="leftb"><input type="file" name="picture" value=""  /><br /><br />{maps:matches}</td>
	</tr>
	<tr>
		<td class="leftc">{icon:ksysguard} {lang:options}</td>
		<td class="leftb">
			<input type="submit" name="submit" value="{lang:create}"  />
			<input type="reset" name="reset" value="{lang:reset}"  />
		</td>
	</tr>
</table>
</form>
				