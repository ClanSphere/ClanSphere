<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:mod} - {lang:head_manage}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:editpaste} {lang:new}</td>
    <td class="leftb">{icon:contents} {lang:all} {lang:count}</td>
    <td class="rightb">{pages:list}</td>
  </tr>
</table>
<br />
{head:message}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{sort:start} {lang:start}</td>
    <td class="headb" colspan="3">{lang:options}</td>
  </tr>
  {loop:lanpartys}
  <tr>
    <td class="leftc">{lanpartys:name}</td>
    <td class="leftc">{lanpartys:start}</td>
    <td class="leftc">{lanpartys:picture}</td>
    <td class="leftc">{lanpartys:edit}</td>
    <td class="leftc">{lanpartys:remove}</td>
  </tr>
  {stop:lanpartys}
</table>
