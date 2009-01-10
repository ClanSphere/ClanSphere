<br />
<form method="post" name="{page:mod}_com_create" action="{url:create}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
	{if:adv_com}
	<tr>
		<td class="leftc" colspan="2"><input type="submit" name="advanced" value="{lang:adv_com}" /></td>
	</tr>
	{stop:adv_com}
	<tr>
		<td class="leftc" style="width: 115px;">{icon:kopete} {lang:comment} *<br />
			<br />
			{comments:smilies}
		</td>
		<td class="leftb">
			{comments:abcode}
			<textarea name="comments_text" cols="50" rows="8" id="comments_text" ></textarea>
		</td>
	</tr>
	<tr>
		<td class="leftc">{icon:ksysguard} {lang:options}</td>
		<td class="leftb">
			<input type="hidden" name="fid" value="{comments:fid}" />
			<input type="submit" name="submit" value="{lang:create}" />
			<input type="submit" name="preview" value="{lang:preview}" />
			<input type="reset" name="reset" value="{lang:reset}" />
		</td>
	</tr>
</table>
</form>