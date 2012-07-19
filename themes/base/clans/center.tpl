<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:mod_name} - {lang:center}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:editpaste} {lang:new}</td>
    <td class="leftb">{icon:contents} {lang:all} {lang:count}</td>
    <td class="rightb">{pages:list}</td>
  </tr>
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:name}</td>
    <td class="headb">{lang:short}</td>
    <td class="headb" colspan="2" style="width:50px">{lang:options}</td>
  </tr>
  {loop:clans}
  <tr>
    <td class="leftc">{clans:name}</td>
    <td class="leftc">{clans:short}</td>
    <td class="leftc" style="width:25px">{clans:edit}</td>
    <td class="leftc" style="width:25px">{clans:remove}</td>
  </tr>
  {stop:clans}
</table>

