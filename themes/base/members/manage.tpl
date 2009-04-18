<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="4">{lang:mod_name} - {lang:manage}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:editpaste} {lang:link}</td>
    <td class="leftb">{icon:contents} {lang:total}: {lang:all}</td>
    <td class="leftb">{icon:package_settings} {member:options}</td>
    <td class="rightb">{pages:list}</td>
  </tr>
</table>
<br />
{lang:getmsg}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:user} {lang:user}</td>
    <td class="headb">{sort:team} {lang:team}</td>
    <td class="headb" style="width:60px"> {lang:order}</td>
    <td class="headb" colspan="2"> {lang:options}</td>
  </tr>
  
  
  {loop:members}
  <tr>
    <td class="leftc">{members:user}</td>
    <td class="leftc">{members:team}</td>
    <td class="leftc">{members:order}</td>
    <td class="leftc">{members:edit}</td>
    <td class="leftc">{members:remove}</td>
  </tr>
  {stop:members}
</table>