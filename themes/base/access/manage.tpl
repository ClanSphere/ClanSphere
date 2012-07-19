<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name} - {lang:head_manage}</td>
  </tr>
  <tr>    
    <td class="leftb">{icon:contents} {lang:total}: {lang:count}</td>
    <td class="rightb">{pages:list}</td>
  </tr>
</table>
<br />
{lang:getmsg}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{sort:access} {lang:access}</td>
    <td class="headb">{sort:clansphere} ClanSphere</td>
    <td class="headb" colspan="3">{lang:options}</td>
  </tr>
  {loop:access}
  <tr>
    <td class="leftc">{access:name}</td>
    <td class="leftc">{access:access}</td>
    <td class="leftc">{access:clansphere}</td>
    <td class="leftc">{access:edit}</td>
    <td class="leftc">{access:remove}</td>
    <td class="leftc">{access:users}</td>
  </tr>
  {stop:access}
</table>
