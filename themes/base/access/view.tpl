<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:head_view}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_view}</td>
  </tr>
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
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
