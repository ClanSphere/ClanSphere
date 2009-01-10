<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="3">{lang:users_gallery} - {lang:manage}</td>
 </tr>
 <tr>
  <td class="leftb" style="width:33%">{icon:picture} {link:picture}</td>
  <td class="leftb" style="width:33%">{icon:folder_yellow} {link:folder}</td>
  <td class="rightb">{icon:info} {link:info}</td>
 </tr>
 <tr>
  <td class="leftb">{icon:editpaste} {link:new}</td>
  <td class="leftb">{icon:contents} {lang:all} {data:count}</td>
  <td class="rightb">{data:pages}</td>
 </tr>
</table>

<br />
{lang:getmsg}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="leftb">{lang:folders}</td>
  <td class="rightb" width="60" colspan="2">{lang:options}</td>
 </tr>{loop:folders}
  {folders:box}
  {stop:folders}
</table>