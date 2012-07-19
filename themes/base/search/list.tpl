<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width};">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_list}</td>
    <td class="rightb"><a href="{url:board_search}">{lang:board_search}</a></td>
  </tr>
</table>
<br />
<form method="post" id="search_list" action="{url:search_list}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width};">
  <tr>
    <td class="leftc">{icon:kedit} {lang:text} *</td>
    <td class="leftb"><input type="text" name="text" value="{if:text}{search:text}{stop:text}" maxlength="200" size="50" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:kcmdf} {lang:modul} *</td>
    <td class="leftb">
  <select name="where">
    <option value="0">----</option>
    {if:articles}<option value="articles" {search:articles_check}>{lang:articles}</option>{stop:articles}
    {if:clans}<option value="clans" {search:clans_check}>{lang:clans}</option>{stop:clans}
    {if:news}<option value="news" {search:news_check}>{lang:news}</option>{stop:news}
    {if:users}<option value="users" {search:users_check}>{lang:user}</option>{stop:users}
    {if:files}<option value="files" {search:files_check}>{lang:files}</option>{stop:files}
  </select>
  </td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
  <td class="leftb"><input type="submit" name="submit" value="{lang:search}" />
  </td>
  </tr>
</table>
</form>
<br />
{if:errmsg}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width};">
  <tr>
  <td class="leftc">{search:errmsg}</td>
  </tr>
</table>
{stop:errmsg}