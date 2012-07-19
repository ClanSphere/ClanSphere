<form method="post" id="notifymods_manage" action="{url:notifymods_manage}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name} - {lang:manage}</td>
  </tr>
  <tr>    
    <td class="leftb">{icon:contents} {lang:total}: {head:count}</td>
    <td class="rightb">{head:pages}</td>
  </tr>
</table>
</form>
<br />
{head:getmsg}

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{sort:users_nick} {lang:user}</td>
    <td class="headb">{lang:gbook}</td>
    <td class="headb">{lang:joinus}</td>
    <td class="headb">{lang:fightus}</td>
    <td class="headb">{lang:files}</td>
    <td class="headb">{lang:board}</td>
    <td class="headb" colspan="2">{lang:options}</td>
  </tr>
  {loop:nm}
  <tr>
    <td class="leftc">{nm:notifymods_user}</td>
    <td class="leftc">{nm:notifymods_gbook}</td>
    <td class="leftc">{nm:notifymods_joinus}</td>
    <td class="leftc">{nm:notifymods_fightus}</td>
    <td class="leftc">{nm:notifymods_files}</td>
    <td class="leftc">{nm:notifymods_board}</td>
    <td class="leftc"><a href="{nm:url_edit}" title="{lang:edit}">{icon:edit}</a></td>
    <td class="leftc"><a href="{nm:url_remove}" title="{lang:remove}">{icon:editdelete}</a></td>
  </tr>
  {stop:nm}
</table>
