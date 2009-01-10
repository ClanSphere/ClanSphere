<div class="container" style="width:{page:width};">
    <div class="headb">{lang:mod}</div>
    <div class="leftb">{lang:body_list}</div>
    <div class="leftb"><a href="{url:board_search}">{lang:board_search}</a></div>
</div>
<br />
<form method="post" name="search_list" action="{url:search_list}">
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width};">
  <tr>
    <td class="leftc">{icon:kedit} {lang:text} *</td>
    <td class="leftb"><input type="text" name="text" value="{if:text}{search:text}{stop:text}" maxlength="200" size="50"  /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:kcmdf} {lang:modul} *</td>
    <td class="leftb">
	<select name="where" >
    <option value="0">----</option>
	<option value="articles" {search:articles_check}>{lang:articles}</option>
	<option value="clans" {search:clans_check}>{lang:clans}</option>
    <option value="news" {search:news_check}>{lang:news}</option>
    <option value="users" {search:users_check}>{lang:user}</option>
    <option value="files" {search:files_check}>{lang:files}</option>
	</select>
	</td>
  </tr>
  <tr>
  	<td class="leftc">{icon:ksysguard} {lang:options}</td>
	<td class="leftb"><input type="submit" name="submit" value="{lang:search}" />
	<input type="reset" name="reset" value="{lang:reset}" /></td>
  </tr>
</table>
</form>
<br />
{if:errmsg}
<div class="container" style="width:{page:width};">
	<div class="leftc">{search:errmsg}</div>
</div>
{stop:errmsg}