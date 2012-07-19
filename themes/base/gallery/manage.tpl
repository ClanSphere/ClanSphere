<table class="forum" cellpadding="0" cellspacing="{page:cellspacig}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="5">{lang:mod_name} - {lang:manage_pic}</td>
  </tr>
  {manage:head}
  <tr>
    <td class="leftb" colspan="2">{icon:editpaste} <a href="{url:gallery_picture_create}">{lang:new_pic}</a></td>
    <td class="leftb" colspan="2">{icon:contents} {lang:total}: {head:count}</td>
    <td class="rightb" colspan="1">{head:pages}</td>
  </tr>
  <tr>
    <td class="leftb" colspan="6">
      <form method="post" id="filter" action="{url:gallery_manage}">
      {icon:folder_yellow} {dropdown:folders}
      {icon:access} {dropdown:access}
      <input type="submit" name="submit" value="{lang:show}" />
      </form>
    </td>
  </tr>
</table>
<br />

{head:getmsg}

<table class="forum" cellpadding="0" cellspacing="{page:cellspacig}" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:id}</td>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{sort:folders} {lang:folders}</td>
    <td class="headb">{sort:time} {lang:date}</td>
    <td class="headb">{lang:options}</td>
  </tr>
  {loop:pictures}
  <tr>
    <td class="leftc {pictures:class}" style="width:85px">
      <a href="{pictures:link}" style="background:url({page:path}mods/gallery/image.php?thumb={pictures:id}) no-repeat center;height:50px;width:80px;display:block"></a>
    </td>
    <td class="leftc {pictures:class}"><strong>{pictures:name}</strong></td>
    <td class="leftc {pictures:class}">{pictures:folder}</td>
    <td class="leftc {pictures:class}">{pictures:time}</td>
    <td class="leftc {pictures:class}" style="width:60px">
      <a href="{url:gallery_picture_edit:id={pictures:id}}" title="{lang:edit}">{icon:edit}</a>
      <a href="{url:gallery_remove:id={pictures:id}}" title="{lang:remove}">{icon:editdelete}</a>
    </td>
  </tr>
  {stop:pictures}
</table>