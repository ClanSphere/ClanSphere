<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="1">
  <tr>
    <td class="headb" colspan="3">{lang:mod} - {lang:manage}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:editpaste} <a href="{url:medals_create}" >{lang:new_medal}</a></td>
    <td class="leftb">{icon:contents} {lang:total}: {count:medals}</td>
	<td class="rightb">{pages:list}</td>
  </tr>
</table>
<br />
{message:medals}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="1">
  <tr>
    <td class="headb">{sort:date} {lang:date}</td>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{sort:users_nick} {lang:user}</td>
    <td class="headb" colspan="2">{lang:options}</td>
  </tr>{loop:medals}
  <tr>
    <td class="leftb">{medals:medals_date}</td>
    <td class="leftb"><a href="{medals:medals_url}">{medals:medals_name}</a></td>
    <td class="leftb"><a href="{medals:users_url}">{medals:users_nick}</a></td>
    <td class="leftb"><a href="{medals:edit_url}">{icon:edit}</a></td>
    <td class="leftb"><a href="{medals:remove_url}">{icon:editdelete}</a></td>
  </tr>{stop:medals}
</table>