<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:head_view}</div>
    <div class="leftb">{lang:body_view}</div>
</div>
<br />

<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  <tr>
    <td class="leftc">{icon:access} {lang:name}</td>
    <td class="leftb">{lang:name}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:package_system} ClanSphere</td>
    <td class="leftb">{lang:clansphere} </td>
  </tr>
  {loop:access}
  <tr>
    <td class="leftc">{access:icon} {access:name}</td>
    <td class="leftb">{access:access}</td>
  </tr>
  {stop:access}
</table>
