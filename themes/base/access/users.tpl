<form method="post" action="{url:access_users}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{access:name} - {lang:add_user}</td>
  </tr>
  <tr>
    <td class="leftb">{head:msg}</td>
  </tr>
  <tr>
    <td class="leftb">
    <input type="text" name="users_nick" id="users_nick" autocomplete="off" onkeyup="Clansphere.ajax.user_autocomplete('users_nick', 'search_users_result' ,'{page:path}')" maxlength="80" size="40" /><br />
    <div id="search_users_result"></div>
    <input type="submit" name="submit" value="{lang:submit}" />
    <input type="hidden" name="id" value="{access:id}" />
  </td>
  </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{access:name} - {lang:user_list}</td>
  </tr>
  {loop:users}
  <tr>
    <td class="leftb">{users:nick}</td>
  </tr>
  {stop:users}
</table>
</form>