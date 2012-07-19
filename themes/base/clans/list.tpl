<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name} - {lang:head_list}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:contents} {lang:all} {lang:count}</td>
    <td class="rightb">{pages:list}</td>
  </tr>
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:country}</td>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{sort:short} {lang:short} </td>
  </tr>
  {loop:clans}
  <tr>
    <td class="leftc" style="width:5%">{clans:country}</td>
    <td class="leftc" style="width:60%">{clans:name}</td>
    <td class="leftc" style="width:35%">{clans:short}</td>
  </tr>
  {stop:clans}
</table>
