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
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{lang:user}</td>
    <td class="headb" colspan="3">{lang:options}</td>
  </tr>{loop:medals}
  <tr>
    <td class="leftb">{medals:medals_name}</td>
    <td class="leftb">{medals:count_user} {lang:awarded}</td>
    <td class="leftb"><a href="{medals:view_user}">{icon:kdmconfig}</a></td>
    <td class="leftb"><a href="{medals:edit_url}">{icon:edit}</a></td>
    <td class="leftb"><a href="{medals:remove_url}">{icon:editdelete}</a></td>
  </tr>{stop:medals}
</table>