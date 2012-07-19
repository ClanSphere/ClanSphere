<form method="post" id="gbook_create" action="{url:gbook_manage}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:mod_name} - {lang:manage}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:editpaste} <a href="{url:gbook_entry:from=manage}">{lang:submit}</a></td>
    <td class="leftb">{icon:contents} {lang:total}: {head:count}</td>
    <td class="rightb">{head:pages}</td>
  </tr>
  <tr>
    <td class="leftb" colspan="3">
      {icon:editpaste} {lang:user_gb} 
      <input type="text" name="user_gb" value="{head:user_gb}" maxlength="200" size="20" />
      <input type="submit" name="submit" value="{lang:show}" />
    </td>
  </tr>
</table>
</form>
<br />

{head:getmsg}

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:nick}</td>
    <td class="headb">{sort:email} {lang:email}</td>
    <td class="headb">{sort:time} {lang:date}</td>
    <td class="headb" style="width:20%">{lang:options}</td>
  </tr>
  {loop:gbook}
  <tr>
    <td class="leftc">{gbook:nick}</td>
    <td class="leftc">{gbook:email}</td>
    <td class="leftc">{gbook:time}</td>
    <td class="leftc">
      {gbook:lock}
      <a href="{url:gbook_edit:id={gbook:id}&from=manage}" title="{lang:edit}">{icon:edit}</a>
      <a href="{url:gbook_remove:id={gbook:id}&from=manage}" title="{lang:remove}">{icon:editdelete}</a>
      {gbook:ip}
    </td>
  </tr>
  {stop:gbook}
</table>