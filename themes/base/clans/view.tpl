<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:details}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:info_about_group}</td>
  </tr>
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc" style="width:140px">{icon:kdmconfig} {lang:name}</td>
    <td class="leftb">{clans:name}</td>
    <td class="centerc" rowspan="5" style="width:120px"><br />
      {clans:img}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:signature} {lang:short}</td>
    <td class="leftb">{clans:short}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:locale} {lang:country}</td>
    <td class="leftb">{clans:country}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:gohome} {lang:url}</td>
    <td class="leftb">{clans:url}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:1day} {lang:since}</td>
    <td class="leftb">{clans:since}</td>
  </tr>
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" style="width:50px">{lang:game}</td>
    <td class="headb">{lang:squads}</td>
    <td class="headb">{lang:members}</td>
  </tr>
  {loop:squads}
  <tr>
    <td class="leftc">{squads:game}</td>
    <td class="leftc">{squads:squads}</td>
    <td class="leftc">{squads:members}</td>
  </tr>
  {stop:squads}
</table>
