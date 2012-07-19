<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:users}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:addons}</td>
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
    <td class="headb">{sort:clans} {lang:clans}</td>
    <td class="headb">{sort:squads} {lang:squads}</td>
    <td class="headb">{lang:task}</td>
    <td class="headb">{sort:joined} {lang:joined}</td>
  </tr>
  {loop:clans}
  <tr>
    <td class="leftc">{clans:name}</td>
    <td class="leftc">{clans:short}</td>
    <td class="leftc">{clans:task}</td>
    <td class="leftc">{clans:since}</td>
  </tr>
  {stop:clans}
</table>
