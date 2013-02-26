<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:mod_name} - {lang:head_list}</td>
  </tr>
  <tr>
    <td class="leftb">
      {head:addons}
    </td>
  </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftb">{icon:editpaste} {head:new_entry}</td>
    <td class="leftb">{lang:total}: {head:count}</td>
    <td class="rightb">{head:pages}</td>
  </tr>
</table>
<br />

{head:getmsg}

{loop:gbook}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftb" style="width:160px"># {gbook:entry_count} <br />
      {icon:personal} {gbook:users_nick} <br />
      {gbook:icon_town} {gbook:town} <br />
      {gbook:icon_mail} {gbook:icon_icq} {gbook:icon_jabber} {gbook:icon_skype} {gbook:icon_url}<br />
    </td>
    <td class="leftc">{gbook:text}</td>
  </tr>
  <tr>
    <td class="leftb">{gbook:time}</td>
    <td class="leftc"><div style="float:right">{gbook:icon_edit} {gbook:icon_remove} {gbook:icon_ip}</div></td>
  </tr>
</table>
<br />
{stop:gbook}