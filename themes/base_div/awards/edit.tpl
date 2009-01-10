<div class="container" style="width:{page:width};">
		<div class="headb">{lang:mod} - {lang:head_edit}</div>
		<div class="leftb">{head:body_create}</div>
</div>
<br />

<form method="post" action="{url:awards_edit}">
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width};">
	<tr>
		<td class="leftc">{icon:kedit} {lang:event} *</td>
		<td class="leftb"><input type="text" name="awards_event" value="{awards:awards_event}" maxlength="200" size="50"  /></td>
	</tr>
	<tr>
		<td class="leftc">{icon:kedit} {lang:event_url} *</td>
		<td class="leftb">http://<input type="text" name="awards_event_url" value="{awards:awards_event_url}" maxlength="200" size="43"  /></td>
	</tr>
	<tr>
		<td class="leftc">{icon:package_games} {lang:game} *</td>
		<td class="leftb">{select:game} - <input type="text" name="games_name" value="" maxlength="200" size="25"  /></td>
	</tr>
	<tr>
		<td class="leftc">{icon:1day} {lang:date} *</td>
		<td class="leftb">{select:date}</td>
	</tr>
	<tr>
		<td class="leftc">{icon:kedit} {lang:place} *</td>
		<td class="leftb"><input type="text" name="awards_rank" value="{awards:awards_rank}" maxlength="3" size="3"  /></td>
	</tr>
	<tr>
		<td class="leftc">{icon:ksysguard} {lang:options}</td>
		<td class="leftb">
			<input type="submit" name="submit" value="{lang:create}" />
 			<input type="submit" name="preview" value="{lang:preview}" />
 			<input type="reset" name="reset" value="{lang:reset}" />
 			<input type="hidden" name="id" value="{awards:awards_id}" />
 		</td>
 	</tr>
</table>
</form>