<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:users_gallery} - {lang:folders}</td>
  </tr>
    {center:head}
  <tr>
    <td class="leftb">{icon:editpaste} <a href="{url:usersgallery_folders_create}">{lang:new_folder}</a></td>
    <td class="leftb">{icon:contents} {lang:total}: {head:count}</td>
    <td class="rightb">{head:pages}</td>
  </tr>
</table>
<br />

{head:getmsg}

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb" style="width:40px">{lang:options}</td>
  </tr>
  {loop:folders}
  <tr>
    <td class="leftc">{folders:layer}{folders:name} ({folders:count})</td>
    <td class="leftc">
      <a href="{url:usersgallery_folders_edit:id={folders:folders_id}}" title="{lang:edit}">{icon:edit}</a>
      <a href="{url:usersgallery_folders_remove:id={folders:folders_id}}" title="{lang:remove}">{icon:editdelete}</a>
    </td>
  </tr>
  {stop:folders}
</table>