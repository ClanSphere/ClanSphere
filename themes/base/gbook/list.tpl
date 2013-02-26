<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:mod_name} - {lang:head_list}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:editpaste} {head:entry}</td>
    <td class="leftb">{icon:contents} {lang:total}: {head:count}</td>
    <td class="rightb">{head:pages}</td>
  </tr>
</table>
<br />

{head:getmsg}

{loop:gbook}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc" style="width:160px"># {gbook:entry_count}<br />
        {gbook:time} <br /><br />
      {icon:personal} {gbook:users_nick} <br />
      {gbook:icon_town} {gbook:town} <br /><br />
      {gbook:icon_mail} {gbook:icon_icq} {gbook:icon_jabber} {gbook:icon_skype} {gbook:icon_url}<br />
    </td>
    <td class="leftb">{gbook:text}</td>
  </tr>
  {if:admin}
  <tr>    
    <td class="bottom" colspan="2">
      <div style="float:right">{gbook:icon_edit}
        {gbook:icon_remove}
        {gbook:icon_ip}
      </div>
    </td>
  </tr>
  {stop:admin}
</table>
<br />
{stop:gbook}