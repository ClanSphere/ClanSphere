<form method="post" id="search_list" action="{url:search_list}">
<table style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="left">
      <input type="text" name="text" value="{if:text}{search:text}{stop:text}" maxlength="200" size="15" />
      <select name="where">
        <option value="0">{lang:modul}</option>
        {if:articles}<option value="articles" {search:articles_check}>{lang:articles}</option>{stop:articles}
        {if:clans}<option value="clans" {search:clans_check}>{lang:clans}</option>{stop:clans}
        {if:news}<option value="news" {search:news_check}>{lang:news}</option>{stop:news}
        {if:users}<option value="users" {search:users_check}>{lang:user}</option>{stop:users}
        {if:files}<option value="files" {search:files_check}>{lang:files}</option>{stop:files}
      </select>
    </td>
  </tr>
  <tr>
    <td class="center">
      <input type="submit" name="submit" value="{lang:search}" />
          </td>
  </tr>
</table>
</form>