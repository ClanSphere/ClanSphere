<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="3">{head:mod} - {lang:head_center}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:editpaste} <a href="{url:squads_new}">{lang:new_label}</a></td>
    <td class="leftb">{icon:contents} {lang:total}: {head:count}</td>
    <td class="rightb">{head:pages}</td>
  </tr>
</table>
<br />

{head:getmsg}

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="centerc"><a href="{url:squads_join}">{lang:join_label}</a></td>
    {if:squad_to_leave}
    <td class="centerc"><a href="{url:squads_leave}">{lang:leave_label}</a></td>
    {stop:squad_to_leave}
  </tr>
</table>
<br />

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{sort:squad_name} {lang:label}</td>
    <td class="headb">{sort:members_task} {lang:task}</td>
    <td class="headb" colspan="3" style="width:20%">{lang:options}</td>
  </tr>
  {loop:squads}
  <tr>
    <td class="leftc"><a href="{url:squads_view:id={squads:id}}">{squads:name}</a></td>
    <td class="leftc">{squads:members_task}</td>
    {if:no_squad_admin}
    <td class="leftc" colspan="3">--</td>
    {stop:no_squad_admin}
    {if:squad_admin}
    <td class="leftc"><a href="{url:members_center:id={squads:id}}" title="{lang:head_center}">{icon:yast_user_add}</a></td>
    <td class="leftc"><a href="{url:squads_change:id={squads:id}}" title="{lang:edit}">{icon:edit}</a></td>
    <td class="leftc"><a href="{url:squads_remove:id={squads:id}}" title="{lang:remove}">{icon:editdelete}</a></td>
    {stop:squad_admin}
  </tr>
  {stop:squads}
</table>