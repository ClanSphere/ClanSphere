<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb">{lang:mod} - {lang:create}</td>
	</tr>
	<tr>
		<td class="leftb">{head:body}</td>
	</tr>
</table>
<br />

<form method="post" name="lanshop_create" action="{url:lanshop_create}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="leftb">{icon:folder_yellow} {lang:category} *</td>
		<td class="leftc">
			{ls:categories}
		</td>
	</tr>
	<tr>
		<td class="leftb">{icon:warehause} {lang:name} *</td>
		<td class="leftc"><input type="text" name="lanshop_articles_name" value="{data:lanshop_articles_name}" maxlength="80" size="40" /></td>
	</tr>
	<tr>
		<td class="leftb">{icon:money} {lang:price} *</td>
		<td class="leftc"><input type="text" name="lanshop_articles_price" value="{data:lanshop_articles_price}" maxlength="8" size="8" />{ls:price}</td>
	</tr>
	<tr>
		<td class="leftb">{icon:documentinfo} {lang:info}<br />
			<br />
			{abcode:smileys}
		</td>
		<td class="leftc">
			{abcode:features}
			<textarea name="lanshop_articles_info" cols="50" rows="6" id="lanshop_articles_info">{data:lanshop_articles_info}</textarea>
		</td>
	</tr>
	<tr>
		<td class="leftb">{icon:ksysguard} {lang:options}</td>
		<td class="leftc">
			<input type="submit" name="submit" value="{lang:submit}"/>
			<input type="reset" name="reset" value="{lang:reset}"/>
		</td>
	</tr>
</table>
</form>