<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:users_gallery} - {lang:center}</td>
  </tr>
    {center:head}
  <tr>
    <td class="leftb">{icon:editpaste} <a href="{url:usersgallery_users_create}">{lang:new_pic}</a></td>
    <td class="leftb">{icon:contents} {lang:total}: {head:count}</td>
    <td class="rightb">{head:pages}</td>
  </tr>
</table>
<br />

{head:getmsg}

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:id}</td>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{sort:folder} {lang:folders}</td>
    <td class="headb">{sort:date} {lang:date}</td>
    <td class="headb">{lang:options}</td>
  </tr>
  {loop:pictures}
  <tr>
    <td class="leftc {pictures:class}" style="width:85px">
      <a href="{pictures:link}" style="background:url({page:path}mods/gallery/image.php?usersthumb={pictures:id}) no-repeat center;height:50px;width:80px;display:block"></a>
    </td>
    <td class="leftc {pictures:class}"><strong>{pictures:name}</strong></td>
    <td class="leftc {pictures:class}">{pictures:folder}</td>
    <td class="leftc {pictures:class}">{pictures:time}</td>
    <td class="leftc {pictures:class}" style="width:60px">
      <a href="{url:usersgallery_users_edit:id={pictures:id}}" title="{lang:edit}">{icon:edit}</a>
      <a href="{url:usersgallery_users_remove:id={pictures:id}}" title="{lang:remove}">{icon:editdelete}</a>
    </td>
  </tr>
  {stop:pictures}
</table>