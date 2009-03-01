<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod} - {lang:head_users}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:addons}</td>
  </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="rightb">{pages:list}</td>
  </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{sort:start} {lang:start}</td>
    <td class="headb">{sort:status} {lang:status}</td>
  </tr>

  {loop:lanpartys}
  <tr>
    <td class="leftc">{lanpartys:name}</td>
    <td class="leftc">{lanpartys:start}</td>
    <td class="leftc">{lanpartys:status}</td>
  </tr>
  {stop:lanpartys}
</table>