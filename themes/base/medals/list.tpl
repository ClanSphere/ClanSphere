<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:list}</td>
  </tr>
  <tr>
    <td class="leftc">{pages:list}</td>
  </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:user}</td>
    <td class="headb">{lang:mod_name}</td>
  </tr>{loop:users}
  <tr>
    <td class="leftb">{users:user}</td>
    <td class="leftc"><a href="{url:medals_users:id={users:users_id}}">{users:medals}</a></td>
  </tr>{stop:users}
</table>