<table class="forum" cellpadding="0" cellspacing="{page:cellspacig}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="5">{lang:mod_name} - {lang:folders}</td>
  </tr>
  {manage:head}
  <tr>
    <td class="leftb" colspan="2">{icon:editpaste} <a href="{url:gallery_folders_create}">{lang:new_folder}</a></td>
    <td class="leftb" colspan="2">{icon:contents} {lang:total}: {head:count}</td>
    <td class="rightb" colspan="1">{head:pages}</td>
  </tr>
</table>
<br />

{head:getmsg}

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:name} {lang:folders}</td>
    <td class="headb" style="width:80px">{lang:options}</td>
  </tr>
  {loop:folders}
  <tr>
    <td class="leftc">{folders:layer}{folders:name} ({folders:count})</td>
    <td class="leftc" style="width:40px">
      <a href="{url:gallery_folders_edit:id={folders:id}}" title="{lang:edit}">{icon:edit}</a>
      <a href="{url:gallery_folders_remove:id={folders:id}}" title="{lang:remove}">{icon:editdelete}</a>
    </td>
  </tr>
  {stop:folders}
</table>