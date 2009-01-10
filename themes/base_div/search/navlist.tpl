<form method="post" name="search_list" action="{url:search_list}">
<table style="width:{page:width}" cellpadding="0" cellspacing="1">
	<tr>
		<td class="left">
			<input type="text" name="text" value="{if:text}{search:text}{stop:text}" maxlength="200" size="15" class="form" />
			<select name="where" class="form">
				<option value="0">{lang:modul}</option>
				<option value="articles" {search:articles_check}>{lang:articles}</option>
				<option value="clans" {search:clans_check}>{lang:clans}</option>
				<option value="news" {search:news_check}>{lang:news}</option>
				<option value="users" {search:users_check}>{lang:user}</option>
				<option value="files" {search:files_check}>{lang:files}</option>
			</select>
		</td>
	</tr>
	<tr>
		<td class="center">
			<input type="submit" name="submit" value="{lang:search}" />
			<input type="reset" name="reset" value="{lang:reset}" />
		</td>
	</tr>
</table>
</form>