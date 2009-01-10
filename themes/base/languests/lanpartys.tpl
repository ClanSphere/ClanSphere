<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:mod} - {lang:head_lanpartys}</td>
  </tr>
  <tr>
    <td class="leftb" colspan="2">{lang:addons}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:total}: {count:all}</td>
    <td class="rightb">{pages:list}</td>
  </tr>
  <tr>
    <td class="centerc" colspan="3">{lang:body}</td>
  </tr>
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:nick} {lang:nick}</td>
    <td class="headb">{sort:team} {lang:team}</td>
    <td class="headb">{sort:status} {lang:status}</td>
  </tr>
  {loop:lanquests}
  <tr>
    <td class="leftc">{lanquests:nick}</td>
    <td class="leftc">{lanquests:team}</td>
    <td class="leftc">{lanquests:status}</td>
  </tr>
  {stop:lanquests}
</table>
