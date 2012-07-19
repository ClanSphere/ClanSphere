<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="2">{head:mod} - {lang:head_list}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:contents} {lang:total}: {head:count}</td>
    <td class="rightb">{head:pages}</td>
  </tr>
</table>
<br />

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" style="width:12%">{lang:game}</td>
    <td class="headb">{sort:squads_name} {lang:squads_label}</td>
    <td class="headb">{sort:clans_name} {lang:clans_label}</td>
  </tr>
  {loop:squads}
  <tr>
    <td class="leftc">{squads:games_img}</td>
    <td class="leftc"><a href="{url:squads_view:id={squads:id}}">{squads:squads_name}</a></td>
    <td class="leftc"><a href="{url:clans_view:id={squads:clans_id}}">{squads:clans_name}</a></td>
  </tr>
  {stop:squads}
</table>