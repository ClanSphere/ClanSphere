<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="3">{head:mod} - {lang:manage}</td>
  </tr>
  <tr>    
    <td class="leftb">{icon:contents} {lang:total}: {head:count}</td>    
    <td class="rightb">{head:pages}</td>
  </tr>
</table>
<br />

{head:getmsg}

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{sort:squads_name} {lang:squad_label}</td>
    <td class="headb">{sort:clans_name} {lang:clans_label}</td>
    <td class="headb" colspan="2">{lang:options}</td>
  </tr>
  {loop:squads}
  <tr>
    <td class="leftc"><a href="{url:squads_view:id={squads:id}}">{squads:squads_name}</a></td>
    <td class="leftc"><a href="{url:clans_view:id={squads:clans_id}}">{squads:clans_name}</a></td>
    <td class="leftc"><a href="{url:squads_edit:id={squads:id}}" title="{lang:edit}">{icon:edit}</a></td>
    <td class="leftc"><a href="{url:squads_remove:id={squads:id}}" title="{lang:remove}">{icon:editdelete}</a></td>
  </tr>
  {stop:squads}
</table>