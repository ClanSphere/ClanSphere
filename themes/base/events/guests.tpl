<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:mod_name} - {lang:guests}</td>
  </tr>
  <tr>
    <td class="leftb" style="min-width: 30%">{lang:total}: {head:count}</td>
    <td class="centerb">
      {if:admin}<a href="{url:events_manage}">{lang:manage}</a>{stop:admin}
      {unless:admin}<a href="{url:events_agenda}">{lang:agenda}</a>{stop:admin}
    </td>
    <td class="rightb" style="min-width: 30%">{head:pages}</td>
  </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc" rowspan="2">{icon:cal} {lang:event}</td>
    <td class="leftb" colspan="4"><a href="{url:events_view:id={events:events_id}}">{events:events_name}</a></td>
  </tr>
  <tr>
    <td class="leftb" colspan="4">{events:time}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:organizer} {lang:needage}</td>
    <td class="leftb" colspan="4">{events:events_needage}</td>
  </tr>
  <tr>
    <td class="leftc" rowspan="2">{icon:kdmconfig} {lang:guests}</td>
    <td class="centerc">{lang:min}</td>
    <td class="centerc">{lang:max}</td>
    <td class="centerc">{lang:booked}</td>
    <td class="centerc">{lang:bookable}</td>
  </tr>
  <tr>
    <td class="centerb"><span style="text-decoration: underline">{events:events_guestsmin}</span></td>
    <td class="centerb"><strong>{events:events_guestsmax}</strong></td>
    <td class="centerb">{count:status_booked}</td>
    <td class="centerb">{count:status_available}</td>
  </tr>
  <tr>
    <td class="leftc" rowspan="2">{icon:status_unknown} {lang:status}</td>
    <td class="centerc">{lang:status_0}</td>
    <td class="centerc">{lang:status_3}</td>
    <td class="centerc">{lang:status_4}</td>
    <td class="centerc">{lang:status_5}</td>
  </tr>
  <tr>
    <td class="centerb">{count:status_0}</td>
    <td class="centerb">{count:status_3}</td>
    <td class="centerb">{count:status_4}</td>
    <td class="centerb">{count:status_5}</td>
  </tr>
</table>
<br />

{if:admin}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="centerb">{icon:yast_user_add} <a href="{url:events_guestsnew:events_id={events:events_id}}">{lang:new_guest}</a></td>
    <td class="centerb">{icon:printmgr} <a href="#" onclick="window.open('{page:path}features.php?mod=events&amp;action=guestsprint&amp;id={events:events_id}', '{lang:print_view}', 'width=800,height=600,scrollbars=yes'); return false">{lang:print_view}</a></td>
    <td class="centerb">{icon:7days} <a href="{url:events_guestsmulti:events_id={events:events_id}}">{lang:guests_multi}</a></td>
  </tr>
</table>
<br />
{stop:admin}

{head:getmsg}

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:user} {lang:user}</td>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{sort:time} {lang:date}</td>
    <td class="headb">{sort:status} {lang:status}</td>
{if:admin}
    <td class="headb" colspan="2">{lang:contact}</td>
    <td class="headb" colspan="3">{lang:options}</td>
{stop:admin}
  </tr>
  {loop:eventguests}
  <tr>
    <td class="leftc">{eventguests:user}</td>
    <td class="leftc">{eventguests:name}</td>
    <td class="leftc">{eventguests:since}</td>
    <td class="leftc">{eventguests:status}</td>
{if:admin}
    <td class="centerc">{eventguests:phone}</td>
    <td class="centerc">{eventguests:mobile}</td>
    <td class="centerc">{eventguests:notice}</td>
    <td class="centerc">{eventguests:edit}</td>
    <td class="centerc">{eventguests:remove}</td>
{stop:admin}
  </tr>
  {stop:eventguests}
</table>